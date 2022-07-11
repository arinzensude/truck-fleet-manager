jQuery(document).ready(function(){
	//Set routes for the first client that is on display when page loads
	if(jQuery("#add-trip #Trip_Client_select").is(":visible")) {
		get_client_rate();
		if(!jQuery("#add-trip #TripRate").val()) {
			get_selected_client_routes();
		}
	}
	//Set routes for selected client
	jQuery("#add-trip #Trip_Client_select").change(function() {
		get_selected_client_routes();
		get_client_rate();
	});
	//Set information for the first route that is on display when the page loads
	if(jQuery("#add-trip #Trip_Route_select").is(":visible")) {
		get_litres_of_fuel();
		if(!jQuery("#add-trip #TripDriverAllowance").val()) {
			get_selected_route_info();
		}
	}
	//Set information for selected route
	jQuery("#add-trip #Trip_Route_select").change(function() {
		get_selected_route_info();
		get_litres_of_fuel();
	});
	//When Truck select changes
	jQuery("#add-trip #Trip_Truck_select").change(function() {
		get_litres_of_fuel();
		console.log("Truck select changed!")
	});
	//Calculate total fuel cost once fuel per litre value changes
	jQuery("#add-trip #TripFuelPerLitre").change(function() {
		calculate_total_fuel_cost();
	});
	//Re-calculate total price if Quantity value changes
	jQuery("#add-trip #TripQuantity").change(function() {
		set_total_price();
	});
	//Set the value of Amount Paid = Total Price when paid_in_full checkbox is checked
	jQuery("#add-trip #TripPaidInFull").change(function() {
		if(jQuery(this).is(":checked")) {
			var total_price = jQuery("#add-trip #TripTotalPrice").val();
			jQuery("#add-trip #TripAmountPaid").val(total_price);
		} else {
			if(jQuery("#add-trip #TripAmountPaid").val() <= 0)
				jQuery("#add-trip #TripAmountPaid").val(0);
		}
	});
});

function set_total_price() {
	var price = jQuery("#add-trip #TripPrice").val();
	if(jQuery("#add-trip #TripRate").val() == 'per trip') {
		jQuery("#add-trip #TripTotalPrice").val(price);
		jQuery("#add-trip #TripQuantity").val(1);
	} else {
		var qty = jQuery("#add-trip #TripQuantity").val();
		if(qty > 0) {
			jQuery("#add-trip #TripTotalPrice").val(price*qty);
		} else {
			jQuery("#add-trip #TripQuantity").val(1);
			jQuery("#add-trip #TripTotalPrice").val(price);
		}
		
	}
}

function calculate_total_fuel_cost() {
	var fuel_per_litre = Number(jQuery("#add-trip #TripFuelPerLitre").val());
	var litres_of_fuel = Number(jQuery("#add-trip #TripLitresOfFuel").val());
	if(fuel_per_litre > 0) {
		jQuery("#add-trip #TripTotalFuelCost").val(fuel_per_litre*litres_of_fuel);
	}
}

function get_client_rate() {
	var data = {
	    action: 'admin_trips_get_client_rate',
	    client: jQuery("#add-trip #Trip_Client_select").val()
	};
  	jQuery.post(ajaxurl, data, function(data, status) {
  		var rate = JSON.parse(data);
  		if(!jQuery("#add-trip #TripRate").val()) {
  			jQuery("#add-trip #TripRate").val(rate[0]['rate']);
  			set_total_price();
  		}
  		var trip_msg = rate[0]['trip_message'];
  		if (trip_msg != null && trip_msg) {
  			jQuery("#add-trip #client-trip-message p").text('Selected client trip message: ' + trip_msg);
  		}	
  	});
}

function get_litres_of_fuel() {
	var data = {
	    action: 'admin_trips_get_litres_of_fuel',
	    route: jQuery("#add-trip #Trip_Route_select").val(),
	    truck: jQuery("#add-trip #Trip_Truck_select").val()
	};
  	jQuery.post(ajaxurl, data, function(data, status) {
  		var res = JSON.parse(data);
  		jQuery("#add-trip #TripLitresOfFuel").val(res[0]['litres_of_fuel']);
  		calculate_total_fuel_cost();
  	});
}

function get_selected_route_info() {
	var data = {
	    action: 'admin_trips_get_route_info',
	    route: jQuery("#add-trip #Trip_Route_select").val()
	};
  	jQuery.post(ajaxurl, data, function(data, status) {
  		var route = JSON.parse(data);
  		set_route_info(route);
  		//calculate_total_fuel_cost();
  		set_total_price();
  	});
}

function get_selected_client_routes() {
	var data = {
	    action: 'admin_trips_get_routes',
	    client: jQuery("#add-trip #Trip_Client_select").val()
	};
  	jQuery.post(ajaxurl, data, function(data, status) {
  		var options = set_routes_select_options(JSON.parse(data));
  		jQuery("#add-trip #Trip_Route_select").html(options.join(''));
  	});
}

function set_routes_select_options(options_obj) {
	var output = [];
	jQuery.each(options_obj, function(key, value) {
		output.push('<option value="'+ value['id'] +'">'+ value['name'] +'</option>');
	});
	return output;
}

function set_route_info(route) {
	jQuery("#add-trip #TripDriverAllowance").val(route[0]['driver_allowance']);
	jQuery("#add-trip #TripMotorboyAllowance").val(route[0]['motorboy_allowance']);
	jQuery("#add-trip #TripTripAllowance").val(route[0]['trip_allowance']);
	jQuery("#add-trip #TripPrice").val(route[0]['price']);
	//jQuery("#add-trip #TripLitresOfFuel").val(route[0]['litres_of_fuel']);
}