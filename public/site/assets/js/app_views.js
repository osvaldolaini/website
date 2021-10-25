const appurlmeta = document.querySelector("meta[name='app_url']");
const APP_URL = appurlmeta.getAttribute("content");
const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': CSRF_TOKEN
    }
});
var App_views = function () {
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

    /*Save */
    let save = function(){
        var page = controller()
        var ua = window.navigator.userAgent;
        var plataforma = device()
        $.ajax({
            url:APP_URL + '/views',
            method:'POST',
            data:{page:page,ua:ua,plataforma:plataforma},
            success:function(response){
                //console.log(response)
            },
            error:function(response){
                //console.log(response)
            },
        })
    }

    return{
      init: function(){
        save()
      }
    }
  }()

  jQuery(document).ready(function(){
    App_views.init();
  })
