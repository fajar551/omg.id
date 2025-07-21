

const loadSuport=()=>{
   const getItemPrice=$('.card-items').data('price');
   $('#calctotal').html(Rupiah(getItemPrice));
}
loadSuport();


/* $('.qty-control').change(function() {
   let id=$(this).data('id');
   let price =$('#item-box-'+id).data('price');
   let value=$(this).val();
   let total=parseInt(value) * parseInt(price);
   const totalqty = $('#item-box-'+id+' #totalqty');
   const totalitem =  $('#item-box-'+id+' #totalitem');
   const btnMin = $('#item-box-'+id+' .btn-minus');
   const inputqty =$('#qty'+id);
   inputqty.val(value);
   totalqty.html(value);
   totalitem.html(total);
   if(value > 0){
      totalqty.removeClass('d-none');
      totalitem.removeClass('d-none');
      btnMin.removeAttr('disabled');
   }else{
      totalqty.addClass('d-none');
      totalitem.addClass('d-none');
      btnMin.attr('disabled',true);
   }
   const countitem =$('#container-item').data('count');
   let items=[];
   let alltotal=0;
   for (let i = 0; i < countitem; i++) {
      let getvalue=$('#qty'+i);
          if(getvalue.val() > 0 ){
            alltotal += getvalue.val() * $('#item-box-'+getvalue.data('id')).data('price');
          }
   }
   if(alltotal > 0){
      alltotal=parseInt(alltotal);
      $('#subtotal span').html(Rupiah(alltotal));
      $('#subtotal').removeClass('d-none');
   }else{
      $('#subtotal span').html();
      $('#subtotal').addClass('d-none');
   }
}); */

/* new item QTY */
$(document).on('click', '.number-spinner button', function(){    
   var btn = $(this),
      oldValue = btn.closest('.number-spinner').find('input').val().trim(),
      newVal = 0;
   if (btn.attr('data-dir') == 'up') {
      newVal = parseInt(oldValue) + 1;
   } else {
      if (oldValue > 1) {
         newVal = parseInt(oldValue) - 1;
      } else {
         newVal = 1;
      }
   }
   
   if(newVal <= 1){
      $('.number-spinner .input-group-btn:first-of-type button').attr('disabled','disabled');
   }else{
      $('.number-spinner .input-group-btn:first-of-type button').removeAttr('disabled');
   }
   /* validate */
  /*  const creatornotif=$('#creatornotif');
   let htmlnotif=`<div class="alert alert-danger" role="alert">Maximal Rp.10.000.000</div>`;
   creatornotif.html();
   if(newVal <= 10000000){
      $('.number-spinner .input-group-btn:last-of-type button').removeAttr('disabled');
      btn.closest('.number-spinner').find('input').removeAttr('disabled');
      creatornotif.html();
   }else{
      $('.number-spinner .input-group-btn:last-of-type button').attr('disabled','disabled');
      btn.closest('.number-spinner').find('input').attr('disabled','disabled');
      creatornotif.html(htmlnotif);
      setTimeout(function(){
         creatornotif.empty();
      },3000);
      return false;
   } */
   btn.closest('.number-spinner').find('input').val(newVal);
   const itemcard=$('.card-items').data('price');
   const CartTotal=$('#calctotal');
   let totalPriceItems=newVal * itemcard;
   //console.log(totalPriceItems,'totalPriceItems');
   CartTotal.html(Rupiah(totalPriceItems));
   return false;
});

/* input qty manual */
$('#inputQty').on('change paste keyup', event => {
   const CartTotal=$('#calctotal');
   let intItem=$('#inputQty').val();
   if(intItem == 0){
      $('#inputQty').val(1);
      intItem=1;
   }
   const itemcard=$('.card-items').data('price');
   let totalPriceItems=intItem * itemcard;
  /*  validTotal(totalPriceItems); */
   CartTotal.html(Rupiah(totalPriceItems));
   return false;
}); 

