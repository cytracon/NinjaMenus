define([
	'angular'
], function(angular) {

	var directive = function(cytraconBuilderUrl) {
		return {
			replace: true,
			templateUrl: function(elem) {
				return cytraconBuilderUrl.getTemplateUrl(elem, 'Cytracon_NinjaMenus/js/templates/builder/navbar/import-categories.html')
			},
			controller: function($scope, cytraconBuilderModal) {
				$scope.openImportModal = function() {
					cytraconBuilderModal.open('importCategories');
				}
			}
		}
	}

	return directive;
});