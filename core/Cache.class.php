<?php

/*
 * This file is a part of Simple Source engine widget. For more information
 * visit official site: https://www.easycoding.org/projects/srvwidget
 * 
 * Copyright (c) 2013 - 2018 EasyCoding Team (ECTeam).
 * Copyright (c) 2005 - 2018 EasyCoding Team.
 * 
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

namespace SrvWidget;

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
