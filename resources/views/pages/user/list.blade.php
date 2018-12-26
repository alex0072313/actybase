@extends('layouts.layout')

@section('content')

    <a href="{{ route('user.add') }}" class="btn btn-green btn-lg mb-4"><i class="fa fa-users"></i> Добавить менеджера</a>

    @if($managers)
        <!-- begin panel -->
        <div class="panel panel-inverse">
            <div class="panel-heading">
                <h4 class="panel-title">Основная команда</h4>
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
                            <th width="1%"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($managers as $manager)
                            <tr>
                                <td class="with-img width-40 pr-0">
                                    @if(Storage::disk('public')->exists('user_imgs/'.$manager->id.'/thumb_xs.jpg'))
                                        <a href="{{ route('user.edit', $manager->id) }}" class="text-green">
                                            <img src="{{ Storage::disk('public')->url('user_imgs/'.$manager->id.'/thumb_xs.jpg') }}"
                                                 class="rounded-circle"/>
                                        </a>
                                    @endif
                                </td>
                                <td><a href="{{ route('user.edit', $manager->id) }}"
                                       class="text-green">{!! ($manager->lastname ? $manager->lastname.'&nbsp' : '') . $manager->name !!}</a>
                                </td>
                                <td>{{ $manager->email }}</td>
                                <td class="with-btn" nowrap>
                                    <a href="{{ route('user.edit', $manager->id) }}" class="btn btn-xs m-r-2 btn-green"><i class="far fa-xs fa-fw fa-edit"></i></a>
                                    <a href="{{ route('users.destroy', $manager->id) }}" data-click="swal-warning" data-title="Подтвердите действие" data-text="Удалить пользователя {{ $manager->name }}?" data-classbtn="danger" data-actionbtn="Удалить" data-type="error" class="btn btn-xs btn-danger"><i class="fas fa-xs fa-fw fa-trash-alt"></i></a>
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