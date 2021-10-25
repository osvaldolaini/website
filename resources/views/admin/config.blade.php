@extends('adminlte::page')

@section('title_postfix', '| '.$title_postfix)

{{--Summernote inclusão do text area editor--}}
@section('plugins.Summernote', true)

{{--App_uploads Plugin para caixa de upload dragDropEvents--}}
@section('plugins.App_multipleuploads', true)

@section('content_header')
    <h1 class="m-0 text-dark">{{ $title_postfix }}</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <!-- Inicio do formulário-->
                    <form action="" method="post" class="save" data-table="configuracoes" data-id="{{ old('id', $config->id ?? '') }}" accept-charset="utf-8" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col">
                                <label for="title">*Titulo</label>
                                <input class="form-control" placeholder="Nome da empresa/site/sistema" name="title" required="true" maxlength="100" value="{{ old('title', $config->title ?? '') }}">
                            </div>
                            <div class="col">
                                <label for="cnpj">CPF / CNPJ</label>
                                <input class="form-control cnpj" placeholder="CNPJ da empresa/site/sistema" name="cnpj"  maxlength="14" value="{{ old('cnpj', $config->cnpj ?? '') }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <label for="meta_description">Descrição (150 caracteres)</label>
                                <textarea class="form-control" maxlength="150" name="meta_description" rows="5">{{ old('meta_description', $config->meta_description ?? '') }}</textarea>
                            </div>
                            <div class="col-lg-6">
                                <label for="meta_tags">Palavras chave (80 caracteres)</label>
                                <textarea class="form-control" maxlength="80" name="meta_tags" rows="5">{{ old('meta_tags', $config->meta_tags ?? 'As palavras chaves devem ser separadas por ","') }}</textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <label for="email">E-mail</label>
                                <input type="email" class="form-control" placeholder="E-mail" name="email" value="{{ old('email', $config->email ?? '') }}">
                            </div>
                            <div class="col-lg-2">
                                <label for="phone">Telefone fixo</label>
                                <input type="text" class="form-control phones" placeholder="Telefone fixo" name="phone" value="{{ old('phone', $config->phone ?? '') }}">
                            </div>
                            <div class="col-lg-2">
                                <label for="cellphone">Telefone móvel</label>
                                <input type="text" class="form-control phones" placeholder="Telefone móvel" name="cellphone" value="{{ old('cellphone', $config->cellphone ?? '') }}">
                            </div>
                            <div class="col-lg-2">
                                <label for="whatsapp">Whatsapp</label>
                                <input type="text" class="form-control phones" placeholder="Whatsapp" name="whatsapp" value="{{ old('whatsapp', $config->whatsapp ?? '') }}">
                            </div>
                            <div class="col-lg-2">
                                <label for="telegram">Telegram</label>
                                <input type="text" class="form-control phones" placeholder="Telegram" name="telegram" value="{{ old('telegram', $config->telegram ?? '') }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-2">
                                <label for="postalCode">CEP</label>
                                <input class="form-control" maxlength="10" placeholder="CEP" name="postalCode" value="{{ old('postalCode', $address->postalCode ?? '') }}">
                            </div>
                            <div class="col-lg-8">
                                <label for="address">Rua</label>
                                <input class="form-control" placeholder="Rua, Av, Travessa, etc" name="address" value="{{ old('address', $address->address ?? '') }}">
                            </div>
                            <div class="col-lg-2">
                                <label for="number">Número</label>
                                <input class="form-control" placeholder="nº" name="number" value="{{ old('number', $address->number ?? '') }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <label for="about">Bairro</label>
                                <input class="form-control" placeholder="Bairro" name="district" value="{{ old('district', $address->district ?? '') }}">
                            </div>
                            <div class="col-lg-6">
                                <label for="city">Cidade</label>
                                <input class="form-control" placeholder="Cidade" name="city"  value="{{ old('city', $address->city ?? '') }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-10">
                                <label for="complement">Complemento</label>
                                <input class="form-control" placeholder="Complemento" name="complement" value="{{ old('complement', $address->complement ?? '') }}">
                            </div>
                            <div class="col-lg-2">
                                <label for="state">Estado</label>
                                <input class="form-control" placeholder="UF" name="state" maxlength="2" value="{{ old('state', $address->state ?? '') }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label for="about">Sobre</label>
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
                                <x-adminlte-text-editor name="about" id="about" size="sm" placeholder="Escreva aqui..." :config="$summernote">{{ old('about', $config->about ?? '') }}</x-adminlte-text-editor>
                            </div>
                        </div>
                        <div class="row">
                                <div class="col-lg-6">
                                    <label for="nome">Logo (ideal 210x33 pixels) </label>
                                    <div class="area-upload">
                                        <label for="upload-file" class="label-upload">
                                            <i class="fas fa-cloud-upload-alt"></i>
                                            <div class="texto">Clique ou arraste o arquivo</div>
                                        </label>
                                        <input type="file" name="image" class="upload-file" id="image" accept="image/jpg,image/png,image/jpeg,image/webp" />
                                        <div class="row">
                                            <div class="col-lg-12 lista-uploads image">
                                                @if(isset($config->image))
                                                        <div class="image barra complete">
                                                            <div class="fill" style="min-width: 100%;"></div>
                                                            <div class="text">
                                                                <div>
                                                                    <span>{{$config->image}}</span>
                                                                    <a style="cursor:pointer;color: #fff;" data-path="{{url('storage/images/logos/')}}" data-image="{{$config->image}}" class="btn btn-info py-0 text-white showImage">Visualizar <i class="fas fa-image" ></i></a>
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
                                <div class="col-lg-6">
                                    <label for="nome">Favicon (max 48x48 pixels) </label>
                                    <div class="area-upload">
                                        <label for="upload-file" class="label-upload">
                                            <i class="fas fa-cloud-upload-alt"></i>
                                            <div class="texto">Clique ou arraste o arquivo (PNG | ICO)</div>
                                        </label>
                                        <input type="file" name="favicon" class="upload-file" id="favicon" accept="image/png,image/ico" />
                                        <div class="row">
                                            <div class="col-lg-12 lista-uploads favicon">
                                                @if(isset($config->favicon))
                                                        <div class="favicon barra complete">
                                                            <div class="fill" style="min-width: 100%;"></div>
                                                            <div class="text">
                                                                <div>
                                                                    <span>{{$config->favicon}}</span>
                                                                    <a style="cursor:pointer;color: #fff;" data-path="{{url('storage/images/logos/')}}" data-image="{{$config->favicon}}" class="btn btn-info py-0 text-white showImage">Visualizar <i class="fas fa-image" ></i></a>
                                                                    <a style="cursor:pointer;color: #fff;" class="btn btn-danger py-0 ml-1 btn-delete-image text-white">Remover <i class="fas fa-trash-alt" ></i></a>
                                                                </div>
                                                            </div>
                                                            <input type="hidden" name="faviconRemove" value="1"/>
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
                            <x-adminlte-button class="btn-lg mt-3" id="save" type="submit" label="Salvar" theme="primary" icon="fas fa-lg fa-save"/>
                            <x-adminlte-button class="btn-lg mt-3" id="save_out" type="submit" label="Salvar e sair" theme="success" icon="fas fa-lg fa-save"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
