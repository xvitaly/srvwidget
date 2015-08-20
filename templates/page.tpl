<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Simple server widget by EasyCoding Team</title>
	<link rel="stylesheet" href="static/widget.css" type="text/css" />
	<script type="text/javascript" language="javascript" src="static/jquery.min.js"></script>
	<script type="text/javascript" language="javascript" src="static/functions.js"></script>
	<script type="text/javascript" language="javascript" src="static/jquery.jcarousellite.js"></script>
</head>
<body>
	<div class="wrapper">
		<ul>
		{foreach from=$servers item=srv}
			{if isset($srv.cplayers)}
				<li>
					<div class="server" title="{$srv.fullname}" onclick="location.href='steam://connect/{$srv.ip}/';">
					<div class="pic">
						<img src="{$srv.mapimg}" alt="{$srv.map}">
					</div>
					<div class="info">
						<div class="server_name">{$srv.hostname}</div>
						<div class="players"><span style="color: {$srv.color}">{$srv.cplayers}/{$srv.maxplayers}</span></div>
						<div class="map_name">{$srv.map}</div>
					</div>
					</div>
				</li>
			{else}
				<!-- Debug information: server {$srv.ip} is down. Remove it from database. -->
			{/if}
		{/foreach}
		</ul>
	</div>
</body>
</html>