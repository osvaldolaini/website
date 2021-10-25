var App_ads = function () {
  const APP_URL = 'https://osvaldolaini.com.br/'
  const API = 'https://osvaldolaini.com.br/api/ads'
    let controller = function(){
        const pathname = window.location.pathname
        var url = location.href; //pega endereço que esta no navegador
        url = url.split("/");
        return url[2]+pathname
    }
    let device = function(){
        var width = screen.width;
        if(width <= 767){
            return 'Smartphone ou tablet'
        }else{
            return 'Desktop'
        }
    }
    /*Faz a pesquisa e inseri os ADS nas divs */
    function large(id) {
          $.ajax({
              url:API,
              method:'GET',
              success:function(response){
                if(response.success){
                    if(response.data.description){
                        var description = response.data.description
                    }else{
                        var description = ''
                    }
                    $('#'+id).append('<div class="largeAds row" data-aos="zoom-in">'+
                        '<i class="far fa-window-close close" style="cursor:pointer;"></i>'+
                        '<div class="col-lg-3 col-sm-12 image" data-link="'+response.data.link+'">'+
                            '<a style="cursor:pointer;" href="'+response.data.link+'" target="_BLANK" class="data-link" data-ads="'+response.data.table+'" data-id="'+response.data.id+'" data-link="'+response.data.link+'">'+
                                '<img src="'+APP_URL+''+response.data.path+''+response.data.image+'">'+
                            '</a>'+
                        '</div>'+
                        '<div class="col-lg-7 ads d-none d-lg-block">'+
                            '<h2>'+response.data.title+'</h2>'+
                            description+
                        '</div>'+
                        '<div class="col-lg-2 link d-none d-lg-block">'+
                            '<a style="cursor:pointer;" href="'+response.data.link+'" target="_BLANK" class="data-link" class="data-link" data-ads="'+response.data.table+'" data-id="'+response.data.id+'" data-link="'+response.data.link+'">'+
                                '<i class="fas fa-5x fa-chevron-circle-right text-primary"></i>'+
                                '<h4>Saiba mais </h4>'+
                            '</a>'+
                        '</div>'+
                    '</div>')
                    //console.log(response.success)
                }else{
                    console.log(response.error)
                }
              },
          })
    }
    function small(id) {
          $.ajax({
              url:API,
              method:'GET',
              success:function(response){
                    if(response.success){
                        if(response.data.promotion){
                            var promotion = '<div class="ribbon bg-danger p-3 text-white">'+
                                    response.data.promotion+
                                '</div>'
                        }else{
                            var promotion = ''
                        }
                        $('#'+id).append('<div class="smallAds" data-aos="zoom-in" >'+
                            '<i class="far fa-window-close close" style="cursor:pointer;"></i>'+
                            '<a style="cursor:pointer;" class="data-link" href="'+response.data.link+'" target="_BLANK" data-ads="'+response.data.table+'" data-id="'+response.data.id+'" data-link="'+response.data.link+'">'+
                                '<div class="ribbon-wrapper p-3 ribbon-lg" style="background-image:url('+APP_URL+''+response.data.path+''+response.data.image+')">'+
                                    promotion+
                                '</div>'+
                            '</a>'+
                        '</div>')
                        //console.log(response.success)
                    }else{
                        console.log(response.error)
                    }
              },
          })
    }
    /*Pega as divs com class large e envia para ser inserido os ADS */
    let marketing = function(){
      $('.adsLarge').ready(function() {
        var cont = 0
          $(".adsLarge").each(function () {
            cont += Number(1)
            /*inseri ID nas divs para diferenciar */
            $(this).attr('id','adsLarge_'+cont)
            large('adsLarge_'+cont)
          });
      })
      $('.adsSmall').ready(function() {
        var cont = 0
          $(".adsSmall").each(function () {
            cont += Number(1)
            /*inseri ID nas divs para diferenciar */
            $(this).attr('id','adsSmall_'+cont)
            small('adsSmall_'+cont)
          });
      })
    }
    let close = function(){
        $(document).on('click', '.close', function () {
            $(this).parent().remove()
        })
    }
    let ads_click = function(){
      $(document).on('click', '.data-link', function () {
          var link = $(this).data('link')
          var id = $(this).data('id')
          var table = $(this).data('ads')
          var page = controller()
          var ua = window.navigator.userAgent;
          var plataforma = device()
          $.ajax({
              url:API,
              data:{id:id,table:table,page:page,ua:ua,plataforma:plataforma},
              method:'POST',
              success:function(response){
                //console.log(response)
              },
              error:function(response){
                //console.log(response)
              }
          })
      })
    }
    let ads_touch = function(){
      $(document).on('ontouchstart', '.data-link', function () {
          var link = $(this).data('link')
          var id = $(this).data('id')
          var table = $(this).data('ads')
          var page = controller()
          var ua = window.navigator.userAgent;
          var plataforma = device()
          $.ajax({
              url:API,
              data:{id:id,table:table,page:page,ua:ua,plataforma:plataforma},
              method:'POST',
              success:function(response){
                //console.log(response)
              },
              error:function(response){
                //console.log(response)
              }
          })
      })
    }

  return{
    init: function(){
      marketing()
      close()
      ads_click()
      ads_touch()
    }
  }
}();

jQuery(document).ready(function(){
  App_ads.init();
});

(function($) {
    "use strict";
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
