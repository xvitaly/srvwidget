<?php

/* 
 * Settings class. Part of Simple Source engine widget.
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

class Settings
{
	/*
	 * Steam settings.
	 * Get your API key here: http://steamcommunity.com/dev/apikey
	 */
	const STEAM_URI = 'https://api.steampowered.com/IGameServersService/GetServerIPsBySteamID/v0001/';
	const STEAM_TOKEN = '';
	
	/*
	 * MySQL database settings.
	 */
	const DB_HOST = 'localhost';
	const DB_NAME = 'srvwidget';
	const DB_USER = '';
	const DB_PASS = '';
	
	/*
	 * Project settings.
	 */
	const SHOWEMPTY = false;
}
