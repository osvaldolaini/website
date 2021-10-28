    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="{{ asset('site/template/vendor/jquery/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('site/template/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Template -->
    <script src="{{asset('site/template/vendor/owl.carousel/owl.carousel.min.js')}}"></script>
    <script src="{{asset('site/template/vendor/isotope/isotope.pkgd.min.js') }}"></script>
    <script src="{{asset('site/template/vendor/jquery.plugins/jquery.easing.1.3.js') }}"></script>
    <script src="{{asset('site/template/vendor/animation/animation.js') }}"></script>
    <script src="{{asset('site/template/vendor/imagesloaded/imagesloaded.js') }}"></script>

    <!-- Custom -->
    <script src="{{asset('site/template/vendor/lazyload/lazysizes.min.js') }}"></script>
    <script src="{{asset('site/template/vendor/aos/aos.js')}}"></script>
    <script src="{{asset('site/template/vendor/jarallax/jarallax.min.js') }}"></script>


    <script src="{{asset('js/share.js') }}"></script>

    <script src="{{asset('site/js/contact_me.js')}}"></script>

    <script src="{{asset('site/js/app_views.min.js')}}"></script>

    <!-- ADS -->
    <script src="{{asset('site/assets/js/app_site.min.js')}}"></script>

    <script src="{{ asset('js/share.js') }}"></script>
    <script>
            const appurlAPI = document.querySelector("meta[name='app_url']");
            const API_URL = appurlAPI.getAttribute("content");

        setTimeout(function(){

            $('.article').ready(function() {
                $.ajax({
                    url:API_URL + '/api/apiArticles',
                    method:'get',
                    success:function(response){
                        if(response.success){

                            console.log(response.data)
                            var id = 0
                            response.data.forEach(article => {
                                id += 1
                                switch (id) {
                                    case 1:
                                        var col = 'col-lg-8';
                                        break;
                                    case 4:
                                        var col = 'col-lg-8';
                                        break;
                                    default:
                                        var col = 'col-lg-4';
                                        break;
                                }

                                $(".article").append(
                                    '<div class="col-sm-6 col-md-6 '+col+' blog-post-entry " data-aos="fade-up" data-aos-delay="0">'+
                                        '<a href="'+article.slug+'" class="grid-item blog-item w-100 h-100">'+
                                            '<div class="overlay">'+
                                                '<div class="blog-item-content">'+
                                                    '<h3>'+article.title+'</h3>'+
                                                    '<p class="post-meta">Postado em <span class="small"></span> '+ article.created_at +
                                                        '<span class="small"> &bullet; </span> <i class="fas fa-eye"></i> ' + article.clicks +
                                                    '</p>'+
                                                '</div>'+
                                            '</div>'+
                                            '<picture class="lazyload img-fluid">'+
                                                '<source data-srcset="'+article.jpg+'" />'+
                                                '<source data-srcset="'+article.webp+'"/>'+
                                                '<img data-src="'+article.webp+'" class="lazyload img-fluid" alt="'+article.alt+'" />'+
                                            '</picture >'+

                                        '</a>'+
                                    '</div>'
                                )
                            });
                                $(".article").append(
                                    '<div class="col-lg-12 text-center pt-3">'+
                                            '<p class="gsap-reveal"><a href="'+response.more+'" class="btn btn-outline-pill btn-custom-light">Veja mais...</a></p>' +
                                    '</div>'
                                )
                        }
                    },
                    error:function(response){
                        console.log(response)
                    }
                })
            })

            $('#apiPartners').ready(function() {
                $.ajax({
                    url:API_URL + '/api/apiPartners',
                    method:'get',
                    success:function(response){
                        if(response.success){
                            console.log(response.data)
                            $(".apiPartners").append(
                                    '<div class="partners-carousel"></div>'
                                )
                            response.data.forEach(partner => {
                                $(".partners-carousel").append(
                                        '<a href="'+partner.link+'" target="_BLANK">'+
                                            '<picture class="lazyload">'+
                                                '<source data-srcset="'+partner.jpg+'" />'+
                                                '<source data-srcset="'+partner.webp+'"/>'+
                                                '<img data-src="'+partner.webp+'" class="lazyload" alt="'+partner.slug+'" />'+
                                            '</picture >'+
                                        '</a>'
                                )
                            })
                            $('.partners-carousel').addClass(' owl-carousel')
                            $(".partners-carousel").owlCarousel({
                                autoplay: true,
                                //dots: true,
                                loop: true,
                                responsive: {
                                    0: {
                                        items: 2
                                    },
                                    768: {
                                        items: 4
                                    },
                                    900: {
                                        items: 6
                                    }
                                }
                            });
                        }
                    },
                    error:function(response){
                        console.log(response)
                    }
                })
            })

        }, 2000);
    </script>
{{--Laini Ads--}}
<script defer src="{{asset('site/ads/js/app_ads.min.js')}}"></script>

{{-- Google Ads
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-9377063296356941"
crossorigin="anonymous"></script>--}}