const validTotal=(total)=>{
   const creatornotif=$('#creatornotif');
   let htmlnotif=`<div class="alert alert-danger" role="alert">Maximal Rp.10.000.000</div>`;
   if(total > 10000000){
      $('.number-spinner .input-group-btn:last-of-type button').attr('disabled','disabled');
      creatornotif.html(htmlnotif);
      setTimeout(function(){
         creatornotif.empty();
      },3000);
      return false;
   }else{
      creatornotif.empty();
      $('.number-spinner .input-group-btn:first-of-type button').removeAttr('disabled');

   }
}
const validTotalisBool=(total)=>{
   if(total > 10000000){
      return false;
   }else{
      return true;
   }
}




const format=(state) => {
   if (!state.id) return state.text; 
    return "<img class='flag' src='images/flags/" + state.id.toLowerCase() + ".png'/>" + state.text;
}
$("#e4").select2({
   formatResult: format,
   formatSelection: format,
   escapeMarkup: function(m) { return m; }
});

/*payment */
const withmitrans=(type)=>{
   loadingIn();
   $.ajax({
      type: 'POST',
      url: api_url+'support/snaptoken',
      data: getJsonparam(),
      dataType: 'json',
      headers : headers,
      success: function(data){
         loadingOut()
         //console.log(data,'token');
         snap.pay(data.token,{
            selectedPaymentType : type,
            onSuccess: function(result){
               console.log(result,'success');
               let param= margeharge(data.param,result);
              
               /*console.log(param,'param success');*/
               snapcharge(param);
               
               /*console.log('success');console.log(result);*/
            },
            onPending: function(result){
               let param= margeharge(data.param,result);
               console.log(param,'pending');
               snapcharge(param);
            },
            onError: function(result){
               loadingOut();
               Toast.fire({ icon: 'error', title: 'Your payment has expired, please try again'});
               $('#formsupport')[0].reset();
               return false;
            },
            onClose: function(){
               console.log('customer closed the popup without finishing the payment');
            }
         });
         return false;
      }
  });

  return false;
}


const margeharge = (param,result) => {
   const pgid = $('input[name="payment_method_id"]:checked').val();
   return {
      "page_url": param.page_url,
      "name": param.name,
      "email": param.email,
      "supporter_id": param.supporter_id,
      "type": param.type,
      "content_id": param.content_id,
      "message": param.message,
      "payment_method_id" : pgid,
      "items": param.items,
      "snapresponse" : result
   };
}



/* snapcharge */
const snapcharge=(data) => {
   loadingIn();
   const payementstatus = data.snapresponse.order_id;

   $.ajax({
      type: 'POST',
      url: api_url+'support/snapcharge',
      data: data,
      dataType: 'json',
      headers : headers,
      success: function(data){
        
         if(data.code == 200 ){
           
           
            
               window.location.href=`${app_url}${pageName}/support/${payementstatus}/status`;
           
            loadingOut();
            return false;
         }else{
            loadingOut();
            Toast.fire({ icon: 'error', title: data});
         }
         
      }
   });
   return false;
}

const withXenditEwallet= () =>{
   loadingIn();
   $.ajax({
      type: 'POST',
      url: api_url+'support/paymentcharge',
      data: getJsonparamXendit(),
      dataType: 'json',
      headers : headers,
      success: function(data){
         /* console.log(data,'xendit e wallet'); 
         return false; */
         if(Object.keys(data.data).length === 0){
            Toast.fire({ icon: 'error', title: 'error something went wrong..!'});
            return false;
         }
         
         if(data.code == 200 ){
            var redirect='';
            switch(data.data.channel_code){
               case 'ID_OVO':
                  loadingOut();
                  Swal.fire({
                     icon: 'info',
                     title: 'Ovo',
                     text: lang.payment.ovo.open_app
                  })
                  
                  // const pgStatus=app_url+'payment-status/'+data.data.reference_id;
                  const pgStatus=`${app_url}${pageName}/support/${data.data.reference_id}/status`;
                  setTimeout(() => {
                     window.location.href = pgStatus;
                  }, 3000);

                  return false;
               break;
               case "ID_DANA":
                  redirect = data.data.actions.desktop_web_checkout_url;
               break;
               case "ID_LINKAJA":
                  redirect =  data.data.actions.desktop_web_checkout_url;
               break;
               /* case "ID_SHOPEEPAY":
                  redirect =  data.data.actions.mobile_deeplink_checkout_url;
               break; */
               
            }
            loadingOut();
            /* //console.log(redirect,'redirect'); */
            Toast.fire({icon: 'info', title: data.data.message});
            /* //console.log(data,'data xendit'); */
            window.location.href = redirect;
            return false;
         }
         Toast.fire({ icon: 'error', title: data.result});
         return false;
      }
  });

}

