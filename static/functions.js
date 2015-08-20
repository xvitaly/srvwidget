/* 
 * Simple Source engine widget - main JS.
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

function pageReload() {
	location.reload();
};

$(function() {
	$(".wrapper").jCarouselLite({
		auto: 800,
		speed: 1000,
		visible: 5,
		vertical: true,
		hoverPause: true
	});
});

$(document).ready(function() {
	setTimeout("pageReload()", 60000);
});
