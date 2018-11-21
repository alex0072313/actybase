@extends('layouts.auth')

@section('content')
    <!-- begin register-header -->
    <h1 class="register-header">
        Регистрация
        <small>Заполните форму</small>
    </h1>
    <!-- end register-header -->
    <!-- begin register-content -->
    <div class="register-content">

        <form action="{{ route('register') }}" method="POST" class="margin-bottom-0" data-parsley-validate="true">
            @csrf

            <label class="control-label">Имя, Фамилия <span class="text-danger">*</span></label>
            <div class="row row-space-10">
                <div class="col-md-6 m-b-15">
                    <input type="text" name="name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ old('name') }}" placeholder="Ваше Имя"
                           data-parsley-required="true"/>

                    @if ($errors->has('name'))
                        <span class="invalid-feedback" role="alert">
                            {{ $errors->first('name') }}
                        </span>
                    @endif

                </div>
                <div class="col-md-6 m-b-15">
                    <input type="text" name="lastname" value="{{ old('lastname') }}" class="form-control" placeholder="Ваша Фамилия"/>
                </div>
            </div>

            <label class="control-label">Email <span class="text-danger">*</span></label>
            <div class="row m-b-15">
                <div class="col-md-12">
                    <input type="text" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="Ваш Email адрес"
                           data-parsley-required="true"
                           data-parsley-type="email"/>

                    @if ($errors->has('email'))
                        <span class="invalid-feedback" role="alert">
                            {{ $errors->first('email') }}
                        </span>
                    @endif
                </div>
            </div>

            <label class="control-label">Пароль <span class="text-danger">*</span></label>
            <div class="row m-b-15">
                <div class="col-md-12">
                    <input type="password" id="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Ваш будущий Пароль"
                           data-parsley-required="true"
                           data-parsley-minlength="6"
                           data-parsley-equalto="#password_confirmation"
                    />

                    @if ($errors->has('password'))
                        <span class="invalid-feedback" role="alert">
                            {{ $errors->first('password') }}
                        </span>
                    @endif
                </div>
            </div>

            <label class="control-label">Повторите пароль <span class="text-danger">*</span></label>
            <div class="row m-b-15">
                <div class="col-md-12">
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Повторите пароль"
                    />
                </div>
            </div>

            <div class="checkbox checkbox-css m-b-30">
                <div class="checkbox checkbox-css m-b-30">
                    <input type="checkbox" id="confirm" name="confirm" data-parsley-mincheck="1">
                    <label for="confirm">
                        Отправляя данную форму, я подтверждаю свое согласие с <a href="javascript:;" class="text-green" data-toggle="modal" data-target="#mod1">правилами
                            сервиса</a>, <a href="javascript:;" class="text-green" data-toggle="modal" data-target="#mod2">политикой конфиденциальности и Cookie</a>.
                    </label>
                </div>
                @if ($errors->has('confirm'))
                    <div class="note note-warning note-with-right-icon m-b-15">
                        <div class="note-icon"><i class="fa fa-lightbulb"></i></div>
                        <div class="note-content text-right">
                            <h4><b>Уважаемый пользователь!</b></h4>
                            <p>Для завершения регистрации - нужно согласиться с правилами сервиса.</p>
                        </div>
                    </div>
                @endif
            </div>

            @push('modals')
                <!-- Правила сервиса -->
                <div class="modal fade" id="mod1" tabindex="-1" role="dialog" aria-labelledby="mod1_long_title" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <div class="modal-title h4" id="mod1_long_title">Правила сервиса</div>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Закрыть">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>
                                Давно выяснено, что при оценке дизайна и композиции читаемый текст мешает сосредоточиться.
                                Lorem Ipsum используют потому, что тот обеспечивает более или менее стандартное заполнение шаблона, а также реальное распределение букв и пробелов в абзацах,
                                которое не получается при простой дубликации "Здесь ваш текст.. Здесь ваш текст..
                                </p>
                                <p>
                                Здесь ваш текст.." Многие программы электронной вёрстки и редакторы HTML используют Lorem Ipsum в качестве текста по умолчанию, так что поиск по ключевым словам
                                "lorem ipsum" сразу показывает, как много веб-страниц всё ещё дожидаются своего настоящего рождения. За прошедшие годы текст Lorem Ipsum получил много версий.
                                </p>
                                <p>
                                Некоторые версии появились по ошибке, некоторые - намеренно (например, юмористические варианты).
                                </p>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-green" data-dismiss="modal">Ознакомился</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endpush

            @push('modals')
            <!-- Правила сервиса -->
                <div class="modal fade" id="mod2" tabindex="-1" role="dialog" aria-labelledby="mod2_long_title" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <div class="modal-title h4" id="mod2_long_title">Политика конфиденциальности и Cookie</div>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Закрыть">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>
                                    Давно выяснено, что при оценке дизайна и композиции читаемый текст мешает сосредоточиться.
                                    Lorem Ipsum используют потому, что тот обеспечивает более или менее стандартное заполнение шаблона, а также реальное распределение букв и пробелов в абзацах,
                                    которое не получается при простой дубликации "Здесь ваш текст.. Здесь ваш текст..
                                </p>
                                <p>
                                    Здесь ваш текст.." Многие программы электронной вёрстки и редакторы HTML используют Lorem Ipsum в качестве текста по умолчанию, так что поиск по ключевым словам
                                    "lorem ipsum" сразу показывает, как много веб-страниц всё ещё дожидаются своего настоящего рождения. За прошедшие годы текст Lorem Ipsum получил много версий.
                                </p>
                                <p>
                                    Некоторые версии появились по ошибке, некоторые - намеренно (например, юмористические варианты).
                                </p>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-green" data-dismiss="modal">Ознакомился</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endpush

            <div class="register-buttons">
                <button type="submit" class="btn btn-green btn-block btn-lg">Регистрация</button>
            </div>
            <div class="m-t-20 m-b-40 p-b-40 text-inverse">
                Уже зарегистрированны? Войти в <a href="{{ route('login') }}" class="text-green">личный кабинет</a>.
            </div>
        </form>
    </div>
    <!-- end register-content -->

@endsection