$('input[name="payment_method_id"]').change(function(){
   selected_value = $("input[name='payment_method_id']:checked").val();
   if(selected_value){
      $('.payment-list').removeClass('pay-invalid');
      $('#validator-payment').removeClass('d-block');
      $('#validator-payment2').removeClass('d-block');
   }
});

const cektotal=()=>{
   const qty=$('#inputQty').val();
   const itemcard=$('.card-items').data('price');
   let total =qty * itemcard;
   if(total > 10000000){
      return false;
   }else{
      return true;
   }
}



$( "#formsupport" ).submit(function( event ){
   event.preventDefault();
   const pgid = $('input[name="payment_method_id"]:checked').val();
   const pgdata=getDataAtribute('#pg-list-',pgid);
   const from =$('#fromuser').val();
   const email =$('#useremail').val();
   const selectorPayment=$('.payment-list');
   const validatorPayment=$('#validator-payment');
   const validatorPayment2=$('#validator-payment2');
   const is_total=cektotal();
   

   if(from === '' || email === '' || pgid === ''){
      if(pgid === '' || pgid === undefined ){
         validatorPayment.addClass('d-block');
         validatorPayment2.addClass('d-block');
         selectorPayment.addClass('pay-invalid');
      }
      $('.invalid-feedback').addClass('d-block');
      return false;
   }
   
   if(pgid === '' || pgid === undefined ){
      validatorPayment.addClass('d-block');
      validatorPayment2.addClass('d-block');
      selectorPayment.addClass('pay-invalid');
   }

   if(!is_total){
      Swal.fire({
         icon: 'error',
         title: 'Oops...',
         text: 'Maximal Total Rp. 10.000.000'
       });
       return false;
   }




   if(!xendit.includes(pgdata.type)){
      Swal.fire({
            title: lang.payment.confirmation+'..',
            text: lang.payment.continue_payment['with_'+pgdata.type],
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: lang.payment.btn.confrim.continue
         }).then((result) => {
            if (result.isConfirmed) {
                  withmitrans(pgdata.type);
            }
            return false;
         });
   }else{
      /* Link aja ovo */
      if(['1','2','4'].includes(pgid)){
         Swal.fire({
            title: 'Pay with '+pgdata.name,
            icon: 'info',
            input: 'text',
            inputLabel: lang.payment.form.lbl_mobile_nummber,
            inputPlaceholder: '62812345678',
            showCancelButton : true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            inputValidator : (value) => {
               if (!value) {
                 return lang.payment.phone_number;
               }else{
                  

                  if(!/^[0-9]+$/.test(value)){
                     return "Please only enter numeric (Allowed input:0-9)";
                  }
                  
                  if(value.length < 10 || value.length > 13){
                     return 'Invalid phone number';
                  }
                  let Nummber = value.toString();
                  if(Nummber.substring(0, 2) != '62' ){
                     //return 'use prefix 62xxxxxx';
                     let value = '62'+Nummber.substring(2);
                     $('#tmp').html(`<input type="hidden" name="phone_number" value="`+value+`">`);
                  }else{
                     $('#tmp').html(`<input type="hidden" name="phone_number" value="`+value+`">`);
                  };
                 withXenditEwallet();
               }
             }
         })
          
      }else{
         console.log('testt');
      }
   }
});



