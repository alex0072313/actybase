@extends('layouts.layout')

@section('content')

    <a href="" class="btn btn-green btn-lg mb-4">Добавить категорию</a>

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
                                {{--<td class="with-btn" nowrap>--}}
                                    {{--<a href="{{ route('user.edit', $manager->id) }}" class="btn btn-sm btn-green m-r-2">Профиль</a>--}}
                                    {{--<a href="{{ route('users.destroy', $manager->id) }}" data-click="swal-warning" data-title="Подтвердите действие" data-text="Удалить пользователя {{ $manager->name }}?" data-classbtn="danger" data-actionbtn="Удалить" data-type="error" class="btn btn-sm btn-danger">Удалить</a>--}}
                                {{--</td>--}}
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