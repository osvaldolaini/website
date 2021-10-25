@extends('adminlte::page')

@section('title_postfix', '| Dashboard')
{{--Graficos--}}
@section('plugins.App_charts', true)

@section('content_header')
    <h1 class="m-0 text-dark">Dashboard</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <!-- small box -->
                            <div class="col-lg-3 col-6">
                            <!-- small box -->
                                <div class="small-box bg-primary">
                                    <div class="inner">
                                        <h4 class="d-lg-none">{{$ambiences}}</h4>
                                        <h3 class="d-none d-lg-block">{{$ambiences}}</h3>
                                        <p>Ambientes</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-home"></i>
                                    </div>
                                    <a href="{{route('ambience.index')}}" class="small-box-footer">Listar <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                        <!-- ./col -->
                        <!-- small box -->
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                                <div class="small-box bg-primary">
                                    <div class="inner">
                                        <h4 class="d-lg-none">{{$partners}}</h4>
                                        <h3 class="d-none d-lg-block">{{$partners}}</h3>
                                        <p>Parceiros</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-address-book"></i>
                                    </div>
                                    <a href="{{route('partner.index')}}" class="small-box-footer">Listar <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                        <!-- ./col -->
                        <!-- small box -->
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                                <div class="small-box bg-primary">
                                    <div class="inner">
                                        <h4 class="d-lg-none">{{$covenants}}</h4>
                                        <h3 class="d-none d-lg-block">{{$covenants}}</h3>
                                        <p>Convênios</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-address-book"></i>
                                    </div>
                                    <a href="{{route('covenant.index')}}" class="small-box-footer">Listar <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                        <!-- ./col -->
                        <!-- small box -->
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                                <div class="small-box bg-primary">
                                    <div class="inner">
                                        <h4 class="d-lg-none">{{$articles}}</h4>
                                        <h3 class="d-none d-lg-block">{{$articles}}</h3>
                                        <p>Notícias</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-newspaper"></i>
                                    </div>
                                    <a href="{{route('article.index')}}" class="small-box-footer">Listar <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                        <!-- ./col -->
                        <!-- small box -->
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                                <div class="small-box bg-primary">
                                    <div class="inner">
                                        <h4 class="d-lg-none">{{$alerts}}</h4>
                                        <h3 class="d-none d-lg-block">{{$alerts}}</h3>
                                        <p>Avisos</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-exclamation-triangle"></i>
                                    </div>
                                    <a href="{{route('alert.index')}}" class="small-box-footer">Listar <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                        <!-- ./col -->
                        <!-- small box -->
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                                <div class="small-box bg-primary">
                                    <div class="inner">
                                        <h4 class="d-lg-none">{{$events}}</h4>
                                        <h3 class="d-none d-lg-block">{{$events}}</h3>
                                        <p>Eventos</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-glass-cheers"></i>
                                    </div>
                                    <a href="{{route('event.index')}}" class="small-box-footer">Listar <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                        <!-- ./col -->
                        <!-- small box -->
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                                <div class="small-box bg-primary">
                                    <div class="inner">
                                        <h4 class="d-lg-none">{{$socialMedias}}</h4>
                                        <h3 class="d-none d-lg-block">{{$socialMedias}}</h3>
                                        <p>Mídias sociais</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-hashtag"></i>
                                    </div>
                                    <a href="{{route('socialMedia.index')}}" class="small-box-footer">Listar <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                        <!-- ./col -->
                        <!-- small box -->
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                                <div class="small-box bg-primary">
                                    <div class="inner">
                                        <h4 class="d-lg-none">{{$sports}}</h4>
                                        <h3 class="d-none d-lg-block">{{$sports}}</h3>
                                        <p>Esportes</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-volleyball-ball"></i>
                                    </div>
                                    <a href="{{route('sport.index')}}" class="small-box-footer">Listar <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                        <!-- ./col -->
                        <!-- small box -->
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                                <div class="small-box bg-primary">
                                    <div class="inner">
                                        <h4 class="d-lg-none">{{$emails}}</h4>
                                        <h3 class="d-none d-lg-block">{{$emails}}</h3>
                                        <p>Emails @if ($newEmail > 0)
                                            <span class="badge badge-danger">
                                                @php
                                                    echo $newEmail. ' Não respondido';
                                                @endphp
                                            </span>
                                        @endif</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-mail-bulk"></i>
                                    </div>
                                    <a href="{{route('email.index')}}" class="small-box-footer">Listar <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                        <!-- ./col -->
                        <!-- small box -->
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                                <div class="small-box bg-primary">
                                    <div class="inner">
                                        <h4 class="d-lg-none">{{$subscribers}}</h4>
                                        <h3 class="d-none d-lg-block">{{$subscribers}}</h3>
                                        <p>Assinantes</p>
                                    </div>
                                    <div class="icon">
                                        <i class="far fa-newspaper"></i>
                                    </div>
                                    <a href="{{route('subscriber.index')}}" class="small-box-footer">Listar <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                        <!-- ./col -->
                        <!-- small box -->
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                                <div class="small-box bg-primary">
                                    <div class="inner">
                                        <h4 class="d-lg-none">{{$informations}}</h4>
                                        <h3 class="d-none d-lg-block">{{$informations}}</h3>
                                        <p>Informações</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-info-circle"></i>
                                    </div>
                                    <a href="{{route('information.index')}}" class="small-box-footer">Listar <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                        <!-- ./col -->
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-header bg-primary">
                                    <h3 class="card-title">
                                        <i class="fas fa-chart-bar mr-1"></i>
                                        Visualizações por mês
                                    </h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                          <i class="fas fa-minus"></i>
                                        </button>
                                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                                          <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div><!-- /.card-header -->
                                <div class="card-body">
                                    <div id="first" ></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-header bg-primary">
                                    <h3 class="card-title">
                                        <i class="fas fa-chart-bar mr-1"></i>
                                        Visualizações por Aparelho
                                    </h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                          <i class="fas fa-minus"></i>
                                        </button>
                                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                                          <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div><!-- /.card-header -->
                                <div class="card-body">
                                    <div id="second" ></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-header bg-primary">
                                    <h3 class="card-title">
                                        <i class="fas fa-chart-pie mr-1"></i>
                                        Acesso por categorias
                                    </h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                          <i class="fas fa-minus"></i>
                                        </button>
                                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                                          <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div><!-- /.card-header -->
                                <div class="card-body">
                                    <div id="third"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-header bg-primary">
                                    <h3 class="card-title">
                                        <i class="fas fa-star mr-1"></i>
                                        Top 5
                                    </h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                          <i class="fas fa-minus"></i>
                                        </button>
                                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                                          <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div><!-- /.card-header -->
                                <div class="card-body">
                                    <div class="card">
                                        <!-- /.card-header -->
                                          <ul class="products-list product-list-in-card pl-2 pr-2">
                                            @if ($pages)
                                                @foreach ($pages as $page)
                                                    <li class="item">
                                                        <div class="product-img pr-2">
                                                            <h2>
                                                                {{$page['pos']}}
                                                                <i class="fas fa-crown text-warning"></i>
                                                            </h2>
                                                        </div>
                                                        <div class="product-info">
                                                            <span class="badge badge-success ">{{$page['qtd']}} acessos <i class="fa fa-lg fa-fw fa-eye"></i></span>
                                                            <a href="{{url($page['link'])}}" class="product-title">{{$page['category']}}</a>

                                                            <span class="product-description">
                                                                {{$page['page']}}
                                                            </span>
                                                        </div>
                                                    </li>
                                                @endforeach

                                            @endif

                                            <!-- /.item -->
                                          </ul>
                                      </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
