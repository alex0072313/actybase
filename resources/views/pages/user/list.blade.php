@push('docready')
    //Notification.init();

    $('[data-click="swal-warning"]').click(function (e) {

        var title = $(this).data('title') ? $(this).data('title') : 'Подтвердите действие',
            type = $(this).data('type') ? $(this).data('type') : 'warning',
            confirm_btn = $(this).data('actionbtn') ? $(this).data('actionbtn') : 'Ok',
            class_btn = $(this).data('classbtn') ? $(this).data('classbtn') : 'green',
            url = $(this).attr('href'),
            options = {};

        e.preventDefault();

    options = {
        title: title,
        icon: type,
        buttons: {
            cancel: {
                text: 'Отмена',
                value: !0,
                visible: !0,
                className: "btn btn-default", closeModal: !0,
                value: "cancel"
            },
            confirm: {
                text: confirm_btn,
                value: !0,
                visible: !0,
                className: "btn btn-" + class_btn, closeModal: !0,
                value: "confirm"
            }
        }
    };

    if($(this).data('text')){
        options.text = $(this).data('text');
    }

    swal(options).then((value) => {
        switch (value) {
            case "confirm":
                window.location = url;
            break;
        }
    });

});

@endpush

@extends('layouts.layout')

@section('content')

    <a href="{{ route('user.add') }}" class="btn btn-green btn-lg mb-4">Добавить менеджера</a>

    @if($managers)
        <!-- begin panel -->
        <div class="panel panel-inverse">
            <div class="panel-heading">
                <div class="panel-heading-btn">
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i
                                class="fa fa-expand"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i
                                class="fa fa-redo"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i
                                class="fa fa-minus"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i
                                class="fa fa-times"></i></a>
                </div>
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
                                    <a href="{{ route('user.edit', $manager->id) }}" class="btn btn-sm btn-green m-r-2">Профиль</a>
                                    <a href="{{ route('users.destroy', $manager->id) }}" data-click="swal-warning" data-title="Подтвердите действие" data-text="Удалить пользователя {{ $manager->name }}?" data-classbtn="danger" data-actionbtn="Удалить" data-type="error" class="btn btn-sm btn-danger">Удалить</a>
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