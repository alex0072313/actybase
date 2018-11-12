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
                        Отправляя данную форму, я подтверждаю свое согласие с <a href="javascript:;" class="text-green">правилами
                            сервиса</a>, <a href="javascript:;" class="text-green">политикой конфиденциальности</a> и <a
                                href="javascript:;" class="text-green">Cookie</a>.
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