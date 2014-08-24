
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
    	if(params == null){
    		params = {'__':(new Date()).getTime() };
    	}else{
    		params['__'] = (new Date()).getTime();
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
		load_module_shot_result();
		load_module_shot_total();
		load_module_user_total();
		load_module_shot_avg_by_user();
		load_module_best_shotters();
		load_module_shot();
		load_module_shot_form();
	}

	function load_module_shot_total_by_user(){
		var href = "http://ec2-54-164-182-11.compute-1.amazonaws.com/users-total";
		var params = "";
		var request_method = "GET";
		// Callback function
		function handler(result_data) {
			var source = $("#core").html();  
			var template = Handlebars.compile(source);
			$('[module-id="shot-total-by-user"]').html(template({
				load_module_shot_total_by_user : '1'
			}));
		}
		return ajax(href, params, request_method, handler);
	}	

	function load_module_shot_result(){
		var source = $("#core").html();  
		var template = Handlebars.compile(source);
		$('[module-id="shot-result"]').html(template({
			load_module_shot_result : '1'
		}));
	}	

	function load_module_shot_total(){
		var source = $("#core").html();  
		var template = Handlebars.compile(source);
		$('[module-id="shot-total"]').html(template({
			load_module_shot_total : '1'
		}));
	}	

	function load_module_user_total(){
		var source = $("#core").html();  
		var template = Handlebars.compile(source);
		$('[module-id="user-total"]').html(template({
			load_module_user_total : '1'
		}));
	}

	function load_module_shot_avg_by_user(){
		var source = $("#core").html();  
		var template = Handlebars.compile(source);
		$('[module-id="shot-avg-by-user"]').html(template({
			load_module_shot_avg_by_user : '1'
		}));
	}

	function load_module_best_shotters(){
		var source = $("#core").html();  
		var template = Handlebars.compile(source);
		$('[module-id="best-shotters"]').html(template({
			load_module_best_shotters : '1'
		}));
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
		load_module_howitzer_weight();
		load_module_distance();
		load_module_target_size();
		load_module_speed();
		load_module_angle();
	}

	function load_module_user(){
		var source = $("#core").html();  
		var template = Handlebars.compile(source);
		$('[module-id="user"]').html(template({
			load_module_user : '1'
		}));
	}

	function load_module_howitzer_weight(){
		var source = $("#core").html();  
		var template = Handlebars.compile(source);
		$('[module-id="howitzer-weight"]').html(template({
			load_module_howitzer_weight : '1'
		}));
	}

	function load_module_distance(){
		var source = $("#core").html();  
		var template = Handlebars.compile(source);
		$('[module-id="distance"]').html(template({
			load_module_distance : '1'
		}));
	}

	function load_module_target_size(){
		var source = $("#core").html();  
		var template = Handlebars.compile(source);
		$('[module-id="target-size"]').html(template({
			load_module_target_size : '1'
		}));
	}

	function load_module_speed(){
		var source = $("#core").html();  
		var template = Handlebars.compile(source);
		$('[module-id="speed"]').html(template({
			load_module_speed : '1'
		}));
	}

	function load_module_angle(){
		var source = $("#core").html();  
		var template = Handlebars.compile(source);
		$('[module-id="angle"]').html(template({
			load_module_angle : '1'
		}));
	}
}

