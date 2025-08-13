function loadMainContent(url)
{
	showProgres();
	$.post(site_url+url
			,{}
			,function(result) {
				$('#app-content').html(result);
				hideProgres();
			}					
			,"html"
		);
}
function setTitle(cTitle)
{
	$('#title-cont').html(cTitle);
}

function showProgres()
{
	$('#progres_cont').show();
}
function hideProgres()
{
	$('#progres_cont').hide();
}
function pesan_success(msg)
{
       var unique_id = $.gritter.add({
            // (string | mandatory) the heading of the notification
            title: 'Success!',
            // (string | mandatory) the text inside the notification
            text: msg,
            // (string | optional) the image to display on the left
            image: site_url+'assets/images/Success.png',
            // (bool | optional) if you want it to fade out on its own or just sit there
            sticky: true,
            // (int | optional) the time you want it to be alive for before fading out
            time: '',
            // (string | optional) the class name you want to apply to that specific message
            //class_name: 'my-sticky-class'
        });
		// You can have it return a unique id, this can be used to manually remove it later using
        
         setTimeout(function(){

         $.gritter.remove(unique_id, {
         fade: true,
         speed: 'slow'
         });

         }, 6000)
         /**/
}
function pesan_error(msg)
{
       var unique_id = $.gritter.add({
            // (string | mandatory) the heading of the notification
            title: 'Failed!',
            // (string | mandatory) the text inside the notification
            text: msg,
            // (string | optional) the image to display on the left
            image: site_url+'assets/images/Warning.png',
            // (bool | optional) if you want it to fade out on its own or just sit there
            sticky: true,
            // (int | optional) the time you want it to be alive for before fading out
            time: '',
            // (string | optional) the class name you want to apply to that specific message
            //class_name: 'my-sticky-class'
        });
		// You can have it return a unique id, this can be used to manually remove it later using
        
         setTimeout(function(){

         $.gritter.remove(unique_id, {
         fade: true,
         speed: 'slow'
         });

         }, 6000)
         /**/
}
function validate_value(ob,message,ln)
{
	obj = $('#'+ob);
	obj.closest('div').removeClass("f_error");
	if (!obj.val() || (obj.val()==0) || ln)
	{
		var c_ln = obj.val().length;			
		if (ln && c_ln)
		{
			if (c_ln < ln)
			{
				message = 'Minimal '+ln+' character';
			}else
			{
				return true;
			}
		}
		var error_message = '<label for="'+ob+'" generated="true" class="error" style="">';
		if (!message)
		{
			error_message = error_message + 'This field is required';
		}else
		{
			error_message = error_message + message;
		}
		error_message = error_message + '</label>';
		obj.closest('div').addClass("f_error");
		obj.closest('div').append(error_message);
		
		nError = nError + 1;
		return false;
	}else
	{
		return true;
	}
}
// datepicker
function objDate(obj)
{
	$('#'+obj).datepicker({
            format: 'dd-mm-yyyy'
        });
	//$('#'+obj).datepicker(({format: "dd-mm-yyyy"}));
}

function numberOnly(evt) 
{
	var theEvent = evt || window.event;
	var key = theEvent.keyCode || theEvent.which;
	key = String.fromCharCode( key );
	var regex = /[0-9]|\./;
	if( !regex.test(key) ) 
	{
		theEvent.returnValue = false;
		if(theEvent.preventDefault) theEvent.preventDefault();
	}
}
// untuk merubah format angka menjadi mata uang
function thausand_spar(nStr)
{
	nStr += '';
	x = nStr.split('.');
	x1 = x[0];
	x2 = x.length > 1 ? '.' + x[1] : '';
	var rgx = /(\d+)(\d{3})/;
	while (rgx.test(x1)) {
		x1 = x1.replace(rgx, '$1' + ',' + '$2');
	}
	return x1 + x2;
}
/* 
Added by Ricky 20170421
fungsi untuk number_format di javascript
*/
function number_format (number, decimals, decPoint, thousandsSep) { // eslint-disable-line camelcase
  number = (number + '').replace(/[^0-9+\-Ee.]/g, '')
  var n = !isFinite(+number) ? 0 : +number
  var prec = !isFinite(+decimals) ? 0 : Math.abs(decimals)
  var sep = (typeof thousandsSep === 'undefined') ? ',' : thousandsSep
  var dec = (typeof decPoint === 'undefined') ? '.' : decPoint
  var s = ''

  var toFixedFix = function (n, prec) {
	var k = Math.pow(10, prec)
	return '' + (Math.round(n * k) / k)
	  .toFixed(prec)
  }

  // @todo: for IE parseFloat(0.55).toFixed(0) = 0;
  s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.')
  if (s[0].length > 3) {
	s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep)
  }
  if ((s[1] || '').length < prec) {
	s[1] = s[1] || ''
	s[1] += new Array(prec - s[1].length + 1).join('0')
  }

  return s.join(dec)
}