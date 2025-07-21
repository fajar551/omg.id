
const doSubmit = (btnEl) => {
	$(btnEl).attr({"disabled": true}).html("Loading...");
}

const toggleLoading = (btnEl, isLoading = false, label = 'Submit') => {
	$(btnEl).attr({"disabled": isLoading}).html(isLoading ? "Loading..." : label);
}

const datePickerSetting = (dateFormat = 'dd/mm/yyyy') => {
	return {
		format: dateFormat,
		autoclose: true,
		orientation: 'bottom',
		todayBtn: 'linked',
		todayHighlight: true,
		clearBtn: true,
		disableTouchKeyboard: true,
	};
}

const loading = (el, show = false) => {
	$(el).html(`<div class="d-flex justify-content-center" >
					<div class="spinner-border" role="status" id="spinner">
						<span class="visually-hidden">Loading...</span>
					</div>
				</div>`);

	if (show) {
		$('#spinner').show();
	} else {
		$('#spinner').hide();
	}
}

const showHidePassword = (el, inputTarget) => {
	$(inputTarget).attr('type', $(inputTarget).is(':password') ? 'text' : 'password');

	if ($(inputTarget).attr('type') === 'password') {
		$(el).removeClass('fa-eye').addClass('fa-eye-slash');
	} else {
		$(el).removeClass('fa-eye-slash').addClass('fa-eye');
	}
}

const showToast = (config = {}) => {
	const Toast = Swal.mixin({
		toast: true,
		position: 'top-end',
		showConfirmButton: true,
		confirmButtonColor: '#DABAFF',
		confirmButtonText: 'OK!',
		timerProgressBar: true,
		timer: 5000,
		didOpen: (toast) => {
			toast.addEventListener('mouseenter', Swal.stopTimer)
			toast.addEventListener('mouseleave', Swal.resumeTimer)
		}
	});

	Toast.fire(config);
}

const toIDRFormat = (price, decimal = 0) => { 
	price = parseInt(price || 0);
	return 'Rp' + Number(price.toFixed(decimal)).toLocaleString().replace(/\./g, "@").replace(/,/g, ".").replace(/@/g, ","); 
}

const kFormatter = (num) => {
	return Math.abs(num) > 999 ? Math.sign(num) * ((Math.abs(num) / 1000).toFixed(1)) + 'k' : Math.sign(num) * Math.abs(num)
}

const kNFormatter = (num, digits = 1) => {
	let si = [
	  { value: 1, symbol: "" },
	  { value: 1E3, symbol: "K+" },
	  { value: 1E6, symbol: "M+" },
	  { value: 1E9, symbol: "B+" },
	  { value: 1E12, symbol: "T+" },
	  { value: 1E15, symbol: "P+" },
	  { value: 1E18, symbol: "E+" }
	];
	let rx = /\.0+$|(\.[0-9]*[1-9])0+$/;
	let i;

	for (i = si.length - 1; i > 0; i--) {
	  if (num >= si[i].value) {
		break;
	  }
	}
	
	return (num / si[i].value).toFixed(digits).replace(rx, "$1") + si[i].symbol;
}

function escape(htmlStr) {
	return htmlStr.replace(/&/g, "&amp;")
		  .replace(/</g, "&lt;")
		  .replace(/>/g, "&gt;")
		  .replace(/"/g, "&quot;")
		  .replace(/'/g, "&#39;");
 }
 
 function unEscape(htmlStr) {
	 htmlStr = htmlStr.replace(/&lt;/g , "<");	 
	 htmlStr = htmlStr.replace(/&gt;/g , ">");     
	 htmlStr = htmlStr.replace(/&quot;/g , "\"");  
	 htmlStr = htmlStr.replace(/&#39;/g , "\'");   
	 htmlStr = htmlStr.replace(/&amp;/g , "&");
	 return htmlStr;
 }