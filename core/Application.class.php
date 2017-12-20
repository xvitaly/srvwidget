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

use Smarty;

class Application
{	
    private function loadLocale($lang, $region)
    {
        putenv(sprintf("LANG=%s", $lang));
        setlocale(LC_ALL, sprintf("%s.UTF-8", $lang));
        bindtextdomain($region, "./locale");
        textdomain($region);
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
                $widget = new Widget();
                $smarty -> assign('pageid', 'list');
                $smarty -> assign('servers', $widget -> getServers());
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