@extends('layouts.layout')

@section('content')

    <a href="{{ route('categories.create') }}" class="btn btn-green btn-lg mb-4">Добавить категорию</a>

    @if($categories)
        <!-- begin panel -->
        <div class="panel panel-inverse">
            <div class="panel-heading">
                <div class="panel-heading-btn">
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                </div>
                <h4 class="panel-title">Категории обьектов</h4>
            </div>

            <!-- begin panel-body -->
            <div class="panel-body">
                <!-- begin table-responsive -->
                <div class="table-responsive">
                    <table class="table table-striped m-b-0">
                        <thead>
                        <tr>
                            <th>Название</th>
                            @role('megaroot')
                                <th>Владелец</th>
                            @endrole
                            <th width="1%"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($categories as $category)
                            <tr>
                                <td>{{ $category->name }}</td>
                                @role('megaroot')
                                    <td><a class="text-green" href="{{ route('user.edit', $category->user->id) }}">{{ $category->user->name }}</a></td>
                                @endrole

                                <td class="with-btn" nowrap>
                                    @if(Auth::user()->can('access', $category))
                                        <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-sm btn-green m-r-2">Изменить</a>
                                        <a href="{{ route('categories.destroy', $category->id) }}" data-click="swal-warning" data-title="Подтвердите действие" data-text="Удалить категорию {{ $category->name }}{{ $category->childs()->count() ? ' и ее потомков':'' }}?" data-classbtn="danger" data-actionbtn="Удалить" data-type="error" class="btn btn-sm btn-danger">Удалить</a>
                                    @else
                                        <span class="label label-secondary">Нет доступа к изменению</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- end table-responsive -->
            </div>
            <!-- end panel-body -->
        </div>
    @else
        <p class="lead">
            Нет добавленных категорий
        </p>
    @endif


@endsection