<?php

/* 
 * Simple Source engine widget.
 * 
 * Copyright 2013 - 2015 EasyCoding Team (ECTeam).
 * Copyright 2005 - 2015 EasyCoding Team.
 * 
 * License: GNU GPL version 3.
 *
 * EasyCoding Team's official blog: http://www.easycoding.org/
 * Project's official webpage: http://www.easycoding.org/projects/srvwidget
 * 
 */

class Application
{	
	private static $SERVERS = [];
	private static $mlink;
	
	private function parseHeaders($header)
	{
		$result = [];
		$fields = explode("\r\n", preg_replace('/\x0D\x0A[\x09\x20]+/', ' ', $header));
		foreach($fields as $field)
		{
			if (preg_match('/([^:]+): (.+)/m', $field, $match))
			{
				$match[1] = preg_replace('/(?<=^|[\x09\x20\x2D])./e', 'mb_strtoupper("\0")', mb_strtolower(trim($match[1])));
				$result[$match[1]] = isset($result[$match[1]]) ? array($result[$match[1]], $match[2]) : trim($match[2]);
			}
		}
		return $result;
	}
	
	private function loadLocale($lang, $region)
	{
		putenv(sprintf("LANG=%s", $lang));
		setlocale(LC_ALL, sprintf("%s.UTF-8", $lang));
		bindtextdomain($region, "./locale");
		textdomain($region);
	}
	
	private function sendGETRequest($url, $useragent = 'wget')
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 4);
		curl_setopt($ch, CURLOPT_MAXREDIRS, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 5);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_REFERER, $url);
		curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch);
		$hcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		if ($hcode != 200) { throw new Exception(_("Steam API is down.")); }
		$hsize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
		$headers = self::parseHeaders(mb_substr($result, 0, $hsize));
		if (!isset($headers['X-Eresult']) || ($headers['X-Eresult'] != '1')) { throw new Exception(_("Steam API has returned incorrect values.")); }
		curl_close($ch);
		return mb_substr($result, $hsize);
	}
	
	private function resolveServersIPs($a)
	{
		$req = array('key' => Settings::STEAM_TOKEN, 'format' => 'xml', 'server_steamids' => $a);
		$xml = simplexml_load_string(self::sendGETRequest(sprintf('%s?%s', Settings::STEAM_URI, http_build_query($req))));
		if (is_object($xml) && is_object($xml -> servers))
		{
			foreach($xml -> servers -> message as $item)
			{
				self::$SERVERS[] = $item -> addr;
			}
		}
		else { throw new Exception(_("Steam API has returned empty response.")); }
	}
	
	private function startDBConnection()
	{
		self::$mlink = new mysqli(Settings::DB_HOST, Settings::DB_USER, Settings::DB_PASS, Settings::DB_NAME);
		if (!mysqli_connect_errno()) { self::$mlink -> set_charset("utf8"); } else { throw new Exception(_("No database connection.")); }
	}
	
	private function closeDBConnection()
	{
		if (!mysqli_connect_errno()) { self::$mlink -> close(); }
	}

	private function fetchServersDB()
	{
		$srvids = [];
		if ($stm = self::$mlink -> query("SELECT ServerID FROM servers WHERE IsEnabled = '1' ORDER BY ID ASC LIMIT 0,30"))
		{
			while ($row = $stm -> fetch_row())
			{
				$srvids[] = $row[0];
			}
			$stm -> close();
		}
		return $srvids;
	}
	
	private function getLegacyServerIPs()
	{
		if ($stm = self::$mlink -> query("SELECT IP FROM legacy WHERE IsEnabled = '1' ORDER BY ID ASC LIMIT 0,30"))
		{
			while ($row = $stm -> fetch_row())
			{
				self::$SERVERS[] = $row[0];
			}
			$stm -> close();
		}
	}
	
	private function checkMapImage($map)
	{
		$r = sprintf('static/maps/%s.png', $map);
		return file_exists($r) ? $r : 'static/maps/unknown.png';
	}
	
	private function getColor($cpl, $mpl)
	{
		$result = '#006900';
		$del = $mpl != 0 ? $cpl / $mpl : 0;
		if ($del >= 0.9) { $result = '#FF0000'; } elseif (($del > 0.78) && ($del < 0.9)) { $result = '#f4c430'; }
		return $result;
	}
	
	private function optimizeServerDB()
	{
		if (count(self::$SERVERS) > 0) { if (Settings::RANDOMIZE) { shuffle(self::$SERVERS); } } else { throw new Exception(_("Empty server database. Import dump or fill it manually.")); }
	}
	
	private function sanitizeString($str)
	{
		return trim(preg_replace('/[\x00-\x1F\x80-\x9F]/u', '', $str));
	}

	private function cleanSrvTitle($title)
	{
		return mb_strtoupper(mb_substr(str_replace(array("#", "|", "::"), array(" #", " | ", " : "), str_replace(array(" ", "_", "?", "\r\n", "\r", "\n", "\t"), "", self::sanitizeString($title))), 0, 19));
	}
	
	private function returnServerInfo($ip)
	{
		$srv = explode(':', $ip);
		$q = new SourceQuery();
		$r = [];
		
		try
		{
			$q -> Connect($srv[0], $srv[1], 1, SourceQuery::SOURCE);
			$srvinfo = $q -> GetInfo();
			
			$r['ip'] = sprintf('%s:%d', $srv[0], $srv[1]);
			$r['map'] = substr($srvinfo['Map'], 0, 15);
			$r['mapimg'] = self::checkMapImage($srvinfo['Map']);
			$r['fullname'] = self::sanitizeString($srvinfo['HostName']);
			$r['hostname'] = self::cleanSrvTitle($srvinfo['HostName']);
			$r['cplayers'] = $srvinfo['Players'];
			$r['maxplayers'] = $srvinfo['MaxPlayers'];
			$r['color'] = self::getColor($srvinfo['Players'], $srvinfo['MaxPlayers']);
			$r['errmsg'] = null;
		}
		catch(Exception $e)
		{
			$r['errmsg'] = $e -> getMessage();
		}
		
		$q -> Disconnect();
		return $r;
	}
	
	private function buildServerList()
	{
		$srvs = [];
		foreach (self::$SERVERS as $value) { $srvs[] = self::returnServerInfo($value); }
		if (empty($srvs)) { throw new Exception(_("No servers responded to our queries.")); }
		return $srvs;
	}
	
	private function getIPAddrList()
	{
		self::startDBConnection();
		self::resolveServersIPs(self::fetchServersDB());
		if (Settings::SHOWLEGACY) { self::getLegacyServerIPs(); }
		self::closeDBConnection();
		self::optimizeServerDB();
	}

	public static function Run()
	{
		self::loadLocale(Settings::LOCALE, 'messages');
		
		$smarty = new Smarty();
		$smarty -> setTemplateDir('templates');
		$smarty -> setCacheDir(sys_get_temp_dir());
		$smarty -> setCompileDir(sys_get_temp_dir());
		$smarty -> escape_html = true;
		
		try
		{
			self::getIPAddrList();
			$smarty -> assign('pageid', 'list');
			$smarty -> assign('servers', self::buildServerList());
			$smarty -> display('page.tpl');
		}
		catch (Exception $ex)
		{
			$smarty -> assign('pageid', 'error');
			$smarty -> assign('errmsg', $ex -> getMessage());
			$smarty -> display('page.tpl');
		}
	}
}

?>
