@extends('adminlte::page')

@section('title_postfix', '| '.$title_postfix)

{{--Validations--}}
@section('plugins.App_validate', true)
@section('plugins.App_switch', true)
{{--Summernote inclusão do text area editor--}}
@section('plugins.Summernote', true)

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

                    @else
                        <form action="" method="post" class="save" accept-charset="utf-8" >
                    @endif
                <div class="row">
                    <div class="col-lg-12">
                        <label for="customer">*Cliente</label>
                        <input class="form-control" data-name="Nome do cliente" readonly placeholder="Nome do cliente" value="{{ old('customer', $data->customer ?? '') }}" name="customer" required="">
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <label for="from">Email do cliente</label>
                        <input class="form-control" data-name="Email do cliente " readonly placeholder="Email" name="from" value="{{ old('from', $data->from ?? '') }}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <label for="subject">Assunto</label>
                        <input class="form-control" data-name="Assunto "  placeholder="Assunto" name="subject" value="{{ old('subject', $data->subject ?? '') }}">
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <label for="message">Mensagem</label>
                        <div class="form-control" readonly>{!! $data->message !!}</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <label for="answer">*Resposta</label>
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
                        ]
                        @endphp
                        <x-adminlte-text-editor name="answer" id="answer" size="sm" placeholder="Escreva aqui..." :config="$summernote" required>{{ old('answer', $data->answer ?? '') }}</x-adminlte-text-editor>
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
                        <x-adminlte-button class="btn-lg mt-3" id="send" type="submit" label="Enviar" theme="secondary" icon="fas fa-lg fa-envelope-open-text"/>
                        <x-adminlte-button class="btn-lg mt-3" id="save" type="submit" label="Salvar" theme="primary" icon="fas fa-lg fa-save"/>
                        <x-adminlte-button class="btn-lg mt-3" id="save_out" type="submit" label="Salvar e sair" theme="success" icon="fas fa-lg fa-save"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
