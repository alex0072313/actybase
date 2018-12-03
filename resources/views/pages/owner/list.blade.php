@extends('layouts.layout')

@section('content')

    <a href="{{ isset($category) ? route('owners.create_in_cat', 'category_'.$category->id) : route('owners.create') }}" class="btn btn-green btn-lg mb-4">Добавить обьект</a>

    @if($owners)
        <!-- begin panel -->
        <div class="panel panel-inverse">
            <div class="panel-heading">
                <div class="panel-heading-btn">
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                </div>
                <h4 class="panel-title">Обьекты</h4>
            </div>

            <!-- begin panel-body -->
            <div class="panel-body">
                @foreach($owners as $owner)
                    <div class="box">
                        <a href="{{ route('owners.edit', 'owner_'.$owner->id) }}">{{ $owner->name }}</a>
                    </div>
                @endforeach
            </div>
            <!-- end panel-body -->
        </div>
    @else
        <p class="lead">
            Нет добавленных обьектов
        </p>
    @endif


@endsection