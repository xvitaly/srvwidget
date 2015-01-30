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
	const STEAM_URI = 'https://api.steampowered.com/IGameServersService/GetServerIPsBySteamID/v0001/';
	const STEAM_TOKEN = '';
	
	const DB_HOST = 'localhost';
	const DB_NAME = 'srvwidget';
	const DB_USER = '';
	const DB_PASS = '';
	const SHOWEMPTY = false;
	
	private static $SERVERS = array();
	
	private function sendGETRequest($url, $useragent = 'wget')
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 4);
		curl_setopt($ch, CURLOPT_MAXREDIRS, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 5);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_REFERER, $url);
		curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch);
		$rescode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);
		return $rescode == 200 ? $result : null;
	}
	
	private function resolveServersIP($a)
	{
		$req = array('key' => self::STEAM_TOKEN, 'format' => 'xml', 'server_steamids' => $a);
		$xml = simplexml_load_string(self::sendGETRequest(sprintf('%s?%s', self::STEAM_URI, http_build_query($req))));
		foreach($xml -> servers -> message as $item)
		{
			self::$SERVERS[] = $item -> addr;
		}
	}

	private function fetchServersDB()
	{
		$srvids = array();
		$mlink = new mysqli(self::DB_HOST, self::DB_USER, self::DB_PASS, self::DB_NAME);
		if (!mysqli_connect_errno())
		{
			$mlink -> set_charset("utf8");
			if ($stm = $mlink -> query("SELECT ServerID FROM servers WHERE IsEnabled = '1' ORDER BY ID ASC LIMIT 0,30"))
			{
				while ($row = $stm -> fetch_row())
				{
					$srvids[] = $row[0];
				}
				$stm -> close();
			}
			$mlink -> close();
		}
		return $srvids;
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
	
	private function cleanSrvTitle($title)
	{
		$title = str_replace(array(" ", "_", "?", "\r\n", "\r", "\n"), "", $title);
		$title = str_replace(array("#", "|", "::"), array(" #", " | ", " : "), $title);
		return mb_strtoupper(mb_substr($title, 0, 19));
	}
	
	private function returnServerInfo($ip)
	{
		$srv = explode(':', $ip);
		$q = new SourceQuery();
		$r = array();
		
		try
		{
			$q -> Connect($srv[0], $srv[1], 1, SourceQuery::SOURCE);
			$srvinfo = $q -> GetInfo();
			
			$r['ip'] = sprintf('%s:%d', $srv[0], $srv[1]);
			$r['map'] = substr($srvinfo['Map'], 0, 15);
			$r['mapimg'] = self::checkMapImage($srvinfo['Map']);
			$r['fullname'] = $srvinfo['HostName'];
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
	
	public static function Run()
	{
		self::resolveServersIP(self::fetchServersDB());
		
		$smarty = new Smarty();
		$srvs = array();
		
		$smarty -> setTemplateDir('templates');
		$smarty -> setCacheDir(sys_get_temp_dir());
		$smarty -> setCompileDir(sys_get_temp_dir());
		
		shuffle(self::$SERVERS);
		foreach (self::$SERVERS as $value)
		{
			$srvs[] = self::returnServerInfo($value);
		}
		
		$smarty -> assign('servers', $srvs);
		$smarty -> assign('hide', self::SHOWEMPTY);
		
		$smarty -> display('page.tpl');
	}
}

?>