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