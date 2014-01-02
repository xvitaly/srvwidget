<?php

class Application
{	
	private static $SERVERS = array('83.222.97.209:27203', '46.174.48.29:27276', '46.174.48.24:27262', '89.223.24.149:27015', '89.223.24.149:27016', '89.223.24.149:27017');
	
	private function checkMapImage($map)
	{
		$r = sprintf('static/maps/%s.png', $map);
		return file_exists($r) ? $r : 'static/maps/unknown.png';
	}
	
	private function getColor($del)
	{
		$result = '#006900';
		if ($del >= 0.9) { $result = '#FF0000'; } elseif (($del > 0.78) && ($del < 0.9)) { $result = '#f4c430'; }
		return $result;
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
			$r['map'] = $srvinfo['Map'];
			$r['mapimg'] = self::checkMapImage($srvinfo['Map']);
			$r['hostname'] = strlen($srvinfo['HostName']) <= 19 ? $srvinfo['HostName'] : substr($srvinfo['HostName'], 0, 19);
			$r['cplayers'] = $srvinfo['Players'];
			$r['maxplayers'] = $srvinfo['MaxPlayers'];
			$r['color'] = self::getColor($srvinfo['Players']/$srvinfo['MaxPlayers']);
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
		$smarty -> setCacheDir('cache');
		$smarty -> setCompileDir('cache/tc');
		
		foreach (self::$SERVERS as $value)
		{
			$srvs[] = self::returnServerInfo($value);
		}
		
		$smarty -> assign('servers', $srvs);
		$smarty -> display('page.tpl');
	}
}

?>