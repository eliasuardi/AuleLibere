var tipo_visualizzazione;

$(document).ready(function()
{
    if(!jQuery.cookie("aulelibere_access"))
    {  
        $.ajax({
            url : "ajax/register_access.php"
        });
        
        jQuery.cookie("aulelibere_access", true, {expires: 30});
    }
    
	/*var device = (/android|webos|iphone|ipad|ipod|blackberry|iemobile|opera mini/i.test(navigator.userAgent.toLowerCase()));
	
	if(device)
	{*/
		$.ajax({
            url      : "ajax/get_list.php",
            type     : "GET",
            dataType : "json",
            success  : function(json)
            {
                jQuery.data(document.body, "config", json);
                tipo_visualizzazione = "Sede";

                $("#div-header").css("visibility", "visible");
                if(jQuery.cookie("save"))
                {
                    var cookie_save = jQuery.cookie("save");
                    var cookie_values = cookie_save.split(" ");
                    tipo_visualizzazione = cookie_values[0];
                    render_aule(cookie_values[1], "oggi");
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
    /*}
    else
    {
        window.location.href = "PC/index.php";
    }*/
});



function render_home()
{
	$("#left-panel-ul").empty();
	$("#left-panel-ul").append('<li data-role="list-divider" role="heading" class="ui-li-divider ui-bar-b ui-first-child">Visualizza : </li>');
	$("#left-panel-ul").append('<li><a href="#" id="Sede">Per Sede</a></li>');
	$("#left-panel-ul").append('<li><a href="#" id="Facolta">Per Facolta&grave;</a></li>');
	$("#div-main").html(get_home_content());

	$('a').buttonMarkup({
		shadow : true,
		corners : true
	});
	
	$('#div-main a').click(function(event){
		var sede = event.target.id;
		var giorno = "oggi";
		
		render_aule(sede, giorno);
	});
	
	$('#left-panel-ul a').click(function(event){
		var button = event.target.id;
		tipo_visualizzazione = button;
		$("#menu-panel").panel("close");
		render_home();
	});
}

function render_aule(elemento, giorno)
{
	$.ajax({
		url      : "ajax/get_free_periods.php",
		data     : {url_elemento : elemento, url_data : giorno},
		type     : "GET",
		dataType : "json",
		success  : function(json)
		{
			var source = json["source"];
			var free_hours = json["free_hours"];
			var next_update = json["next_update"];
						
			$("#left-panel-ul").empty();
			$("#left-panel-ul").append('<li><a href="#" id="save">Salva '+tipo_visualizzazione+'</a></li>');		
			//$("#left-panel-ul").append('<li data-role="list-divider" role="heading" class="ui-li-divider ui-bar-b ui-first-child">Visualizza : </li>');
			//$("#left-panel-ul").append('<li><a href="#" id="">Per Aula</a></li>');
			//$("#left-panel-ul").append('<li><a href="#" id="">Per Periodo</a></li>');
			//$("#left-panel-ul").append('<li><a href="#" id="">Per Rilevanza</a></li>');
			$("#icon-menu").show();
			$("#div-main").html(get_elemento_content_by_class(free_hours, elemento, next_update));
			$("#div-main").addClass(elemento);
			$("#qui").removeClass("ui-btn");
			$("#qui").attr("href", source);
            $("#"+giorno).css({
				"border-color" : "blue",
				"border-width" : "3px"});
			
			$('#menu-panel a').buttonMarkup({
				shadow : true,
				corners : true
			});
			
			$("#back,#day a").buttonMarkup({
				inline : true,
				corners : true
			});
			
			$("#back").click(function() {
				$("#div-main").removeClass(elemento);
				render_home();
			});
						
			$("#oggi,#domani").click(function(event){
				var giorno = event.target.id;
				render_aule(elemento, giorno);
			});
            
            $("#save").click(function(){
                if(jQuery.cookie("save"))
                    $.removeCookie("save");
                
                jQuery.cookie("save", tipo_visualizzazione+" "+elemento, {expires: 365*10});
                $("#menu-panel").panel("close");
            });
			
			var domani_width = $("#domani").width();
			$("#oggi").width(domani_width);
            
		},
        error: function(xhr, status, errorThrown) 
        {
            alert(status+' : '+errorThrown);
        }
	});
}


function get_home_content()
{
	var list = tipo_visualizzazione.toLowerCase();
	var config = jQuery.data(document.body, "config");
	var html = '';
	
	jQuery.each(config[list], function(key, val){
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

function get_elemento_content_by_class(free_hours, elemento, next_update)
{
	var html = get_day_options(elemento);
    
	if(Object.keys(free_hours).length === 0)
        html += get_no_lessons();
        
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
    
    html += get_footer(next_update);
	
	return html;
}

function get_day_options(elemento)
{
    var config = jQuery.data(document.body, "config");
	
	var html
		= '<h2>'+config[elemento]["title"]+'</h2>'
		+ '<div id="day">'
		+ '<a id="oggi" href="#" class="ui-btn">OGGI</a><a id="domani" href="#" class="ui-btn">DOMANI</a>'
		+ '</div>';
    
    return html;
}

function get_no_lessons()
{
    var html = '<div class="div-free-hours ui-body ui-body-a ui-corner-all">'
			+ '<h3>NON CI SONO LEZIONI</h3>'
			+ '</div>';
        
    return html;
}

function get_footer(next_update)
{
    var config = jQuery.data(document.body, "config");
    var secondi = config["refresh_interval"];
	
	var html = '<div id="page-bottom">'
		+ '</br><a id="back" href="#" class="ui-btn ui-btn-inline">HOME</a>'
		+ '</br></br>'
		+ 'Le aule libere sono aggiornate ogni ' + secondi + ' secondi dall` <a id="qui">orario</a>.<br> '
		+ 'Prossimo aggiornamento tra '	+ next_update + ' secondi.'
		+ '<h3>'
		+ config["footer"]
		+ '</h3>'
		+ '</div>'
		;
        
    return html;
}