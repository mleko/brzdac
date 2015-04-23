'use strict';

/* Directives */


var brzdacDirectives = angular.module('brzdac.directives', []);

brzdacDirectives
		.directive('mlekoUiCycle', ['$rootScope', function($rootScope) {
				return{
					restrict: 'A',
					link: function(scope, element, attrs) {
						var run = function() {
							var children = $(element).children();
							var index = 0;
							var intervalVar;
							$(children).hide();
							$(children[0]).show();
							var cycle = function() {
								intervalVar = setInterval(function() {
									$(children[index]).fadeOut(1000, function() {
										index = (index + 1) % children.length;
										$(children[index]).fadeIn(1000);
									});
								}, 6000);
							};

							$(element).mouseenter(function() {
								clearInterval(intervalVar);
							});
							$(element).mouseleave(cycle);
							cycle();
						};
						if (attrs.mlekoUiCycle !== "data-mleko-ui-cycle") {
							$rootScope.$on(attrs.mlekoUiCycle, run);
						} else {
							run();
						}


					}
				};
			}])
		.directive('mlekoUiCycleRun', ['$rootScope', function($rootScope) {
				return{
					restrict: 'A',
					link: function(scope, element, attrs) {
						$rootScope.$broadcast(attrs.mlekoUiCycleRun);
					}

				};
			}

		])
		.directive('mlekoUiFocus', [function() {
				return{
					restrict: 'A',
					link: function(scope, element, attrs) {
						$(document).ready(function() {
							$(element).focus();
						});
					}

				};
			}])
		.directive('mlekoPunchcard', [function() {
				return{
					restrict: 'A',
					link: function(scope, element, attrs) {
						$(element).simpletip({
							content: "",
							fixed: true,
							persistent: true,
							onBeforeShow: function() {
								if (this.loaded) return;
								this.load("/host/punchcard/" + this.getParent().attr('data-ip'));
								this.loaded = true;
							}
						});
						$(element).children('img').click(function() {
							$(this).parent().click();
						});
					}
				};
			}])

		;
