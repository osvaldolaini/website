 <!-- footer -->
 <footer class="custom-footer custom-bg-dark custom-section">
    <div class="container">
        <div class="row mb-5">
            <div class="col-md">
            <div class="custom-footer-widget mb-4">
                <h2 class="custom-heading-2">Osvaldo Laini</h2>
                <p>
                    {{ $config->meta_description }}
                </p>
                <ul class="custom-footer-social list-unstyled float-md-left float-lft mt-5">
                    @if (isset($menu['socialMedias']))
                        @foreach ($menu['socialMedias'] as $socialMedia)
                            <li data-aos="fade-up" data-aos-easing="ease-in-sine">
                                <a href="{{$socialMedia->link}}" target="_blank">
                                    <i class="fab fa-fw {{$socialMedia->icon}}"></i>
                                </a>
                            </li>
                        @endforeach
                    @endif
                </ul>
            </div>
            </div>
            <div class="col-md">
            <div class="custom-footer-widget mb-4 ml-md-5">
                <h2 class="custom-heading-2">Navegação</h2>
                <ul class="list-unstyled">
                    <li ><a href="#top" class="active">Home</a></li>
                    <li ><a href="#about">Sobre</a></li>
                    <li ><a href="#services">Serviços</a></li>
                    <li ><a href="#portfolio">Portfólio</a></li>
                    <li ><a href="#contact">Contatos</a></li>
                    <li><a href="{{url('termo-de-uso')}}">Termo de uso</a></li>
                    <li><a href="{{url('politica-de-privacidade')}}">Política de privacidade</a></li>
                </ul>
            </div>
            </div>
            <div class="col-md">
            <div class="custom-footer-widget mb-4">
                <h2 class="custom-heading-2">Contatos</h2>
                <ul class="list-unstyled">
                    <!--<li>
                        <a href="#">
                            <i class="fas fa-map-marker"></i>
                            {{ $config->addresses->first()->address}},
                            {{$config->addresses->first()->number}},
                            {{$config->addresses->first()->district}},
                            {{$config->addresses->first()->city}} - {{$config->addresses->first()->state}}.
                        </a>
                    </li>-->
                    <li>
                        <a href="#"><i class="fab fa-whatsapp"></i>
                            {{ $config->phone }}
                        </a>
                    </li>
                    <li>
                        <a href="#"><i class="fas fa-mail-bulk"></i>
                            {{ $config->email }}
                        </a>
                    </li>
                </ul>
            </div>
            </div>
            <div class="col-md">
            <div class="custom-footer-widget mb-4">
                <h2 class="custom-heading-2">Newsletter</h2>
                <p>
                    Quer saber mais sobre nosso trabalho?
                    Inscreva-se para receber todas essas informações.
                </p>
                <div class="block-23 mb-3">
                    <div id="custom-newsletter">
                        <div class="newsletter" id="newsletter">
                            <div class="newsletter_form_container">
                                <form method="post" class="form-outline-style" id="newsletterForm" >
                                    <div class="d-flex flex-row align-items-start justify-content-start">
                                        <input type="email" class="newsletter_input" name="email"
                                            placeholder="Insira seu email" required="required">
                                        <button class="newsletter_button">
                                            <i class="far fa-paper-plane"></i>
                                        </button>
                                    </div>
                                </form>
                                <div id="newsletter-message-warning" class="mt-4"></div>
                                <div id="newsletter-message-success">
                                    <p>Assinatura concluída, obrigado!</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
        <div class="ads">
            {{-- Ads Google
            @include('site.partials.adsGoogle')--}}
        </div>

    </div>
  </footer>
