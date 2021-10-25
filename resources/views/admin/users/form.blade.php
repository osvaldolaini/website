@extends('adminlte::page')

@section('title_postfix', '| '.$title_postfix)

{{--App_uploads Plugin para caixa de upload dragDropEvents--}}
@section('plugins.App_multipleuploads', true)
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
                    @if(isset($user))
                        <form action="" method="post" class="save" data-table="usuarios" data-id="{{ old('id', $user->id ?? '') }}" accept-charset="utf-8" >
                        @method('put')
                    @else
                        <form action="" method="post" class="save" data-table="usuarios" accept-charset="utf-8" >
                    @endif
                <div class="row">
                    <div class="col-lg-7 col-md-7 col-sm-7">
                        <label for="username">*Nome completo</label>
                        <input class="form-control" placeholder="Nome completo" value="{{ old('name', $user->name ?? '') }}" name="name" required="">
                    </div>
                    <div class="col-sm-3 col-md-3 col-lg-4">
                        <label for="group_id">*Nível de acesso</label>
                        <select name="group_id" class="form-control">
                            @foreach ($groups as $group)
                                @if(isset($user))
                                    <option value="{{$group->id}}" {{($group->id == $user->group_id ? 'selected=""' : '')}}>
                                        {{$group->title}}
                                    </option>
                                @else
                                    <option value="{{$group->id}}">
                                        {{$group->title}}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-2 col-md-2 col-lg-1">
                        <label for="active">Ativo</label>
                        <div class="row">
                            <div class="col">
                                @if (isset($user))
                                    <label class="switch">
                                        <input type="checkbox" id="slider" {{($user->active==1 ? 'checked' : "" )}}>
                                        <span class="slider round"><i class="fas {{($user->active==1 ? 'fa-thumbs-up' : "fa-thumbs-down" )}}"></i></span>
                                    </label>
                                @else
                                    <label class="switch">
                                        <input type="checkbox" id="slider" >
                                        <span class="slider round"><i class="fas fa-thumbs-down"></i></span>
                                    </label>
                                @endif
                                <input type="hidden" name="active" id="active" value="{{ old('active', $user->active ?? '') }}" >
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-6">
                        <label for="email">*Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email ?? '') }}" placeholder="Email de acesso" class="form-control" required="">
                    </div>
                    <div class="col-lg-6">
                        <label for="Senha">*Senha </label>
                        <input type="password" id="password" name="password" placeholder="Informe sua Senha" class="form-control">
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <label for="nome">Foto (ideal 300 x 300 pixels) </label>
                        <div class="area-upload">
                            <label for="upload-file" class="label-upload">
                                <i class="fas fa-cloud-upload-alt"></i>
                                <div class="texto">Clique ou arraste o arquivo</div>
                            </label>
                            <input type="file" name="image" class="upload-file" id="image" accept="image/jpg,image/png,image/jpeg,image/webp" />
                            <div class="row">
                                <div class="col-lg-12 lista-uploads image">
                                    @if(isset($user->image))
                                            <div class="image barra complete">
                                                <div class="fill" style="min-width: 100%;"></div>
                                                <div class="text">
                                                    <div>
                                                        <span>{{$user->image}}</span>
                                                        <a style="cursor:pointer;color: #fff;" data-path="{{url('storage/images/users/')}}" data-image="{{$user->image}}" class="btn btn-info py-0 text-white showImage">Visualizar <i class="fas fa-image" ></i></a>
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
                </form>
                <div class="row">
                    <div class="col text-right">
                        <hr />
                        @if(isset($user))
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
