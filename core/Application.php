<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace SrvWidget;

use Smarty;

/**
 * Description of Application
 *
 * @author Vitaly
 */
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