const getJsonparam=() => {
   /* const countitem =$('#container-item').data('count');
   let items=[];
   for (let i = 0; i < countitem; i++) {
      let getvalue=$('#qty'+i);
          if(getvalue.val() > 0 ){

            var obj = {
               item_id : getvalue.data('id'),
               qty : getvalue.val()
            };
            items.push(obj);
          }
   } */
   const product=$('.card-items');
   const qtySelect=$('#inputQty').val();

   let items=[{ 
                  item_id : product.data('id'),
                  qty : qtySelect
            }];  

   let media_shared = null;
   if ($('#youtubeurl').val()) {
      media_shared = {
         url : $('#youtubeurl').val(),
         startSeconds : $('#youtubestart').val() == '' ? 0 : $('#youtubestart').val() 
      };
   }

   let param={
                  page_url : $('input[name="page_url"]').val(),
                  name: $('#fromuser').val(),
                  email: $('#useremail').val(),
                  supporter_id : $('#supporter_id').val(),
                  type: $('input[name="type"]').val(),
                  content_id: $('#content_id').val(),
                  message: $('#frommassage').val(),
                  items: items,
                  media_share:media_shared,
                  payment_method_id: $('input[name="payment_method_id"]:checked').val(),
             };
   return param;
}

/*ewallet*/
const getJsonparamXendit=() => {
   /* const countitem =$('#container-item').data('count');
   let items=[];
   for (let i = 0; i < countitem; i++) {
      let getvalue=$('#qty'+i);
          if(getvalue.val() > 0 ){
            var obj = {
               item_id : getvalue.data('id'),
               qty : getvalue.val()
            };
            items.push(obj);
          }
   } */
   const pgid = $('input[name="payment_method_id"]:checked').val();
   const product=$('.card-items');
   const qtySelect=$('#inputQty').val();
   let items=[{ 
                  item_id : product.data('id'),
                  qty : qtySelect
            }];

   let media_shared = null;
   if ($('#youtubeurl').val()) {
      media_shared = {
         url : $('#youtubeurl').val(),
         startSeconds : $('#youtubestart').val() == '' ? 0 : $('#youtubestart').val() 
      };
   }

   let param={
                  page_url : $('input[name="page_url"]').val(),
                  payment_method_id : pgid,
                  phone_number:$('input[name="phone_number"]').val(),
                  supporter_id : $('#supporter_id').val(),
                  name: $('#fromuser').val(),
                  email: $('#useremail').val(),
                  type: $('input[name="type"]').val(),
                  content_id: $('#content_id').val(),
                  message: $('#frommassage').val(),
                  items: items,
                  media_share:media_shared
             };

   return param;
}


$( "#btn-mediashare" ).click(function() {
   let mediashare=$('#main-mediashare');
   const selectorClasss='d-none';
   if(mediashare.hasClass(selectorClasss)){
      mediashare.removeClass(selectorClasss);
      $(this).addClass('active');
   }else{
      mediashare.addClass(selectorClasss);
      $(this).removeClass('active');
   }
   return false;
});

$('#youtubeurl').on('change paste keyup', event => {
   let int =  $('#youtubeurl').val();
   let addValidator=$('#youtubestart');
   console.log(int,'kaodkadjakdhadjad');
   if(int){
      addValidator.attr('required','required');
   }else{
      addValidator.removeAttr('required');
   }
});
//selectPG
$('#selectPG').on('change paste keyup', event => {
   let value =$('#selectPG').val();
   if(value === 0 ){
       $('#pg-desktop input').removeAttr('checked');
       /* $('#input-pg-'+value).attr('checked','checked'); */
   }else{
      $('#pg-desktop input').removeAttr('checked');
      $('#input-pg-'+value).attr('checked','checked');
   }
});