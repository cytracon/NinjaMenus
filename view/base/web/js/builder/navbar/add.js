define([
	'angular'
], function(angular) {

	var directive = function(cytraconBuilderUrl) {
		return {
			replace: true,
			templateUrl: function(elem) {
				return cytraconBuilderUrl.getTemplateUrl(elem, 'Cytracon_Builder/js/templates/builder/navbar/add.html')
			},
			controller: function($rootScope, $scope) {

				$scope.openElementsModal = function() {
					$rootScope.$broadcast('addElement', {type: 'menu_item', openModal: false});
				}
			}
		}
	}

	return directive;
});