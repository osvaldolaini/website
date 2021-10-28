<div id="about" class="about-us section">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="left-image" data-aos="fade-right"
                    data-aos-offset="0"
                    data-aos-delay="300"
                    data-aos-duration="750">
                    <picture class="lazyload img-fluid">
                        <source data-srcset="{{url('storage/images/site/about-img.png')}}" />
                        <source data-srcset="{{url('storage/images/site/about-img.webp')}}"/>
                        <img class="lazyload img-fluid" data-src="{{url('storage/images/site/about-img.webp')}}" alt="osvaldo-laini-icon-01" />
                    </picture >
                </div>
            </div>
            <div class="col-lg-6 align-self-center" data-aos="fade-left"
                data-aos-offset="0"
                data-aos-delay="300"
                data-aos-duration="750">
                <div class="section-heading">
                    <h6>Sobre</h6>
                    <h2>Sempre buscando o <em>melhor</em> para <span>você</span></h2>
                </div>
                <p>
                    {!!$config->about!!}
                </p>
            </div>
        </div>
    </div>
</div>
