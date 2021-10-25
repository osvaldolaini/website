@extends('site.app')
@section('body')
    {{-- Banner --}}
    @include('site.sections.banner')

    {{-- About --}}
    @include('site.sections.about')

    {{-- Services --}}
    @include('site.sections.services')

    {{-- Portfolio --}}
    @include('site.sections.portfolio')

    {{-- Contacts --}}
    @include('site.sections.contact')
@stop
