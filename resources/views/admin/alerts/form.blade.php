@extends('adminlte::page')

@section('title_postfix', '| '.$title_postfix)

{{--Validations--}}
@section('plugins.App_validate', true)
@section('plugins.App_switch', true)
@section('plugins.Summernote', true)
@php
    $summernote = [
        "height" => "150",
        "toolbar" => [
            // [groupName, [list of button]]
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough', 'superscript', 'subscript']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']],
            ['table', ['table']],
            // ['insert', ['link', 'picture', 'video']],
            ['view', ['fullscreen', 'codeview', 'help']],
        ],
    ];
@endphp

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
                        <label for="title">*Título</label>
                        <input class="form-control" data-name="Título" placeholder="Título" value="{{ old('title', $data->title ?? '') }}" name="title" required="">
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
                    <div class="col-lg-12">
                        <label for="text">Texto do aviso</label>
                        <x-adminlte-text-editor name="description" id="description" size="sm" placeholder="Escreva aqui..." :config="$summernote">{{ old('description', $data->description ?? '') }}</x-adminlte-text-editor>
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
