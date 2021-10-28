<div id="contact" class="contact-us section">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 wow fadeInUp" data-wow-duration="0.5s" data-wow-delay="0.25s">
          <form method="post" id="contactForm" >
            <div class="row">
              <div class="col-lg-6 offset-lg-3">
                <div class="section-heading">
                  <h6>Fale conosco</h6>
                  <h2>Conte Sua <span>Ideia</span>, seu projeto, seu <em>Sonho</em>.</h2>
                </div>
              </div>
              <div class="col-lg-9">
                <div class="row">
                  <div class="col-lg-12">
                    <fieldset>
                      <input type="name" name="name" id="name" placeholder="Nome" autocomplete="on" required>
                    </fieldset>
                  </div>
                  <div class="col-lg-6">
                    <fieldset>
                      <input type="text" name="email" id="email" pattern="[^ @]*@[^ @]*" placeholder="Seu Email" required="">
                    </fieldset>
                  </div>
                  <div class="col-lg-6">
                    <fieldset>
                      <input type="subject" name="subject" id="subject" placeholder="Assunto" autocomplete="on">
                    </fieldset>
                  </div>
                  <div class="col-lg-12">
                    <fieldset>
                      <textarea name="message" type="text" class="form-control" id="message" placeholder="Mensagem" required=""></textarea>
                    </fieldset>
                  </div>
                  <div class="col-lg-12">
                    <fieldset>
                      <button type="submit" id="form-submit" class="main-button ">Enviar</button>
                    </fieldset>
                  </div>
                </div>
              </div>
              <div class="col-lg-3">
                <div class="contact-info">
                  <ul>
                    <li>
                        <div class="icon">
                            <i class="fas fa-2x fa-mail-bulk"></i>
                        </div>
                        <a href="#">{{ $config->email }}</a>
                    </li>
                    <li>
                        <div class="icon">
                            <i class="fab fa-2x fa-whatsapp"></i>
                        </div>
                        <a href="#">{{ $config->phone }}</a>
                    </li>
                    <!--<li>
                        <div class="icon">
                            <i class="fas fa-2x fa-map-marker"></i>
                        </div>
                        <a href="#">
                            {{ $config->addresses->first()->address}},
                            {{$config->addresses->first()->number}},
                            {{$config->addresses->first()->district}},
                            {{$config->addresses->first()->city}} - {{$config->addresses->first()->state}}
                        </a>
                    </li>-->
                  </ul>
                </div>
              </div>
            </div>
          </form>
          <div id="form-message-warning" class="mt-4"></div>
            <div id="form-message-success">
                <p>Sua mensagem foi enviada, obrigado!</p>
                <p>Em alguns dias nossa equipe entrará em contato.</p>
            </div>
        </div>
      </div>
    </div>
  </div>
