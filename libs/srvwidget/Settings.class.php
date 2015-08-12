<?php

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
