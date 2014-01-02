<?php

/* 
 * PHP Cache class. Part of Simple Source engine widget.
 * 
 * Copyright 2013 EasyCoding Team (ECTeam).
 * Copyright 2005 - 2014 EasyCoding Team.
 * 
 * License: GNU GPL version 3.
 *
 * EasyCoding Team's official blog: http://www.easycoding.org/
 * 
 */

class Cache
{
	const PAGE_TIME = 600;
	const CACHE_PATH = 'cache/';
	
	private $cacheFile;
	
	public function __construct()
	{
		if (!is_dir(self::CACHE_PATH)) { mkdir(self::CACHE_PATH, 0755); }
		$this -> cacheFile = self::CACHE_PATH . hash('md5', $_SERVER['REQUEST_URI']) . '.dat';
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
		$fp = @fopen($this -> cacheFile, 'w');
		@fwrite($fp, ob_get_contents());
		@fclose($fp);
		ob_end_flush();
	}
}
?>