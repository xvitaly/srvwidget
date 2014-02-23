<?php

/* 
 * Simple Source engine widget.
 * 
 * Copyright 2013 EasyCoding Team (ECTeam).
 * Copyright 2005 - 2014 EasyCoding Team.
 * 
 * License: GNU GPL version 3.
 *
 * EasyCoding Team's official blog: http://www.easycoding.org/
 * Project's official webpage: http://www.easycoding.org/projects/srvwidget
 * 
 */

class Application
{	
	private static $SRVOUR = array('46.174.48.44:27272', '83.222.97.209:27203', '46.174.48.29:27276', '46.174.48.24:27262');
	private static $SRVOTH = array('93.191.11.90:27209', '89.223.24.149:27016', '89.223.24.149:27017', '93.191.11.90:27208', '77.241.20.23:27029', '89.223.24.149:27015', '93.191.11.90:27202');
	private static $SHOWEMPTY = false;
	
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
		$title = str_replace(array("#", "|"), array(" #", " | "), $title);
		$title = strtoupper(substr($title, 0, 19));
		return $title;
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
			$r['map'] = substr($srvinfo['Map'], 0, 17);
			$r['mapimg'] = self::checkMapImage($srvinfo['Map']);
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
		$smarty = new Smarty();
		$srvs = array();
		
		$smarty -> setTemplateDir('templates');
		$smarty -> setCacheDir(sys_get_temp_dir());
		$smarty -> setCompileDir(sys_get_temp_dir());
		
		foreach (self::$SRVOUR as $value)
		{
			$srvs[] = self::returnServerInfo($value);
		}
		
		shuffle(self::$SRVOTH);
		foreach (self::$SRVOTH as $value)
		{
			$srvs[] = self::returnServerInfo($value);
		}
		
		$smarty -> assign('servers', $srvs);
		$smarty -> assign('hide', self::$SHOWEMPTY);
		
		$smarty -> display('page.tpl');
	}
}

?>