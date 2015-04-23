'use strict';

angular.module('brzdac', ['ngRoute', 'brzdac.filters', 'brzdac.controllers', 'brzdac.services', 'brzdac.directives'])
		.config(['$routeProvider', function($routeProvider) {
				$routeProvider.
						when('/splash', {templateUrl: '/partial/splash.html', controller: SplashController}).
						when('/search', {templateUrl: '/partial/search.html', controller: SearchController, reloadOnSearch: true}).
						otherwise({redirectTo: '/splash'});
			}]);


