{literal}
	<html>
		<head>
			<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
			<title>Brzdąc</title>
			<link href="/css/base.css?2" rel="stylesheet" type="text/css" />
			<script src="/lib/angular/angular.min.js"></script>
			<script src="/lib/angular/angular-route.min.js"></script>
			<script src="/lib/angular/angular-resource.min.js"></script>

			<script type="text/javascript" src="/lib/jquery-1.8.2.min.js"></script>
			<script type="text/javascript" src="/lib/jquery.simpletip-1.3.1.min.js"></script>
			<script type="text/javascript" src="/js/index/punchcard.js"></script>

			<script src="/js/app.js?2"></script>
			<script src="/js/controllers/controller.js?2"></script>
			<script src="/js/filters/filters.js?2"></script>
			<script src="/js/services/services.js?2"></script>
			<script src="/js/directives/directives.js?2"></script>
		</head>
		<body ng-app="brzdac" ng-controller="RootController">

			<noscript>
			<meta http-equiv="refresh" content="0; url=http://brzdac.muszelka.pw.edu.pl/old">
			</noscript>

			<a href='/'>
				<div style='font-size: 36px; text-align: center; margin-bottom: 15px; font-weight: bold;'>
					<img src='/img/cat1.png' alt="left-cat"/>
					<span style='color: black; margin: 0 70px 0 70px; position: relative; bottom: 40px;'>Brzdąc</span>
					<img src='/img/cat2.png' alt="right-cat"/>
				</div>
			</a>

			<div class='search_box'>
				<form method='get' >
					<input tabindex="1" size='60' type='text' name='text' ng-model="searchData.text" ng-change="change(searchData.text)" data-mleko-ui-focus/>
					<select tabindex="2" name='type' ng-model="searchData.type" ng-options="type.id as type.name for type in fileTypes"  ></select>
					<input ng-click="search(searchData)" type='submit' value='Szukaj'/>
				</form>
			</div>

			<div class='content' ng-view></div>
			<div class='footer'>
				<div class='left' style='width: 40%;'>brzdac@krol.me</div>
				<div class='left' style='width: 20%; text-align: center;'><a href='/panel'>Wishlist/Panel</a></div>
				<div class='right' style='width: 40%; text-align: right;'>
					Online: {{hostStat.online}} | Sharing: {{hostStat.sharing}} | Known: {{hostStat.known}}
				</div>
			</div>
		</body>
	</html>
{/literal}