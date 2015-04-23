<html>
    <head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>Brzdąc</title>
		<link href="/css/base.css" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" href="/lib/jquery-ui/css/smoothness/jquery-ui-1.10.3.custom.min.css" />

		<script src="/lib/jquery-1.8.2.min.js"></script>
		<script src="/lib/jquery-ui/js/jquery-ui-1.10.3.custom.min.js"></script>

    </head>
    <body>
		<a href='/'>
			<div style='font-size: 36px; text-align: center; margin-bottom: 15px; font-weight: bold;'>
				<img src='/img/cat1.png'/>
				<span style='color: black; margin: 0 70px 0 70px; position: relative; bottom: 40px;'>Brzdąc</span>
				<img src='/img/cat2.png'/>
			</div>
		</a>
		<div class='panel-login'>
			<div class='container'>
				<form method='post'>
					Login: <input name='login'/><br/>
					Hasło: <input type='password' name='pass'/><br/>
					<input type='submit'/>
				</form>
			</div>
		</div>
		<div class='clear'></div>
		<div class='footer'>
			<div class='left' style='width: 40%;'>brzdac@krol.me</div>
			<div class='left' style='width: 20%; text-align: center;'><a href='/panel'>Forum/Wishlist/Panel</a></div>
			<div class='right' style='width: 40%; text-align: right;'>{if isset($onlineCount)}Online: {$onlineCount} | {/if}{if isset($fromCache) && $fromCache===TRUE}Loaded from cache | {/if}
				Generated in : {executiontime} seconds
			</div>
		</div>
	</body>
</html>