<?php

/* 
 * PHP Cache class. Part of Simple Source engine widget.
 * 
 * Copyright 2013 - 2015 EasyCoding Team (ECTeam).
 * Copyright 2005 - 2015 EasyCoding Team.
 * 
 * License: GNU GPL version 3.
 *
 * EasyCoding Team's official blog: http://www.easycoding.org/
 * 
 */

class Cache
{
	const PAGE_TIME = 600;
	
	private $cacheFile;
	
	public function __construct()
	{
		$this -> cacheFile = sprintf('%s/%s.dat', sys_get_temp_dir(), hash('md5', $_SERVER['REQUEST_URI']));
	}
	
	public function start()
	{
		if (file_exists($this -> cacheFile))
		{
			if ((time() - filemtime($this -> cacheFile)) < self::PAGE_TIME)
			{
				echo file_get_contents($this -> cacheFile);
				exit();
			}
			else
			{
				unlink($this -> cacheFile);
			}
		}
		ob_start();
	}
	
	public function end()
	{
		$buf = str_replace(array("\t", "\n", "\r", "\r\n"), "", ob_get_contents());
		file_put_contents($this -> cacheFile, $buf);
		ob_end_clean();
		echo $buf;
	}
}
?>
