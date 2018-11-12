@extends('layouts.auth')

@section('content')
    <!-- begin register-header -->
    <h1 class="register-header">
        Вход в личный кабинет
    </h1>
    <!-- end register-header -->
    <!-- begin register-content -->
    <div class="register-content">
        <form action="{{ route('login') }}" method="POST" class="margin-bottom-0" data-parsley-validate="true">
            @csrf

            <label class="control-label">Email <span class="text-danger">*</span></label>
            <div class="row m-b-15">
                <div class="col-md-12">
                    <input type="text" name="email" value="{{ old('email') }}" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="Ваш Email адрес"
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
                    <input type="password" name="password" id="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="Ваш Пароль"
                           data-parsley-required="true"
                    />

                    @if ($errors->has('password'))
                        <span class="invalid-feedback" role="alert">
                            {{ $errors->first('password') }}
                        </span>
                    @endif
                    <div class="mt-1">
                        <a class="text-green" href="{{ route('password.request') }}">Не помню пароль</a></span>
                    </div>
                </div>
            </div>

            <div class="checkbox checkbox-css m-b-30">
                <div class="checkbox checkbox-css m-b-30">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label for="remember">
                        Запомнить на этом компьютере
                    </label>
                </div>
            </div>
            <div class="register-buttons">
                <button type="submit" class="btn btn-green btn-block btn-lg">Войти</button>
            </div>
            <div class="m-t-20 m-b-40 p-b-40 text-inverse">
                Еще не зарегистрированны? <a href="{{ route('register') }}" class="text-green">Пройти регистрацию</a>.
            </div>
        </form>
    </div>
    <!-- end register-content -->
@endsection