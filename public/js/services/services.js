'use strict';
/* Services */

var brzdacServices = angular.module('brzdac.services', ['ngResource']);

brzdacServices.factory('FileType',
		function($resource) {
			return $resource('/api/file-type', {});
		}
);
brzdacServices.factory('Host',
		function($resource) {
			return $resource('/api/host/stat', {}, {
				stat: {method: 'GET', isArray: false}
			});
		}
);
brzdacServices.factory('Doodle',
		function($resource) {
			return $resource('/api/doodle', {},
					{
						todayDoodle: {method: 'GET', isArray: false}
					});
		}
);
brzdacServices.factory('Search',
		function($resource) {
			return $resource('/api/search', {}, {
			});
		}
);
brzdacServices.factory('SplashStat',
		function($resource) {
			return $resource('/api', {}, {
				recentSearch: {method: 'GET', isArray: true, url: '/api/search/recent'},
				lastFound: {method: 'GET', isArray: true, url: '/api/search/last-found'}
			});
		}
);
