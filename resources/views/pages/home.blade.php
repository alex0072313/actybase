@extends('layouts.layout')

@section('content')

    @if(session('company_innactive'))
        @include('includes.notify.panel_inactive_company', ['company' => session('company_innactive')])
    @endif

    @if(session('company_status_off'))
        @include('includes.notify.panel_status_off_company', ['company' => session('company_status_off')])
    @endif

@endsection