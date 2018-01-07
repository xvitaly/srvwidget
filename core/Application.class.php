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

use Exception;
use Smarty;

class Application
{	
    private $cdir;
    private $cache;
    private $smarty;
    
    private function loadLocale($lang, $region)
    {
        putenv(sprintf("LANG=%s", $lang));
        setlocale(LC_ALL, sprintf("%s.UTF-8", $lang));
        bindtextdomain($region, "./locale");
        textdomain($region);
    }
    
    private function setSmarty()
    {
        $this -> smarty -> setTemplateDir('templates');
        $this -> smarty -> setCacheDir($this -> cdir);
        $this -> smarty -> setCompileDir($this -> cdir);
        $this -> smarty -> escape_html = true;
    }


    private function showWidget()
    {
        try
        {
            $widget = new Widget();
            $this -> smarty -> assign('pageid', 'list');
            $this -> smarty -> assign('servers', $widget -> getServers());
            $this -> smarty -> display('page.tpl');
        }
        catch (Exception $ex)
        {
            $this -> smarty -> assign('pageid', 'error');
            $this -> smarty -> assign('errmsg', $ex -> getMessage());
            $this -> smarty -> display('page.tpl');
        }
    }
    
    public function run()
    {
        $this -> cache -> start();
        $this -> showWidget();
        $this -> cache -> end();
    }

    public function __construct()
    {
        $this -> cdir = join(DIRECTORY_SEPARATOR, array(sys_get_temp_dir(), 'srvwidget'));
        $this -> cache = new Cache($this -> cdir);
        $this -> smarty = new Smarty();
        
        $this -> loadLocale(Settings::LOCALE, 'messages');
        $this -> setSmarty();
    }
}

?>