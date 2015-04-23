'use strict';
angular.module('brzdac.filters', [])
		.filter('checkmark', function() {
			return function(input) {
				return input ? '\u2713' : '\u2718';
			};
		})
		.filter('escapeUrl', function() {
			return function(input) {
				return encodeURIComponent(input);
			};
		})
		.filter('fileSize', function() {
			var prefixes = ["", "Ki", "Mi", "Gi", "Ti"];
			var base = 1024;
			var logBase = Math.log(base);
			return function(input) {
				var pIndex = Math.floor(Math.log(input) / logBase);
				return (input / Math.pow(base, pIndex)).toFixed(2) + " " + prefixes[pIndex] + "B";
			};
		})
		.filter('int2ip', function() {
			return function(input) {
				var ip = "";
				while (input) {
					var part = input % 256;
					ip = part + (ip ? "." : "") + ip;
					input = (input - part) / 256;
				}
				return ip;
			};
		})
		.filter('extFilter', ['$filter', function($filter) {
				return function(input, filterString) {
					var filter = $filter('filter');
					var strings = filterString.split(" ");
					var out = input;
					for (var i = 0; i < strings.length; i++) {
						out = filter(out, strings[i]);
					}
					return out;
				};
			}])

		;