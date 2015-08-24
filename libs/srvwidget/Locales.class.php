<?php

class Locales
{
	const AppDomain = 'messages';
	
	public static function loadLocales($lang)
	{
		putenv(sprintf("LANG=%s", $lang));
		//setlocale(LC_ALL, "Russian");
		bindtextdomain (self::AppDomain, "./locale");
		textdomain (self::AppDomain);
	}
}
