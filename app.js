var writing = false;
var main = function()
{
	$('#search').change(function() {
		var url = window.location.href;
		
		var val = $(this).val().split('?');
		var params = val[1].split('&');
		
		alert(params);
		
		var form = $('<form/>',
				{
					action : url,
					method : 'POST'
				});
		form.append( '<input>', 
				{
					type  : 'hidden',
					name  : 'php_file',
					value : val[0]
				});
		for(var i=0; i<params.length; i++)
		{
			var param = params[i].split('=');
			form.append( '<input>', 
					{
						type  : 'hidden',
						name  : param[0],
						value : param[1]
					});
		}
		alert(form);
		
		$('body').append(form);
		form.submit();
	});
};

$(document).ready(main);
