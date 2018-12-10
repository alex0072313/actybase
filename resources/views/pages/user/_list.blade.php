@extends('layouts.layout')

@section('content')

    {{--<a href="{{ route('user.add') }}" class="btn btn-green btn-lg mb-4">Добавить менеджера</a>--}}

    @if($users)
        <!-- begin panel -->
        <div class="panel panel-inverse">
            <div class="panel-heading">
                <h4 class="panel-title">Все пользователи</h4>
            </div>

            <!-- begin panel-body -->
            <div class="panel-body">
                <!-- begin table-responsive -->
                <div class="table-responsive">
                    <table class="table table-striped m-b-0">
                        <thead>
                        <tr>
                            <th></th>
                            <th>Имя</th>
                            <th>Email</th>
                            <th>Компания</th>
                            <th>Роль</th>
                            <th width="1%"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td class="with-img width-40 pr-0">
                                    @if(Storage::disk('public')->exists('user_imgs/'.$user->id.'/thumb_xs.jpg'))
                                        <a href="{{ route('_user_edit', $user->id) }}" class="text-green">
                                            <img src="{{ Storage::disk('public')->url('user_imgs/'.$user->id.'/thumb_xs.jpg') }}"
                                                 class="rounded-circle"/>
                                        </a>
                                    @endif
                                </td>
                                <td><a href="{{ route('_user_edit', $user->id) }}"
                                       class="text-green">{!! ($user->lastname ? $user->lastname.'&nbsp' : '') . $user->name !!}</a>
                                </td>
                                <td>{{ $user->email }}</td>
                                <td><a href="{{ route('_company_edit', $user->company->id) }}" class="text-green">{{ $user->company->name }}</a></td>
                                <td>{{ $user->roleName() }}</td>
                                <td class="with-btn" nowrap>
                                    <a href="{{ route('_user_edit', $user->id) }}" class="btn btn-sm btn-green m-r-2">Изменить</a>
                                    <a href="{{ route('_user_destroy', $user->id) }}" data-click="swal-warning" data-title="Подтвердите действие" data-text="Удалить пользователя {{ $user->name }}?" data-classbtn="danger" data-actionbtn="Удалить" data-type="error" class="btn btn-sm btn-danger">Удалить</a>
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
            Нет добавленных менеджеров
        </p>
    @endif


@endsection