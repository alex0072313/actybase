@extends('layouts.layout')

@section('content')

    @if(session('company_innactive'))
        @include('includes.notify.panel_inactive_company', ['company' => session('company_innactive')])
    @endif

@endsection