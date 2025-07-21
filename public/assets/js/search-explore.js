/**
* Search explore script
* Version: 1.0
*/
(function ($) {
   "use strict";

   $(document).on('click', '.btn-search:visible', function(e) {
      let qWords = $('.form-search:visible').val();
      location.href = `/explore?keywords=${qWords}`;
   });

   $(document).on('keypress', '.form-search:visible', function(e) {         
      if(e.keyCode == 13) {
         e.preventDefault();
         $('.btn-search:visible').trigger('click');
      }
   });

   $(document).on('change', '.form-search:visible', function(e) {
      $('.form-search').val($('.form-search:visible').val());
   });

   $(() => {
      const urlParams = new URLSearchParams(window.location.search);
      const params = urlParams.get('keywords');

      $('.form-search').val(params || "");
   });

})(jQuery);
