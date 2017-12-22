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

namespace SrvWidget;

use Exception;
use Smarty;

class Application
{	
    private $cache;
    private $smarty;
    
    private function loadLocale($lang, $region)
    {
        putenv(sprintf("LANG=%s", $lang));
        setlocale(LC_ALL, sprintf("%s.UTF-8", $lang));
        bindtextdomain($region, "./locale");
        textdomain($region);
    }
    
    private function setSmarty($cdir)
    {
        $this -> smarty -> setTemplateDir('templates');
        $this -> smarty -> setCacheDir($cdir);
        $this -> smarty -> setCompileDir($cdir);
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
        $this -> cache = new Cache();
        $this -> smarty = new Smarty();
        
        $this -> loadLocale(Settings::LOCALE, 'messages');
        $this -> setSmarty(sys_get_temp_dir());
    }
}

?>