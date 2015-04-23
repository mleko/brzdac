var groupBy = function(collection, key) {
	var groups = [];
	var groupKeys = [];
	for(var i = 0; i < collection.length; i++) {
		var value = collection[i];
		var groupId = groupKeys.indexOf(value[key]);
		if (groupId === -1) {
			groupKeys.push(value[key]);
			groups.push({values: [value]});
		} else {
			groups[groupId].values.push(value);
		}
	}
	return groups;
};

var RootController = ['$scope', '$location', 'Host', 'FileType', 'Search',
	function($scope, $location, Host, FileType, Search) {
		$scope.hostStat = Host.stat();
		$scope.fileTypes = FileType.query();

		$scope.filter = "";

		var search = $location.search();
		$scope.searchData = {type: (search.type ? search.type : "1"), text: search.text ? search.text : ""};

		var lastSearchText = search.text ? search.text.trim() : "";

		var performSearch = function(searchData) {
			$scope.searchLoading = 1;
			Search.query({text: searchData.text, type: searchData.type}, function(files) {
				$scope.fileGroups = groupBy(files, 'host');
				$scope.searchLoading = 0;
			}, function() {
				$scope.searchLoading = 0;
			});
		};
		$scope.search = function(searchData) {
			if ($location.path() !== '/search') {
				$location.path('/search');
			}
			$location.search('text', searchData.text);
			$location.search('type', searchData.type);
			lastSearchText = searchData.text.trim();
			$scope.searchData = searchData;
			performSearch(searchData);
		};

		$scope.searchMovie = function(name) {
			$scope.search({text: name, type: 1});
		};

		var timeout;
		$scope.change = function(text) {
			var filter = text.trim();
			if (filter.indexOf(lastSearchText) !== 0) {
				filter = "";
			}
			if (timeout) {
				clearTimeout(timeout);
			}
			timeout = setTimeout(function() {
				$scope.$apply(function() {
					$scope.filter = "" + filter;
				});
			}, 350);
		};
	}];

var SplashController = ['$scope', 'Doodle', 'SplashStat', function($scope, Doodle, SplashStat) {

		$scope.doodle = Doodle.todayDoodle();

		$scope.recentSearchLoading = 1;
		$scope.recentSearch = SplashStat.recentSearch(function() {
			$scope.recentSearchLoading = 0;
		});

		$scope.lastAddedLoading = 1;
		$scope.lastAdded = SplashStat.lastFound(function() {
			$scope.lastAddedLoading = 0;
		});

		$scope.getByProperty = function(collection, property, value) {
			for(var i = 0; i < collection.length; i++) {
				//intentional weak comparator
				if (collection[i][property] == value) {
					return collection[i];
				}
			}
		};
	}];

var SearchController = ['$scope', '$location', function($scope, $location) {
		var search = $location.search();
		searchData = {type: (search.type ? search.type : "1"), text: search.text ? search.text : ""};

		$scope.groupInfo = function(group, groupBy) {
			if (groupBy === 'host') {
				return {'header': group.values[0].host, active: group.values[0].active};
			}
		};

		$scope.search(searchData);
	}];

angular.module('brzdac.controllers', [])
		.controller(RootController)
		.controller(SplashController)
		.controller(SearchController)
		;