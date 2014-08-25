
var app;

// After DOM ready
$(function() {
	app = new App();
	app.loadPage();
});

function App(){
	this.loadPage = loadPage;
	this.ajax = ajax;
	this.ajaxErrorHandler = ajaxErrorHandler;

	/* Asynchronous */
	function ajax(href, params, type, handler) {
		
		// IE caching preventer
		/*
    	if(params == null){
    		params = {'__':(new Date()).getTime() };
    	}else{
    		params['__'] = (new Date()).getTime();
    	}    	
    	*/

    	if(params != null){
	    	$.each(params, function( key, value ) {
			  href = href +  "/" + value;
			});
	    }
		
		return $.ajax({
			url : href,
			type : type,
			dataType : 'json',
			data : params,
			headers : {
				"cache-control" : "no-cache"
			},
			success : function(result_data) {				
				app.data_obj = result_data;
				handler(result_data);				
				},
				error : ajaxErrorHandler
			});

	}
	
	function ajaxErrorHandler(jqXHR, textStatus, errorThrown) {
		console.log(jqXHR);
		console.log(textStatus);
		console.log(errorThrown);		
	}

	function loadPage(){
		load_module_shot_total_by_user();
		//load_module_shot_result();
		load_module_shot_total();
		load_module_user_total();
		load_module_shot_avg_by_user();
		load_module_best_shotters(5);
		load_module_shot();
		load_module_shot_form();
	}

	function load_module_shot_total_by_user(){
		var href = "http://ec2-54-164-182-11.compute-1.amazonaws.com/users-total";
		var params = "";
		var request_method = "GET";
		// Callback function
		function handler(result_obj) {
			var source = $("#core").html();  
			var template = Handlebars.compile(source);
			$('[module-id="shot-total-by-user"]').html(template({
				load_module_shot_total_by_user : '1',
				data_obj : result_obj
			}));
		}
		return ajax(href, params, request_method, handler);
	}	

	function load_module_shot_result(shot_id){
		var href = "http://ec2-54-164-182-11.compute-1.amazonaws.com/calculate-trajectoire";
		var params = {'id': shot_id};
		var request_method = "GET";
		// Callback function
		function handler(result_obj) {
			var data_obj = {};
			if(result_obj.impact == 0){
				data_obj.success = 1;
			} else {
				data_obj.fail = 1;
			}
			var source = $("#core").html();  
			var template = Handlebars.compile(source);
			$('[module-id="shot-result"]').html(template({
				load_module_shot_result : '1',
				data_obj : data_obj
			}));
		}
		return ajax(href, params, request_method, handler);
	}	

	function load_module_shot_total(){
		var href = "http://ec2-54-164-182-11.compute-1.amazonaws.com/shots-total";
		var params = {};
		var request_method = "GET";
		// Callback function
		function handler(result_obj) {
			var source = $("#core").html();  
			var template = Handlebars.compile(source);
			$('[module-id="shot-total"]').html(template({
				load_module_shot_total : '1',
				data_obj: result_obj
			}));
		}
		return ajax(href, params, request_method, handler);
	}	

	function load_module_user_total(){
		var href = "http://ec2-54-164-182-11.compute-1.amazonaws.com/users-total";
		var params = {};
		var request_method = "GET";
		// Callback function
		function handler(result_obj) {
			var source = $("#core").html();  
			var template = Handlebars.compile(source);
			$('[module-id="user-total"]').html(template({
				load_module_user_total : '1',
				data_obj: result_obj
			}));
		}
		return ajax(href, params, request_method, handler);
	}

	function load_module_shot_avg_by_user(){
		var href = "http://ec2-54-164-182-11.compute-1.amazonaws.com/shots-avg";
		var params = {};
		var request_method = "GET";
		// Callback function
		function handler(result_obj) {
			var source = $("#core").html();  
			var template = Handlebars.compile(source);
			$('[module-id="shot-avg-by-user"]').html(template({
				load_module_shot_avg_by_user : '1',
				data_obj: result_obj
			}));
		}
		return ajax(href, params, request_method, handler);
	}

	function load_module_best_shotters(limit){
		var href = "http://ec2-54-164-182-11.compute-1.amazonaws.com/top";
		var params = {'limit': limit};
		var request_method = "GET";
		// Callback function
		function handler(result_obj) {
			var source = $("#core").html();  
			var template = Handlebars.compile(source);
			$('[module-id="best-shotters"]').html(template({
				load_module_best_shotters : '1',
				data_obj: result_obj
			}));
		}
		return ajax(href, params, request_method, handler);
	}

	function add_shot(user_id, howitzer_id, target_id, distance_id, speed_id, angle_id){

		var href = "http://ec2-54-164-182-11.compute-1.amazonaws.com/shots";
		var params = {
						'user_id': user_id,
						'howitzer_id': howitzer_id,
						'target_id': target_id,
						'distance_id': distance_id,
						'speed_id': speed_id,
						'angle_id': angle_id
			};
		var request_method = "POST";
		// Callback function
		function handler(result_obj) {
			var source = $("#core").html();  
			var template = Handlebars.compile(source);
			$('[module-id="shot"]').html(template({
				load_module_shot : '1',
				data_obj: result_obj
			}));
		}
		return ajax(href, params, request_method, handler);
	}

	function load_module_shot(){
		var source = $("#core").html();  
		var template = Handlebars.compile(source);
		$('[module-id="shot"]').html(template({
			load_module_shot : '1'
		}));
	}

	function load_module_shot_form(){
		var source = $("#core").html();  
		var template = Handlebars.compile(source);
		$('[module-id="shot-form"]').html(template({
			load_module_shot_form : '1'
		}));
		load_module_user();
		load_module_howitzer();
		load_module_distance();
		load_module_target();
		load_module_speed();
		load_module_angle();
	}

	function load_module_user(){
		var href = "http://ec2-54-164-182-11.compute-1.amazonaws.com/users";
		var params = {};
		var request_method = "GET";
		// Callback function
		function handler(result_obj) {
			var source = $("#core").html();  
			var template = Handlebars.compile(source);
			$('[module-id="user"]').html(template({
				load_module_user : '1',
				data_obj: result_obj
			}));
		}
		return ajax(href, params, request_method, handler);
	}

	function load_module_howitzer(){
		var href = "http://ec2-54-164-182-11.compute-1.amazonaws.com/howitzers";
		var params = {};
		var request_method = "GET";
		// Callback function
		function handler(result_obj) {
			var source = $("#core").html();  
			var template = Handlebars.compile(source);
			$('[module-id="howitzer"]').html(template({
				load_module_howitzer : '1',
				data_obj: result_obj
			}));
		}
		return ajax(href, params, request_method, handler);
	}

	function load_module_distance(){
		var href = "http://ec2-54-164-182-11.compute-1.amazonaws.com/distances";
		var params = {};
		var request_method = "GET";
		// Callback function
		function handler(result_obj) {
			var source = $("#core").html();  
			var template = Handlebars.compile(source);
			$('[module-id="distance"]').html(template({
				load_module_distance : '1',
				data_obj: result_obj
			}));
		}
		return ajax(href, params, request_method, handler);
	}

	function load_module_target(){
		var href = "http://ec2-54-164-182-11.compute-1.amazonaws.com/targets";
		var params = {};
		var request_method = "GET";
		// Callback function
		function handler(result_obj) {
			var source = $("#core").html();  
			var template = Handlebars.compile(source);
			$('[module-id="target"]').html(template({
				load_module_target : '1',
				data_obj: result_obj
			}));
		}
		return ajax(href, params, request_method, handler);
	}

	function load_module_speed(){
		var href = "http://ec2-54-164-182-11.compute-1.amazonaws.com/speeds";
		var params = {};
		var request_method = "GET";
		// Callback function
		function handler(result_obj) {
			var source = $("#core").html();  
			var template = Handlebars.compile(source);
			$('[module-id="speed"]').html(template({
				load_module_speed : '1',
				data_obj: result_obj
			}));
		}
		return ajax(href, params, request_method, handler);
	}

	function load_module_angle(){
		var href = "http://ec2-54-164-182-11.compute-1.amazonaws.com/angles";
		var params = {};
		var request_method = "GET";
		// Callback function
		function handler(result_obj) {
			var source = $("#core").html();  
			var template = Handlebars.compile(source);
			$('[module-id="angle"]').html(template({
				load_module_angle : '1',
				data_obj: result_obj
			}));
		}
		return ajax(href, params, request_method, handler);
	}
}

