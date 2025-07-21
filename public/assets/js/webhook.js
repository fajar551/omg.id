/**
* Manage integration scripts
* Version: 1.0
*/
(function ($) {
	"use strict";

	const postWebhook = async (type, el) => {
		$(el).attr({"disabled": true}).html("Loading...");
		
		await axios.post('/api/integration/webhook/test', { type })
			.then(function (response) {
				const { data } = response;
				const { result } = data.data;
				let message = result[0].message;

				if (message) {
					Toast.fire({ icon: 'info', title: `${message}`, });
				}

				// console.log(data);
			})
			.catch(function (error) {
				console.log(error);
			});

		$(el).attr({"disabled": false}).html("Test Notifikasi");
	}

	const switchStatus = async (state, el, type) => {
		$(el).attr({"disabled": true});
		// $("#lbl-switch-status").html("@lang('page.loading')");

		await axios.put(`/api/integration/webhook/switch-status`, {
			state,
			key: type
		}).then(function(response) {
			const { data } = response;
			const { message, status } = data;

			$("#btn-test").attr({ "disabled": !status });
			Toast.fire({
				icon: 'info',
				title: `${message}`,
			});

			// console.log(status);
		}).catch(function(error) {
			console.log(error);
		});

		$(el).attr({"disabled": false});
		// $("#lbl-switch-status").html("@lang('form.lbl_turn_on_off')");
	}

	$(document).on('click', '.btn-test', function(e) {
		postWebhook($(this).attr('data-type'), this);
	});

	$(document).on('change', '#switch-status', function() {
		const value = $(this).is(':checked') ? 1 : 0;
		$('#status').val(value);

		if(enableAction == 1) {
			switchStatus(value, this, $(this).attr('data-type'));
		}
	});
})(jQuery);
