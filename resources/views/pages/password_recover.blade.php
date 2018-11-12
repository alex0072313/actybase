@extends('layouts.auth')

@section('content')

    <h1 class="register-header">
        Восстановление пароля
        <small>На Ваш Email адрес будет отправлена сслыка на восстановление пароля</small>
    </h1>

    <div class="register-content">
        @if (session('status'))
            <div class="alert alert-success fade show">
                <span class="close" data-dismiss="alert">×</span>
                {{ session('status') }}
            </div>
        @endif
        <form action="{{ route('password.email') }}" method="POST" class="margin-bottom-0" data-parsley-validate="true">
            @csrf
            <label class="control-label">Email <span class="text-danger">*</span></label>
            <div class="row m-b-30">
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

            <div class="register-buttons">
                <button type="submit" class="btn btn-green btn-block btn-lg">Восстановить пароль</button>
            </div>

            <div class="m-t-20 m-b-40 p-b-40">
                Еще не зарегистрированны? <a href="{{ route('register') }}" class="text-green">Пройти регистрацию</a>.
            </div>
        </form>
    </div>


@endsection