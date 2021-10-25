@extends('adminlte::page')

@section('title_postfix', '| '.$title_postfix)

{{--App_uploads Plugin para caixa de upload dragDropEvents--}}
@section('plugins.App_uploads', true)
{{--Validations--}}
@section('plugins.App_validate', true)
@section('plugins.App_switch', true)
@section('plugins.Summernote', true)
    @php
        $summernote = [
            "height" => "300",
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
                        <input class="form-control" data-name="Título da notícia" placeholder="Título da notícia" value="{{ old('title', $data->title ?? '') }}" name="title" required="">
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
                        <label for="text">Notícia</label>
                        <x-adminlte-text-editor name="text" id="text" size="sm" placeholder="Escreva aqui..." :config="$summernote">{{ old('text', $data->text ?? '') }}</x-adminlte-text-editor>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <label for="files">Imagens</label>
                        <div class="area-upload">
                            <label for="upload-file" class="label-upload">
                                <i class="fas fa-cloud-upload-alt"></i>
                                <div class="texto">Clique ou arraste o arquivo</div>
                            </label>
                            <input type="file" name="images" class="upload-file" accept="image/jpg,image/png,image/jpeg,image/webp" id="upload-file" multiple/>
                            <div class="row">
                                <div class="col-lg-12 lista-uploads">
                                    @if(isset($images))
                                        @foreach($images as $image)
                                            <div class="barra complete">
                                                <div class="fill" style="min-width: 100%;"></div>
                                                <div class="text">
                                                    <div>
                                                        <span>{{$image->title}}</span>
                                                        @if ($image->featured=='1')
                                                            <a style="cursor:pointer;color: #fff;"  class="btn btn-warning py-0 ml-1 btn-featured stars">Destaque <i class="fas fa-star"></i></a>
                                                            <input type="hidden" name="featured[]" value="1" >
                                                        @else
                                                            <a style="cursor:pointer;color: #fff;" class="btn btn-secondary py-0 ml-1 btn-featured stars">Destaque <i class="fas fa-star"></i></a>
                                                            <input type="hidden" name="featured[]" value="0" >
                                                        @endif
                                                        <a style="cursor:pointer;color: #fff;" data-path="{{url('storage/'.$image->path)}}" data-image="{{$image->title}}" class="btn btn-info py-0 text-white showImage">Visualizar <i class="fas fa-image" ></i></a>
                                                        <a style="cursor:pointer;color: #fff;" class="btn btn-danger py-0 ml-1 btn-delete-image text-white">Remover <i class="fas fa-trash-alt" ></i></a>
                                                    </div>
                                                    <input type="hidden" name="images[]" value="{{$image->title}}">
                                                </div>
                                            </div>
                                        @endforeach
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
