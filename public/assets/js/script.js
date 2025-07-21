const token = document.head.querySelector("[name~=auth][content]");
let access_token = '';
if(token){
  access_token = token.content;
}

const headers = { 
	'Authorization': `Bearer ${access_token}`,
};

const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: true,
	confirmButtonColor: '#3085d6',
	confirmButtonText: 'OK!',
    timerProgressBar: true,
    timer: 5000,
	didOpen: (toast) => {
		toast.addEventListener('mouseenter', Swal.stopTimer)
		toast.addEventListener('mouseleave', Swal.resumeTimer)
	}
});

const showNoSelectionToast = (message = null) => {
  Toast.fire({
      icon: 'warning',
      title: message ?? 'No items selected.',
  });
}

try {
	const clipboard = new ClipboardJS('.copy');
	clipboard.on('success', function (e) {
	  Toast.fire({ icon: 'success', title: 'URL successfully copied to clipboard', });
	});
	
	clipboard.on('error', function (e) {
	  Toast.fire({ icon: 'error', title: 'Error copied to clipboard', });
	});
} catch (error) {
	
}

/* payment mitrans */

/* const xendit =['ovo','dana','linkaja','sampoernava','shopeepay']; */
const xendit =['ovo','dana','linkaja','sampoernava'];

// const applyFont = (font) => {
//    console.log('You selected font: ' + font);
// 		// Replace + signs with spaces for css
// 		font = font.replace(/\+/g, ' ');
// 		// Split font into family and weight/style
// 		font = font.split(':');
// 		var fontFamily = font[0];
// 		var fontSpecs = font[1] || null;
// 		var italic = false, fontWeight = 400;
// 		if (/italic/.test(fontSpecs)) {
// 			italic = true;
// 			fontSpecs = fontSpecs.replace('italic','');
// 		}
// 		fontWeight = +fontSpecs;
// 		// Set selected font on paragraphs
// 		var css = {
// 			fontFamily: "'"+fontFamily+"'",
// 			fontWeight: fontWeight,
// 			fontStyle: italic ? 'italic' : 'normal'
// 		};
// 		//$('.container').css(css);
		
//     $('iframe').contents().find('body').css(css);
// }

// const useFont = (font) => {
// 	font = font.replace(/\+/g, ' ');
// 	font = font.split(':');
// 	var fontFamily = font[0];
// 	var fontSpecs = font[1] || null;
// 	var italic = false, fontWeight = 400;
// 	if (/italic/.test(fontSpecs)) {
// 		italic = true;
// 		fontSpecs = fontSpecs.replace('italic','');
// 	}
// 	fontWeight = +fontSpecs;
// 	// Set selected font on paragraphs
// 	var css = {
// 		fontFamily: "'"+fontFamily+"'",
// 		fontWeight: fontWeight,
// 		fontStyle: italic ? 'italic' : 'normal'
// 	};
// 	console.log(css,'css');
// 	//$('.container').css(css);
//    $('body').css(css);
// }

try {
	$('.selectfont').fontselect().on('change', function() {
		  //applyFont(this.value);
		  let font = $(this).val().replace(/\+/g, ' ');
		  font = font.split(':');
	
		/*
		var link ='https://fonts.googleapis.com/css?family='+font;
		if($('iframe').contents().find("link[href*='" + link + "']").length === 0){
			$('iframe').contents().find('link').after('<link href="' + link + '" rel="stylesheet" type="text/css">');
		}
		  $('iframe').contents().find('body').css('font-family', font[0]);
		*/
	
		  $('#font1').val(this.value);
	});
} catch (error) {

}

const getDataAtribute=(selector,id,result=null) => {
	if (result === null) {
		return $(selector+id).data();
	} else {
		return  $(selector+id).data(result);
	}
}

const loadingIn = () =>{
	$('#loading').fadeIn();
}

const loadingOut=()=>{
	$('#loading').fadeOut();
}

const Rupiah=(number,prefix)=>{
	var number_string = number.toString(),
	split           = number_string.split(','),
	sisa             = split[0].length % 3,
	rupiah             = split[0].substr(0, sisa),
	ribuan             = split[0].substr(sisa).match(/\d{3}/gi);
	if(ribuan){
		separator = sisa ? '.' : '';
		rupiah += separator + ribuan.join('.');
  	}
	rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
	return prefix !== undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
}

/** get integer only */
const GeInttOnly=(evt)=> {
	var charCode = (evt.which) ? evt.which : event.keyCode;
	if (charCode > 31 && (charCode < 48 || charCode > 57)) {
		return false;
	}
  
	return true;
}

//$('.use-tooltip').tooltip('#options');