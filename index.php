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


// Use Composer's autoloader...
require_once('vendor/autoload.php');

// Connecting settings storage...
require_once('libs/srvwidget/Settings.class.php');

// Connecting libraries...
require_once('libs/srvwidget/SrvWidget.class.php');
require_once('libs/phpcache/PHPCache.class.php');

// Starting cache engine...
$cache = new Cache;
$cache -> start();

// Starting application...
Application::Run();

// Stopping cache engine...
$cache -> end();

?>