<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Simple server widget by EasyCoding Team</title>
	<link rel="stylesheet" href="static/widget.css" type="text/css" />
	<script type="text/javascript" language="javascript" src="static/jquery.min.js"></script>
	<script type="text/javascript" language="javascript" src="static/jquery.jcarousellite.js"></script>
</head>
<body>
	<div class="wrapper">
		<ul>
		{foreach from=$servers item=srv}
			{if $hide || $srv.cplayers gt 0}
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
			{/if}
		{/foreach}
		</ul>
	</div>
	<script type="text/javascript">
	$(function() {
		$(".wrapper").jCarouselLite({
			auto: 800,
			speed: 1000,
			visible: 5,
			vertical: true,
			hoverPause: true
		});
	});
	</script>
</body>
</html>