@extends('adminlte::page')

@section('title_postfix', '| '.$title_postfix)

{{--Summernote inclusão do text area editor--}}
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugins', true)

@section('content_header')
    <h1 class="m-0 text-dark">{{ $title_postfix }}</h1>
@stop

{{-- Setup data for datatables --}}
@php
$heads = [
    'Nome',
    'Email',
    'Nível',
    ['label' => 'Opções', 'no-export' => true, 'width' => 5],
];

$config = [
    'language'=>[['url' => 'https://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Portuguese-Brasil.json']],
    'data' => $data,
    'order' => [[1, 'asc']],
    'columns' => [null, null, null, ['orderable' => false]],
];
@endphp

@section('content')
<!-- navegação -->
<ol class="breadcrumb bg-light">
    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}"><i class="fa fa-dashboard"></i>Home </a></li>
    <li class="breadcrumb-item active">{{ $title_postfix }}</li>
    <li class="ml-auto"><a href="{{ route('user.create') }}" class="btn btn-sm btn-success mx-1 shadow">{{ $new }}  <i class="fas fa-plus "></i></a></li>
</ol>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <!-- Inicio do conteúdo-->
                <x-adminlte-datatable id="table8" :heads="$heads" head-theme="dark" theme="info"  :config="$config"
                    striped hoverable with-buttons/>
            </div>
        </div>
    </div>
</div>

<x-adminlte-modal id="modalView" title="Account Policy" size="lg" theme="primary"
    icon="fas fa-bell" v-centered static-backdrop scrollable>
    <div class="row" id="body" style="min-height:50%;"></div>
    <x-slot name="footerSlot">
        <x-adminlte-button theme="danger" label="Sair" data-dismiss="modal"/>
    </x-slot>
</x-adminlte-modal>

@stop


