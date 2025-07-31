$(function (){
    var navHeight = $('nav.navbar').height()+190;
       const widgetTarget=$('.overlaysticky');
       if($(window).scrollTop() > navHeight){
          /* $('body').css('margin-top',navHeight); */
          widgetTarget.addClass('fixed');
       }
       else{
          widgetTarget.removeClass('fixed');
       }
       
    $(window).scroll(function(){
       if($(window).scrollTop() > navHeight){
          widgetTarget.addClass('fixed');
       }
       else{
          widgetTarget.removeClass('fixed');
       }
     });

   //   var header = document.getElementById("overlay-preview-div");
   //   var sticky = header.offsetTop;

   //   $(window).scroll(function(){
   //    if (window.pageYOffset > sticky) {
   //       header.classList.add("stickies");
   //    } else {
   //       header.classList.add("stickies");
   //       // header.classList.remove("stickies");
   //    }
   //  }); 
   
   make_sticky('#overlay-preview-div');

 });

function make_sticky(id) {
   var e = $(id);
   var w = $(window);
   $('<div/>').insertBefore(id);
   $('<div/>').hide().css('height',e.outerHeight()).insertAfter(id);
   var n = e.next();
   var p = e.prev();
   function sticky_relocate() {
     var window_top = w.scrollTop();
     var div_top = p.offset().top;
     if (window_top > div_top) {
       e.addClass('stickies');
       n.show();
     } else {
       e.removeClass('stickies');
       n.hide();
     }
   }
   w.scroll(sticky_relocate);
   sticky_relocate();
}