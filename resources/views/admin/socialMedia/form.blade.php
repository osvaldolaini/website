@extends('adminlte::page')

@section('title_postfix', '| '.$title_postfix)

{{--Validations--}}
@section('plugins.App_validate', true)
@section('plugins.App_switch', true)

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
                        <label for="title">*Mídia Social</label>
                        <input class="form-control" data-name="Nome da Mídia Social" placeholder="Nome da Mídia Social" value="{{ old('title', $data->title ?? '') }}" name="title" required="">
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
                    <div class="col-lg-8">
                        <label for="link">*Link da mídia social</label>
                        <input class="form-control" data-name="Link da mídia social " placeholder="Copiar o link no navegador da rede social" name="link" value="{{ old('link', $data->link ?? '') }}" required>
                    </div>
                    <div class="col-lg-4">
                        <label for="icon">*Icone</label>
                        <select name="icon" data-name="ícone " class="form-control" required>
                                <option value="">Selecione...</option>
                            @if(isset($data))
                                <option value="fa-facebook" {{($data->icon == "fa-facebook" ? 'selected=""' : '')}}>
                                    Facebook
                                </option>
                                <option value="fa-twitter" {{($data->icon == "fa-twitter" ? 'selected=""' : '')}}>
                                    Twitter
                                </option>
                                <option value="fa-instagram" {{($data->icon == "fa-instagram" ? 'selected=""' : '')}}>
                                    Instagram
                                </option>
                                <option value="fa-youtube" {{($data->icon == "fa-youtube" ? 'selected=""' : '')}}>
                                    Youtube
                                </option>
                            @else
                                <option value="fa-facebook">Facebook</option>
                                <option value="fa-twitter">Twitter</option>
                                <option value="fa-instagram">Instagram</option>
                                <option value="fa-youtube">Youtube</option>
                            @endif
                        </select>
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
