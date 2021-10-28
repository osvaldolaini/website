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
    var contactForm = function() {
        $('.form-control').on('input', function() {
        var $field = $(this).closest('.form-group');
          if (this.value) {
              $field.addClass('field-not-empty');
          } else {
              $field.removeClass('field-not-empty');
          }
        });

        if ($('#contactForm').length > 0 ) {
            $( "#contactForm" ).validate( {
                rules: {
                    name: "required",
                    email: {
                        required: true,
                        email: true
                    },
                    message: {
                        required: true,
                        minlength: 5
                    }
                },
                messages: {
                    name: "Por favor, insira seu nome",
                    email: "Por favor, insira um email válido",
                    message: "Por favor, insira sua mensagem"
                },
                errorElement: 'span',
                errorLabelContainer: '.form-error',
                /* submit via ajax */
                submitHandler: function(form) {
                    var $submit = $('.submitting'),
                        waitText = 'Enviando...';

                    $.ajax({
                      type: "POST",
                      url: APP_URL + "/enviar-email",
                      data: $(form).serialize(),

                      beforeSend: function() {
                          $submit.css('display', 'block').text(waitText);
                      },
                      success: function(msg) {
                        console.log(msg)
                       if (msg.success==true) {

                           $('#form-message-warning').hide();
                            setTimeout(function(){
                               $('#contactForm').fadeOut();
                           }, 1000);
                            setTimeout(function(){
                               $('#form-message-success').fadeIn();
                           }, 1400);

                        } else {
                           $('#form-message-warning').html(message);
                            $('#form-message-warning').fadeIn();
                            $submit.css('display', 'none');
                        }
                      },
                      error: function(msg) {
                          $('#form-message-warning').html("Ocorreu um erro, por favor tente novamente.");
                         $('#form-message-warning').fadeIn();
                         $submit.css('display', 'none');
                      }
                  });
                  }

            } );
        }
    }
    var newsletterForm = function() {
        if ($('#newsletterForm').length > 0 ) {
            $( "#newsletterForm" ).validate( {
                rules: {
                    email: {
                        required: true,
                        email: true
                    },
                },
                messages: {
                    email: "Por favor, insira um email válido"
                },
                errorElement: 'span',
                errorLabelContainer: '.form-error',
                /* submit via ajax */
                submitHandler: function(form) {
                    var $submit = $('.submitting'),
                        waitText = 'Enviando...';

                    $.ajax({
                      type: "POST",
                      url: APP_URL + "/newsletter",
                      data: $(form).serialize(),

                      beforeSend: function() {
                          $submit.css('display', 'block').text(waitText);
                      },
                      success: function(msg) {

                       if (msg.success==true) {
                           $('#newsletter-message-warning').hide();
                            setTimeout(function(){
                               $('#newsletterForm').fadeOut();
                           }, 1000);
                            setTimeout(function(){
                               $('#newsletter-message-success').fadeIn();
                           }, 1400);

                        } else {
                           $('#newsletter-message-warning').html(message);
                            $('#newsletter-message-warning').fadeIn();
                            $submit.css('display', 'none');
                        }
                      },
                      error: function(msg) {
                        //console.log(msg)
                          $('#newsletter-message-warning').html("Email já está cadastrado.");
                         $('#newsletter-message-warning').fadeIn();
                         $submit.css('display', 'none');
                      }
                  });
                  }
            } );
        }
    }


  return{
    init: function(){
        scrollWindow()
        contactForm()
        newsletterForm()
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
