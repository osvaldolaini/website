var App = function () {
    // scroll
    var scrollWindow = function(){
        $(window).scroll(function() {
                // checks if window is scrolled more than 500px, adds/removes solid class
                var scroll = $(window).scrollTop();
                var box = $('.header-text').height();
                var header = $('header').height();

                if (scroll >= box - header) {
                    $("header").addClass("background-header");
                } else {
                    $("header").removeClass("background-header");
                }
        });
        $(document).on("scroll", onScroll);
        //smoothscroll
        $('.scroll-to-section a[href^="#"]').on('click', function (e) {
            e.preventDefault();
            $(document).off("scroll");

            $('.scroll-to-section a').each(function () {
                $(this).removeClass('active');
            })
            $(this).addClass('active');

            var target = this.hash,
            menu = target;
            var target = $(this.hash);
            $('html, body').stop().animate({
                scrollTop: (target.offset().top) + 1
            }, 500, 'swing', function () {
                window.location.hash = target;
                $(document).on("scroll", onScroll);
            });
        });
        function onScroll(event){
            var scrollPos = $(document).scrollTop();
            $('.nav a').each(function () {
                var currLink = $(this);
                var refElement = $(currLink.attr("href"));
                if (refElement.position().top <= scrollPos && refElement.position().top + refElement.height() > scrollPos) {
                    $('.nav ul li a').removeClass("active");
                    currLink.addClass("active");
                }
                else{
                    currLink.removeClass("active");
                }
            });
        }
    }



  return{
    init: function(){
      scrollWindow();
    }
  }
}();

jQuery(document).ready(function(){
  App.init();
});
(function($) {
  "use strict";
    // Clients carousel (uses the Owl Carousel library)
    $('.loop').owlCarousel({
        center: true,
        items:2,
        loop:true,
        nav: true,
        margin:30,
        responsive:{

            992:{
                items:4
            }
        }
    });
    $('#js-preloader').addClass('loaded');
  // // Clients carousel (uses Init AOS)
    function aos_init() {
        AOS.init({
        duration: 1000,
        easing: "ease-in-out",
        once: true,
        mirror: false
        });
    }
    $(window).on('load', function() {
        aos_init();
    });
})(jQuery);
