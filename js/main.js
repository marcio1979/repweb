$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip(); 
});

function copyToClipboard(e, text) {
				
	var msg = text;
	
	var $temp = $("<input>");
    $("body").append($temp);
    $temp.val(msg).select();
    document.execCommand("copy");
    $temp.remove();
    
    e.className = 'btn btn-default btn-copy disabled';
    e.text = 'Copiado';
    
    setTimeout(function(){ e.className = 'btn btn-default btn-copy'; e.text = 'Copiar'; }, 1500);
}

function displayAlert(msg) {
				
	$('#msgAlert').html(msg);
	$("#msgAlert").fadeTo(3000, 500).slideUp(500, 
		function(){
			$("#msgAlert").slideUp(500);
		}
	);
}

function spinner (show) {
	if (show == 1) {
		$("#spinner").show();
		$("#shadow").show();
	} else {
		$("#spinner").hide();
		$("#shadow").hide();
	}
}

function deleteRow(label, pagina) {
	$("#deletePage").val(pagina);
	$("#deleteLabel").html(label);
	$("#confirmDelete").modal('show');
}

function confirmDelete() {
	
    spinner(1);
    $("#confirmDelete").modal('hide');
    var deletePage = $('#deletePage').val();
    
    $.ajax({
		url: deletePage,
		type: "GET",
		success: function( data ) {
			if (!data) { 
				displayAlert('<div class="alert alert-danger">Ocorreu um erro na exclusão!</div>');
			} else {
				$('#row' + data).remove();
				var qt = $("#qtRows").html();
				$("#qtRows").html(qt-1);
				displayAlert('<div class="alert alert-success">Excluido com sucesso!</div>');
			}
			
			spinner(0);
		}
	});
}

function redirect (page) {
	self.location = page;
	spinner(1);
}

function number_format (number, decimals, dec_point, thousands_sep) {
    number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
    var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
        s = '',
        toFixedFix = function (n, prec) {
            var k = Math.pow(10, prec);
            return '' + Math.round(n * k) / k;
        };
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '').length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1).join('0');
    }
    return s.join(dec);
}

function numeros (e){
    var tecla=(window.event)?event.keyCode:e.which;   
    if((tecla>47 && tecla<58)) return true;
    else{
    	if (tecla==8 || tecla==0) return true;
	else  return false;
    }
}