<html>
    <head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>Brzdąc</title>
		<link href="/css/base.css" rel="stylesheet" type="text/css" />
    </head>
    <body>
		<a href='/'>
			<div style='font-size: 36px; text-align: center; margin-bottom: 15px; font-weight: bold;'>
				<img src='/img/cat1.png'/>
				<span style='color: black; margin: 0 70px 0 70px; position: relative; bottom: 40px;'>Brzdąc</span>
				<img src='/img/cat2.png'/>
			</div>
		</a>
		{block name='body'}
			Body block content
		{/block}
		<div class='footer'>
			<div class='left' style='width: 40%;'>brzdac@krol.me</div>
			<div class='left' style='width: 20%; text-align: center;'><a href='/panel'>Wishlist/Panel</a></div>
			<div class='right' style='width: 40%; text-align: right;'>
				{if isset($onlineCount)}Online: {$onlineCount} | {/if}
				{if isset($sharingCount)}Sharing: {$sharingCount} | {/if}
				{if isset($knownCount)}Known: {$knownCount} | {/if}
				{if isset($fromCache) && $fromCache===TRUE}Loaded from cache | {/if}
				Generated in : {executiontime} seconds
			</div>
		</div>
	</body>
</html>