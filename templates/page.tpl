<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Simple server widget by EasyCoding Team</title>
	<link rel="stylesheet" href="static/widget.css" type="text/css" />
</head>
<body>
	<div class="wrapper">
	{foreach from=$servers item=srv}
		<div class="server">
			<div class="pic">
				<a href="steam://connect/{$srv.ip}/"><img src="{$srv.mapimg}" alt="{$srv.map}"></a>
			</div>
			<div class="info">
				<div class="server_name"><a href="steam://connect/{$srv.ip}/">{$srv.hostname}</a></div>
				<div class="players"><span style="color: {$srv.color}">{$srv.cplayers}/{$srv.maxplayers}</span></div>
				<div class="map_name">{$srv.map}</div>
			</div>
		</div>
	{/foreach}
	</div>
</body>
</html>