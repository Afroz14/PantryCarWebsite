var Stations = {

	settings: {
		stationSearchForm: $("#station-search-form"),
		stationSearchButton: ("#station-search-button"),
		stationSelectContainer: $("#select-train-container")
	},
	init: function() {
		this.bindUIActions();
	},

	showStationSearchPopup: function(clickedButton) {

		if (Stations.settings.stationSearchForm[0].checkValidity() === true) {

			var srcStationCode = $("#station-search-form #source_station").val();
			var destStationCode = $("#station-search-form #destination_station").val();
			var journeyDate = $("#station-search-form #journey_date").val();
			$.ajax({
				cache: false,
				url: BASE_PATH + '/selectTrain',
				method: 'GET',
				data: {
					'_token': X_ACCESS_TOKEN,
					"source_station": srcStationCode,
					"destination_station": destStationCode,
					"journey_date": journeyDate
				},
				success: function(data) {
					(clickedButton).button('reset');
					$("#select-train-container").html(data);
					var box = bootbox.dialog({
						title: "Select Train",
						message: Stations.settings.stationSelectContainer.html(),
						animate: true,
						onEscape: function() {
							Stations.settings.stationSelectContainer.html("");
						}
					});
					var marginTop = box.height() / 2;
					box.css({
						'top': '50%',
						'margin-top': function() {
							return -(marginTop);
						}
					});
				},
				error: function() {
					(clickedButton).button('reset');
				}
			});
		}
	},
	bindUIActions: function() {

		$('body').on('click', Stations.settings.stationSearchButton, function(event) {
			event.preventDefault();
			var _this = $(this);
			Stations.showStationSearchPopup(_this);
		});
		Stations.settings.stationSearchForm.submit(function(event) {
			event.preventDefault();
		});
	}
};


$(document).ready(function() {

	Stations.init();

});