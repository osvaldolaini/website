<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>

    {{-- Favicons --}}
    @include('site.partials.favicons')
    {{-- css --}}
    @include('site.assets.css')

</head>
<body >
    {{-- Head --}}
    @include('site.partials.head')
    <style>
    .ribbon-img{
        width:100%;
        margin:0px;
        padding:0px;
    }
    </style>
    {{-- Body Content --}}
<section class="section ">

</section>
<section class="section contacts my-0 py-0" id="contact" >
    <div class="largeAds row " data-aos="zoom-in">
        <i class="far fa-window-close close" style="cursor:pointer;"></i>
        <div class="col-lg-3 col-sm-12 image" >
            <a href="{{$data->link}}">
                <img src="{{'http://localhost/site/'.$data->path.''.$data->image}}">
            </a>
        </div>
        <div class="col-lg-7 ads d-none d-lg-block">
            <h2>{{$data->title}} </h2>
            {!!$data->description!!}
        </div>
         <div class="col-lg-2 link d-none d-lg-block">
            <a href="{{$data->link}}">
                <i class="fas fa-5x fa-chevron-circle-right text-primary"></i>
                <h4>Saiba mais </h4>
            </a>
        </div>
    </div> 
    <div class="container" >
        <div class="row" >
            <div class="col-sm-12 col-lg-4">
                <div class="smallAds" data-aos="zoom-in" >
                    <i class="far fa-window-close close" style="cursor:pointer;"></i>
                    <a href="{{$data->link}}">
                        <div class="ribbon-wrapper p-3 ribbon-lg" style="background-image:url({{'http://localhost/site/'.$data->path.''.$data->image}})">
                            <div class="ribbon bg-danger p-3 text-white">
                                Promoção
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="container">
        <h1 class="contacts-header">Fale conosco</h1>
        <h3 class="text-muted text-center">Envie um email com seu projeto.</h3>
        <div class="contacts-body">
            <div class="row">
                <div class="col-lg-12">
                  <form id="contactForm" name="sentMessage" novalidate="novalidate">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                              <input class="form-control" id="name" type="text" placeholder="Seu Nome *" required="required" data-validation-required-message="Por favor digite seu Nome.">
                              <p class="help-block text-danger"></p>
                            </div>
                            <div class="form-group">
                              <input class="form-control" id="email" type="email" placeholder="Seu Email *" required="required" data-validation-required-message="Por favor digite seu email address.">
                              <p class="help-block text-danger"></p>
                            </div>
                            <div class="form-group">
                              <input class="form-control" id="phone" type="tel" placeholder="Seu número de contato *" required="required" data-validation-required-message="Por favor digite seu número de telefone.">
                              <p class="help-block text-danger"></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <textarea class="form-control" id="message" placeholder="Sua Mensagem *" required="required" data-validation-required-message="Por favor digite sua message."></textarea>
                                <p class="help-block text-danger"></p>
                            </div>
                        </div>
                            <div class="clearfix"></div>
                        <div class="col-lg-12 text-center">
                            <div id="success"></div>
                            <button id="sendMessageButton" class="btn btn-primary btn-xl text-uppercase" type="submit">Enviar</button>
                        </div>
                    </div>
                  </form>
                </div>
            </div>
        </div>
    </div>
</section> <!-- Header -->
   
    {{-- Footer --}}
    @include('site.partials.footer')

    {{-- Custom Scripts --}}
    @include('site.assets.js')

</body>

</html>
