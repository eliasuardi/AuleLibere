
$(document).ready(function()
{
	$.ajax({
			url      : "ajax/get_fac_list.php",
			type     : "GET",
			dataType : "json",
			success  : function(json)
			{
				jQuery.data(document.body, "config", json);
				
				render_home();
			},
            error: function(xhr, status, errorThrown) 
            {
                alert(status+' : '+errorThrown);
            }
	});
});

function render_home()
{
	$("#div-home-page #div-main").html(get_home_content());
	
	$("a").buttonMarkup({ 
		corners: true
	});
	
}

function get_home_content()
{
	var config = jQuery.data(document.body, "config");
	var html = '';
	
	jQuery.each(config["facolta"], function(key, val){
		html += '<a id="#'+val+'" href="#div-sub-page" class="ui-btn">'+config[val]["title"]+'</a>';
	});
	
	return html;
}