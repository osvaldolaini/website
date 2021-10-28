<div id="portfolio" class="our-portfolio section">
    <div class="container">
      <div class="row">
        <div class="col-lg-5">
          <div class="section-heading">
            <h6>Portfólio</h6>
            <h2>Nosso recentes <em>Projetos</em> E <span>Parcerias</span></h2>
          </div>
        </div>
      </div>
    </div>
    <div class="container-fluid" data-aos="fade-zoom-in"
            data-aos-offset="0"
            data-aos-delay="300"
            data-aos-duration="750">
        <div class="row">
            <div class="col-lg-12">
                <div class="loop owl-carousel">
                    <div class="item">
                        @foreach ($works_1 as $work)
                            <div class="portfolio-item">
                                <div class="thumb">
                                    <picture class="lazyload img-fluid">
                                        <source data-srcset="{{url('storage/images/portfolios/'.$work->id.'.jpg')}}" />
                                        <source data-srcset="{{url('storage/images/portfolios/'.$work->id.'_thumbnail.webp')}}"/>
                                        <img class="lazyload img-fluid" data-src="{{url('storage/images/portfolios/'.$work->id.'_thumbnail.webp')}}" alt="{{$work->slug}}" />
                                    </picture >
                                    <div class="hover-content">
                                        <div class="inner-content">
                                            <a href="{{$work->link}}"><h4>{{$work->title}}</h4></a>
                                            <span>{{$work->link}}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="item">
                        @foreach ($works_2 as $work)
                            <div class="portfolio-item">
                                <div class="thumb">
                                    <picture class="lazyload img-fluid">
                                        <source data-srcset="{{url('storage/images/portfolios/'.$work->id.'.jpg')}}" />
                                        <source data-srcset="{{url('storage/images/portfolios/'.$work->id.'_thumbnail.webp')}}"/>
                                        <img class="lazyload img-fluid" data-src="{{url('storage/images/portfolios/'.$work->id.'_thumbnail.webp')}}" alt="{{$work->slug}}" />
                                    </picture >
                                    <div class="hover-content">
                                        <div class="inner-content">
                                            <a href="{{$work->link}}"><h4>{{$work->title}}</h4></a>
                                            <span>{{$work->link}}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
