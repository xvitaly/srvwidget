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
    const LOCALE = 'ru_RU';
    const SHOWLEGACY = false;
    const RANDOMIZE = true;
}
