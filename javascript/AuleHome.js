
$(document).ready(function()
{
    if(!$.cookie("aulelibere_access"))
    {  
        $.ajax({
            url : "ajax/register_access.php"
        });
        
        $.cookie("aulelibere_access", true, {expires: 30});
    }
    
	var device = (/android|webos|iphone|ipad|ipod|blackberry|iemobile|opera mini/i.test(navigator.userAgent.toLowerCase()));
	
	if(device)
	{
		$.ajax({
            url      : "ajax/get_fac_list.php",
            type     : "GET",
            dataType : "json",
            success  : function(json)
            {
                jQuery.data(document.body, "config", json);

                $("#div-header").css("visibility", "visible");
                if(jQuery.cookie("facolta"))
                {
                    var cookie_facolta = $.cookie("facolta");
                    render_aule(cookie_facolta, "oggi");
                }
                else
                {
                    render_home();
                }
            },
            error: function(xhr, status, errorThrown) 
            {
                alert(status+' : '+errorThrown);
            }
		});
    }
    else
    {
        window.location.href = "PC/index.php";
    }
});



function render_home()
{
    $("#icon-menu").hide();
	$("#div-main").html(get_home_content());
		
	$('a').buttonMarkup({
		shadow : true,
		corners : true
	});
	
	$('#GIU,#ING,#LETT,#LING,#SCAE,#SCUS').click(function(event){
		var facolta = event.target.id;
		var giorno = "oggi";
		
		render_aule(facolta, giorno);
	});  
}

function render_aule(facolta, giorno)
{
	
	$.ajax({
		url      : "ajax/get_free_periods.php",
		data     : {facolta : facolta, data : giorno},
		type     : "GET",
		dataType : "json",
		success  : function(json)
		{
			var source = json["source"];
			var free_hours = json["free_hours"];
			var next_update = json["next_update"];
						
            $("#icon-menu").show();
			$("#div-main").html(get_facolta_content(free_hours, facolta, next_update));
			$("#div-main").addClass(facolta);
			
			$("#qui").removeClass("ui-btn");
			$("#qui").attr("href", source);
            $("#"+giorno).css({
				"border-color" : "blue",
				"border-width" : "3px"});
						
			$("#back,#day a").buttonMarkup({
				inline : true,
				corners : true
			});
			
			$("#back").click(function() {
				$("#div-main").removeClass(facolta);
				render_home();
			});
						
			$("#oggi,#domani").click(function(event){
				var giorno = event.target.id;
				render_aule(facolta, giorno);
			});
            
            $("#save").click(function(){
                if($.cookie("facolta"))
                    $.removeCookie("facolta");
                
                $.cookie("facolta", facolta, {expires: 365*10});
                $("#menu-panel").panel("close");
            });
			
			var domani_width = $("#domani").width();
			$("#oggi").width(domani_width);
            
            			/*$("#qui").click(function(){
				render_lezioni(facolta, giorno);
			});*/
		},
        error: function(xhr, status, errorThrown) 
        {
            alert(status+' : '+errorThrown);
        }
	});
}


function get_home_content()
{
	var config = jQuery.data(document.body, "config");
	var html = '';
	
	jQuery.each(config["facolta"], function(key, val){
		html += '<a id="'+val+'" href="#" class="ui-btn '+val+'">'+config[val]["title"]+'</a>';
	});
	
	html += '<div id="page-bottom">'
		+ '</br>'
		+ '<h3>'
		+ config["footer"]
		+ '</h3>'
		+ '</div>'
		;

	return html;
}

function get_facolta_content(free_hours, facolta, next_update)
{
	var config = jQuery.data(document.body, "config");
	
	var html
		= '<h2>'+config[facolta]["title"]+'</h2>'
		+ '<div id="day">'
		+ '<a id="oggi" href="#" class="ui-btn">OGGI</a><a id="domani" href="#" class="ui-btn">DOMANI</a>'
		+ '</div>';
	
	if(Object.keys(free_hours).length > 0)
	{
		jQuery.each(free_hours, function(key, val){
			html += '<div class="div-free-hours ui-body ui-body-a ui-corner-all">'
				+ '<h3>'
				+ key.toUpperCase()
				+ '</h3>'
				+'<p>';
			
			jQuery.each(val, function(key, val){
				html += val+'</br>';
			});
			html += '</p>'
				+ '</div>'
				+'</br>';
		});
	}
	else
	{
		html += '<div class="div-free-hours ui-body ui-body-a ui-corner-all">'
			+ '<h3>NON CI SONO LEZIONI</h3>'
			+ '</div>';
	}

	var secondi = config["refresh_interval"];
	
	html += '<div id="page-bottom">'
		+ '</br><a id="back" href="#" class="ui-btn ui-btn-inline">HOME</a>'
		+ '</br></br>'
		+ 'Le aule libere sono aggiornate ogni ' + secondi + ' secondi dall` <a id="qui">orario</a>. '
		+ 'Prossimo aggiornamento tra '	+ next_update + ' secondi.'
		+ '<h3>'
		+ config["footer"]
		+ '</h3>'
		+ '</div>'
		;
	
	return html;
}


/*function render_lezioni(facolta, giorno)
{
	var config = jQuery.data(document.body, "config");

	$.ajax({
		url      : "ajax/get_lessons.php",
		data     : {facolta: facolta,data: giorno},
		type     : "GET",
		dataType : "json",
		success  : function(json)
		{
*/			/*html += '<div id="page-bottom">'
				+ '</br></br><a id="back" href="#" class="ui-btn ui-btn-inline">HOME</a>'
				+ '</br>' + config["footer"]
				+ '</div>'
				;
            */
  /*         
           $("#div-main").html(get_lessons_content(json));

			$("#cacheinfo").hide();
			
			$("#back").click(function() {
				render_aule(facolta, giorno);
			});

		},
        error: function(xhr, status, errorThrown) 
        {
            alert(status+' : '+errorThrown);
        }
	});
}
*/
