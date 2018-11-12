@extends('layouts.auth')

@section('content')

    <!-- begin register-header -->
    <h1 class="register-header">
        Укажите новый пароль
        <small>Введите новый пароль для входа в личный кабинет</small>
    </h1>
    <!-- end register-header -->

    <!-- begin register-content -->
    <div class="register-content">

        <form action="{{ route('password.update') }}" method="POST" class="margin-bottom-0" data-parsley-validate="true">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">

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
                    <input type="password" id="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Ваш новый Пароль"
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

            <div class="register-buttons">
                <button type="submit" class="btn btn-green btn-block btn-lg">Сбросить пароль</button>
            </div>

            <div class="m-t-20 m-b-40 p-b-40 text-inverse">
                Еще не зарегистрированны? <a href="{{ route('register') }}" class="text-green">Пройти регистрацию</a>.
            </div>

        </form>
    </div>
    <!-- end register-content -->
@endsection