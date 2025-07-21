/**
* Page support scripts
* Version: 1.1
*/
(function ($) {
   "use strict";

   /* Global Vars */
   const xenditPG = ['ovo', 'dana', 'linkaja', 'sampoernava'];
   const midtransPG = ['gopay', 'shopeepay', 'qris'];
   const maxSupport = 10000000;
   const itemPrice = $('.card-items').data('price');

   const initSupport = () => {
      const getItemPrice = $('.card-items').data('price');
      $('#calctotal').html(Rupiah(getItemPrice));
   }

   initSupport();

   /* Qty items spinner */
   $(document).on('click', '.number-spinner button', function() {    
      let btn = $(this);
      let oldValue = btn.closest('.number-spinner').find('input').val().trim();
      let newVal = 0;
      let content_price = $('#content_price').val();

      if (btn.attr('data-dir') == 'up') {
         newVal = parseInt(oldValue) + 1;
      } else {
         if (content_price) {
            if ($('#content_price').val() != 0) {
               if (oldValue > $('#content_price').val()) {
                  newVal = parseInt(oldValue) - 1;
               } else {
                  newVal = $('#content_price').val();
               }
            }else{
               if (oldValue > 1) {
                  newVal = parseInt(oldValue) - 1;
               } else {
                  newVal = 1;
               }
            }
         } else {
            if (oldValue > 1) {
               newVal = parseInt(oldValue) - 1;
            } else {
               newVal = 1;
            }
         }
      }
      
      if (newVal <= 1) {
         $('.number-spinner .input-group-btn:first-of-type button').attr('disabled','disabled');
      } else {
         $('.number-spinner .input-group-btn:first-of-type button').removeAttr('disabled');
      }

      const itemcard = $('.card-items').data('price');
      const cartTotal = $('#calctotal');
      
      if (!checkTotal() && btn.attr('data-dir') == 'up') {
         Toast.fire({
            icon: 'warning',
            title: 'Oops...',
            text: 'Maximun total support only: Rp.10.000.000'
         });
         
         return;
      }
      
      btn.closest('.number-spinner').find('input').val(newVal);
      let totalPriceItems = newVal * itemcard;

      cartTotal.html(Rupiah(totalPriceItems));
   });

   /* handle manual input qty */
   $('#inputQty').on('change paste keyup', event => {
      const itemcard = $('.card-items').data('price');
      const cartTotal = $('#calctotal');
      let intItem = $('#inputQty').val();
      let content_price = $('#content_price').val();

      if (content_price) {
         if(intItem == 0) {
            if ($('#content_price').val() != 0) {
               $('#inputQty').val($('#content_price').val());
               intItem = $('#content_price').val();
            }else{
               $('#inputQty').val(1);
               intItem = 1;
            }
            
         }
      } else {
         $('#inputQty').val(1);
         intItem = 1;
      }
      

      let totalPriceItems = intItem * itemcard;      
      cartTotal.html(Rupiah(totalPriceItems));      
   }); 

   /*
   const format = (state) => {
      if (!state.id) return state.text; 

      return "<img class='flag' src='images/flags/" + state.id.toLowerCase() + ".png'/>" + state.text;
   }

   $("#e4").select2({
      formatResult: format,
      formatSelection: format,
      escapeMarkup: function(m) { return m; }
   });
   */

   /* Get snap token with Midtrans */
   const withMidtrans = (type) => {
      $.ajax({
         type: 'POST',
         url: `${vars.apiURL}/support/snaptoken`,
         data: getJsonparam(),
         dataType: 'json',
         headers: headers,
         beforeSend: function() {
            $('#btn-pay').attr({"disabled": true}).html("Loading...");
            $('#btn-show-emailguest').attr({"disabled": true}).html("Loading...");
         },
         complete: function() {
            $('#btn-pay').attr({"disabled": false}).html(langGet('form.btn_pay'));
            $('#btn-show-emailguest').attr({"disabled": false}).html(langGet('form.btn_pay'));
         },
         error: function(xhr, status, error) {
            const { message = 'Error!' } = xhr.responseJSON;
            Toast.fire({ icon: 'error', title: 'An error occured!', text: message});
         },
         success: function(data) {
            snap.pay(data.token, {
               selectedPaymentType: type,
               onSuccess: function(result) {
                  // console.log(result, 'onSuccess');
                  let param = margeCharge(data.param, result);
               
                  snapcharge(param);
                  $('#formsupport')[0].reset();
               },
               onPending: function(result) {
                  // console.log(result, 'onPending');
                  let param = margeCharge(data.param, result);

                  snapcharge(param);
                  $('#formsupport')[0].reset();
               },
               onError: function(result) {
                  // console.log(result, 'onError');
                  Toast.fire({ icon: 'error', title: 'An error occured!', text: 'Something went wrong, please refresh this page or try again later.'});

                  return false;
               },
               onClose: function() {
                  console.log('Customer closed the popup without finishing the payment', 'onClose');
               }
            });
         }
      });
   }

   /* Get snap token with Xendit */
   const withXenditEwallet = () => {
      $.ajax({
         type: 'POST',
         url: `${vars.apiURL}/support/paymentcharge`,
         data: getJsonparamXendit(),
         dataType: 'json',
         headers: headers,
         beforeSend: function() {
            $('#btn-pay').attr({"disabled": true}).html("Loading...");
            $('#btn-show-emailguest').attr({"disabled": true}).html("Loading...");
         },
         complete: function() {
            $('#btn-pay').attr({"disabled": false}).html(langGet('form.btn_pay'));
            $('#btn-show-emailguest').attr({"disabled": false}).html(langGet('form.btn_pay'));
         },
         error: function(xhr, status, error) {
            const { message = 'Error!', errors = {} } = xhr.responseJSON;
            
            Toast.fire({ icon: 'error', title: message, html: handleAjaxError(errors)});
         },
         success: function(data) {

            if(Object.keys(data.data).length === 0){
               Toast.fire({ icon: 'error', title: 'Something went wrong!'});
               return;
            }

            const { channel_code, reference_id, actions, message } = data.data;
            
            if(data.code == 200) {
               let redirect = '';
               $('#formsupport')[0].reset();

               switch(channel_code) {
                  case 'ID_OVO':
                     Toast.fire({
                        icon: 'info',
                        title: 'OVO Payment',
                        text: lang.payment.ovo.open_app
                     });
                     
                     // Redirect to payment status
                     const paymentStatus = `${vars.appURL}/${pageName}/support/${reference_id}/status`;
                     setTimeout(() => {
                        window.location.href = paymentStatus;
                     }, 3000);

                     return false;
                  case "ID_DANA":
                  case "ID_LINKAJA":
                     redirect =  actions.desktop_web_checkout_url;
                     break;
                  /* case "ID_SHOPEEPAY":
                     redirect =  actions.mobile_deeplink_checkout_url;
                     break; 
                  */
               }

               Toast.fire({icon: 'info', title: message ?? 'Please wait, Redirecting to payment checkout!'});
               setTimeout(() => {
                  window.location.href = redirect;
               }, 3000);

               return;
            }

            Toast.fire({ icon: 'warning', title: 'Something went wrong', text: data.result});            
         }
      });
   }
   const handleAjaxError = (errors) => {
      let html = [];
      for (const errorBag in errors) {
          let errorMessages = errors[errorBag];
          let message = populateError(errorMessages);

          html.push(message);
      }

      return html;
  }

  const populateError = (errorMessages) => {
      if (!errorMessages.length) return;

      return `<ul class="mb-0 ps-3">
                  ${ errorMessages.map((item, index) => `<li class="text-danger">${item}</li>`).join('') }
              </ul>`;
  }

   const margeCharge = (params, result) => {
      const pgid = $('input[name="payment_method_id"]:checked').val();
      const { page_url,  name, email, supporter_id, type, content_id, message, items } = params

      return {
         "page_url": page_url,
         "name": name,
         "email": email,
         "supporter_id": supporter_id,
         "type": type,
         "content_id": content_id,
         "message": message,
         "payment_method_id": pgid,
         "items": items,
         "snapresponse": result
      };
   }

   /* Snapcharge after snap token */
   const snapcharge = (data) => {
      const reference_id = data.snapresponse.order_id;

      $.ajax({
         type: 'POST',
         url: `${vars.apiURL}/support/snapcharge`,
         data: data,
         dataType: 'json',
         headers: headers,
         beforeSend: function() {
            $('#btn-pay').attr({"disabled": true}).html("Loading...");
         },
         complete: function() {
            $('#btn-pay').attr({"disabled": false}).html("Bayar");
         },
         error: function(xhr, status, error) {
            const { message = 'Error!' } = xhr.responseJSON;
            Toast.fire({ icon: 'error', title: 'An error occured!', text: message});
         },
         success: function(data) {
            if(data.code == 200 ) {
               window.location.href = `${vars.appURL}/${pageName}/support/${reference_id}/status`;
            } else {
               Toast.fire({ icon: 'error', title: 'An error occured!'});
               console.log(data);
            }
         }
      });

      return false;
   }

   $('input[name="payment_method_id"]').on('change', function() {
      const selected_value = $("input[name='payment_method_id']:checked").val();
      if(selected_value){
         $('.payment-list').removeClass('pay-invalid');
         $('#validator-payment').removeClass('d-block');
         $('#validator-payment2').removeClass('d-block');
      }
   });

   /* Check total payment, maximum ammount support is 10.000.000 */
   const checkTotal = () => {
      const qty = $('#inputQty').val();
      const itemcard = $('.card-items').data('price');
      let total = qty * itemcard;

      return total > maxSupport ? false : true;
   }

   /* Submit forms */ 
   $("#formsupport").on('submit', function(event) {
      event.preventDefault();

      // const isValid = document.querySelector('#formsupport').reportValidity();
      // if (!isValid) return;
      
      const pgid = $('input[name="payment_method_id"]:checked').val();
      const pgdata = getDataAtribute('#pg-list-', pgid);
      const from = $('#fromuser').val();
      const email = $('#useremail').val();
      const selectorPayment = $('.payment-list');
      const validatorPayment = $('#validator-payment');
      const validatorPayment2 = $('#validator-payment2');
      var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,9})+$/;

      if(from === ''){
         $('#feedback-from').addClass('d-block');

         return false;
      }

      if (!email.match(mailformat || email === '')) {
         $('#feedback-email').addClass('d-block');
         return false;
      }
   
      if(pgid === '' || pgid === undefined ){
         validatorPayment.addClass('d-block');
         validatorPayment2.addClass('d-block');
         selectorPayment.addClass('pay-invalid');
         return false;
      }

      if (!checkTotal()) {
         Swal.fire({
            icon: 'warning',
            title: 'Oops...',
            text: 'Maximun total support only: Rp.10.000.000'
         });

         return false;
      }
      
      const { type: pgType, name: pgName } = pgdata; 

      if (midtransPG.includes(pgType)) {
         Swal.fire({
            title: `Konfirmasi`,
            html: `Lanjutkan pembayaran dengan: <b>${pgType.toUpperCase()}</b>`,
            icon: 'info',
            showCancelButton: true,
            customClass: {
               confirmButton: 'btn btn-primary me-3',
               cancelButton: 'btn btn-secondary'
            },
            buttonsStyling: false,
            confirmButtonText: lang.payment.btn.confrim.continue
         }).then((result) => {
            if (result.isConfirmed) {
               withMidtrans(pgType);
            }
         });
      } else if(xenditPG.includes(pgType)) {
         Swal.fire({
            title: `Konfirmasi`,
            html: `Lanjutkan pembayaran dengan: <b>${pgName.toUpperCase()}</b>`,
            icon: 'info',
            input: 'text',
            inputLabel: `Masukan nomor ponsel, awali dengan: 62xxx`,
            inputPlaceholder: 'Contoh: 628123456789',
            showCancelButton : true,
            customClass: {
               confirmButton: 'btn btn-primary me-3',
               cancelButton: 'btn btn-secondary'
            },
            buttonsStyling: false,
            inputValidator : (value) => {
               if (!value) {
                  return lang.payment.phone_number;
               } else {
                  if(!/^[0-9]+$/.test(value)){
                     return "Please enter numeric only (Allowed input: 0-9)";
                  }
                  
                  if(value.length < 10 || value.length > 13){
                     return 'Invalid phone number';
                  }

                  let Nummber = value.toString();
                  if (Nummber.substring(0, 2) != '62') {
                     /* Add prefix 62xxxxxx', if prefix not exist from input value */
                     let value = `62${Nummber.substring(2)}`;

                     $('#tmp').html(`<input type="hidden" name="phone_number" value="${value}">`);
                  } else {
                     $('#tmp').html(`<input type="hidden" name="phone_number" value="${value}">`);
                  };

                  withXenditEwallet();
               }
            }
         });
      } else {
         console.log('Undefined payment gateway!');
      }
   });

   /* Midtrans Json Params */
   const getJsonparam = () => {
      const product = $('.card-items');
      const qtySelect = $('#inputQty').val();
      let items = [{ 
         item_id: product.data('id'),
         qty: qtySelect
      }];

      let media_share = null;
      if ($('#youtubeurl').val()) {
         media_share = {
            url: $('#youtubeurl').val(),
            startSeconds: $('#youtubestart').val() == '' ? 0 : $('#youtubestart').val() 
         };
      }

      return {
         page_url : $('input[name="page_url"]').val(),
         name: $('#fromuser').val(),
         email: $('#useremail').val(),
         supporter_id : $('#supporter_id').val(),
         type: $('input[name="type"]').val(),
         content_id: $('#content_id').val(),
         message: $('#frommassage').val(),
         items,
         media_share,
         payment_method_id: $('input[name="payment_method_id"]:checked').val(),
      };
   }

   /* Xendit Json Params */
   const getJsonparamXendit = () => {
      const pgid = $('input[name="payment_method_id"]:checked').val();
      const product = $('.card-items');
      const qtySelect = $('#inputQty').val();
      let items=[{ 
         item_id: product.data('id'),
         qty: qtySelect
      }];

      let media_share = null;
      if ($('#youtubeurl').val()) {
         media_share = {
            url : $('#youtubeurl').val(),
            startSeconds : $('#youtubestart').val() == '' ? 0 : $('#youtubestart').val() 
         };
      }

      return {
         page_url: $('input[name="page_url"]').val(),
         payment_method_id: pgid,
         phone_number: $('input[name="phone_number"]').val(),
         supporter_id: $('#supporter_id').val(),
         name: $('#fromuser').val(),
         email: $('#useremail').val(),
         type: $('input[name="type"]').val(),
         content_id: $('#content_id').val(),
         message: $('#frommassage').val(),
         items,
         media_share
      };
   }

   const paymentSelectRequired = (width) => {
      if (width > 768) {
         $('#pg-desktop input').attr('required', true);
         $('#pg-mobile select').attr('required', false);
      } else {
         $('#pg-desktop input').attr('required', false);
         $('#pg-mobile select').attr('required', true);
      }
   }

   /* Toggle media share click */
   $("#btn-mediashare").on('click', function() {
      let mediashare = $('#main-mediashare');
      const selectorClasss = 'd-none';

      if(mediashare.hasClass(selectorClasss)) {
         mediashare.removeClass(selectorClasss);
         $(this).addClass('active');
      } else {
         mediashare.addClass(selectorClasss);
         $(this).removeClass('active');
      }

      return false;
   });

   /* Media share options */
   $('#youtubeurl').on('change paste keyup', event => {
      let ytUrl =  $('#youtubeurl').val();
      let addValidator = $('#youtubestart');

      if (ytUrl) {
         addValidator.attr('required', 'required');
      } else {
         addValidator.removeAttr('required');
      }
   });

   /* Select PG for Mobile versions */
   $('#selectPG').on('change paste keyup', function(e) {
      let value = $('#selectPG').val();

      if (value === 0 || !value) {
         $('#pg-desktop input').removeAttr('checked');
         /* $('#input-pg-'+value).attr('checked', 'checked'); */
      } else {
         $('#pg-desktop input').removeAttr('checked');
         $(`#input-pg-${value}`).attr('checked', 'checked');
      }
   });

   $(() => {
      let isFullPage = $('input[name="is_fullpage"]').val();
      if (isFullPage) {   
         paymentSelectRequired(window.screen.width);
   
         $(window).on('resize', function() {
            let win = $(this);
            paymentSelectRequired(win.width());
         });
      } else {
         $('#pg-desktop input').attr('required', false);
         $('#pg-mobile select').attr('required', true);
      }
  });

   $(".form-control").on('keypress', function() {
      $('.invalid-feedback').removeClass('d-block');
      $('.payment-list').removeClass('pay-invalid');
   });

   $(".form-select").on('change', function() {
      $('.invalid-feedback').removeClass('d-block');
      $('.payment-list').removeClass('pay-invalid');
   });

})(jQuery);