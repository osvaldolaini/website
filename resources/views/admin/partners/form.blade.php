@extends('adminlte::page')

@section('title_postfix', '| '.$title_postfix)

{{--App_uploads Plugin para caixa de upload dragDropEvents--}}
@section('plugins.App_multipleuploads', true)
{{--Validations--}}
@section('plugins.App_validate', true)
@section('plugins.App_switch', true)
@section('plugins.tempusdominusbootstrap4', true)

@section('content_header')
    <h1 class="m-0 text-dark">{{ $title_postfix }}</h1>
@stop

@section('content')
<!-- Navegação -->
<ol class="breadcrumb bg-light">
    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}"><i class="fa fa-dashboard"></i>Home </a></li>
    <li class="breadcrumb-item"><a href="{{ route($navigation['link']) }}">{{ $navigation['title'] }}</a></li>
    <li class="breadcrumb-item active">{{ $title_postfix }}</li>
</ol>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <!-- Inicio do conteúdo-->
                    @if(isset($data))
                        <form action="" method="post" class="save" data-id="{{ old('id', $data->id ?? '') }}" accept-charset="utf-8" >
                        @method('put')
                    @else
                        <form action="" method="post" class="save" accept-charset="utf-8" >
                    @endif
                <div class="row">
                    <div class="col-lg-11 col-md-10 col-sm-10">
                        <label for="title">*Cliente</label>
                        <input class="form-control" data-name="Nome do cliente" placeholder="Nome do cliente" value="{{ old('title', $data->title ?? '') }}" name="title" required="">
                    </div>
                    <div class="col-sm-2 col-md-2 col-lg-1">
                        <label for="active">Ativo</label>
                        <div class="row">
                            <div class="col">
                                @if (isset($data))
                                    <label class="switch">
                                        <input type="checkbox" id="slider" {{($data->active==1 ? 'checked' : "" )}}>
                                        <span class="slider round"><i class="fas {{($data->active==1 ? 'fa-thumbs-up' : "fa-thumbs-down" )}}"></i></span>
                                    </label>
                                @else
                                    <label class="switch">
                                        <input type="checkbox" id="slider" checked='checked'>
                                        <span class="slider round"><i class="fas fa-thumbs-up"></i></span>
                                    </label>
                                @endif
                                <input type="hidden" name="active" id="active" value="{{ old('active', $data->active ?? '1') }}" >
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-2">
                        <label for="phone">Contato principal</label>
                        <input class="form-control phones" data-name="Contato principal"  placeholder="Contato principal" value="{{ old('phone', $data->phone  ?? '') }}" name="phone" >
                    </div>
                    <div class="col-lg-2">
                        <label for="whatsapp">Whatsapp</label>
                        <input class="form-control phones" placeholder="Whatsapp" value="{{ old('whatsapp', $data->whatsapp  ?? '') }}" name="whatsapp" >
                    </div>
                    <div class="col-lg-2">
                        <label for="telegram">Telegram</label>
                        <input class="form-control phones" placeholder="Whatsapp" value="{{ old('telegram', $data->telegram  ?? '') }}" name="telegram" >
                    </div>
                    <div class="col-lg-6">
                        <label for="email">Email</label>
                        <input class="form-control" type="email" placeholder="Email" value="{{ old('email', $data->email ?? '') }}" name="email">
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <label for="link">Link</label>
                        <input class="form-control" placeholder="Link da página do parceiro" name="link" value="{{ old('link', $data->link ?? '') }}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3">
                        <label for="facebook">Facebook</label>
                        <input class="form-control" placeholder="Facebook" value="{{ old('facebook', $data->facebook  ?? '') }}" name="facebook" >
                    </div>
                    <div class="col-lg-3">
                        <label for="instagram">Instagram</label>
                        <input class="form-control" placeholder="instagram" value="{{ old('instagram', $data->instagram  ?? '') }}" name="instagram" >
                    </div>
                    <div class="col-lg-3">
                        <label for="twitter">Twitter</label>
                        <input class="form-control" placeholder="twitter" value="{{ old('twitter', $data->twitter  ?? '') }}" name="twitter" >
                    </div>
                    <div class="col-lg-3">
                        <label for="youtube">Youtube</label>
                        <input class="form-control" placeholder="youtube" value="{{ old('youtube', $data->youtube ?? '') }}" name="youtube">
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <label for="nome">Imagem (ideal 400 x 200 pixels) </label>
                        <div class="area-upload">
                            <label for="upload-file" class="label-upload">
                                <i class="fas fa-cloud-upload-alt"></i>
                                <div class="texto">Clique ou arraste o arquivo</div>
                            </label>
                            <input type="file" name="image" class="upload-file" id="image" accept="image/jpg,image/png,image/jpeg,image/webp" />
                            <div class="row">
                                <div class="col-lg-12 lista-uploads image">
                                    @if(isset($data->image))
                                            <div class="image barra complete">
                                                <div class="fill" style="min-width: 100%;"></div>
                                                <div class="text">
                                                    <div>
                                                        <span>{{$data->image}}</span>
                                                        <a style="cursor:pointer;color: #fff;" data-path="{{url('storage/images/portfolios/')}}" data-image="{{$data->image}}" class="btn btn-info py-0 text-white showImage">Visualizar <i class="fas fa-image" ></i></a>
                                                        <a style="cursor:pointer;color: #fff;" class="btn btn-danger py-0 ml-1 btn-delete-image text-white">Remover <i class="fas fa-trash-alt" ></i></a>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="imageRemove" value="1"/>
                                            </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @if(isset($data))
                    <div class="row">
                        <div class="col">
                            <label for="updated_because">*Motivo da alteração</label>
                            <input class="form-control" data-name="Motivo da alteração" placeholder="Motivo da alteração" value="{{ old('updated_because', $data->updated_because ?? '') }}" name="updated_because" required>
                        </div>
                    </div>
                @endif
                </form>
                <div class="row">
                    <div class="col text-right">
                        <hr />
                        @if(isset($data))
                            <x-adminlte-button class="btn-lg mt-3" id="save" type="submit" label="Salvar" theme="primary" icon="fas fa-lg fa-save"/>
                        @endif
                        <x-adminlte-button class="btn-lg mt-3" id="save_out" type="submit" label="Salvar e sair" theme="success" icon="fas fa-lg fa-save"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
