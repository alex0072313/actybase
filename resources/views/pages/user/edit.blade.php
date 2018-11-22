@push('js')
    <script src="/assets/plugins/bootstrap-show-password/bootstrap-show-password.js"></script>
@endpush

@extends('layouts.layout')

@section('content')

    <div class="row">

        <div class="col-lg-6">

            <!-- begin panel -->
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                    </div>
                    <h4 class="panel-title">Основная информация</h4>
                </div>

                @if(session('user_primary_error'))
                    @include('includes.notify.box_error', ['msg' => session('user_primary_error')])
                @endif

                @if(session('user_primary_success'))
                    @include('includes.notify.box_success', ['msg' => session('user_primary_success')])
                @endif

                <div class="panel-body panel-form">
                    <form action="{{ route('user.update', ['user' => $user->id]) }}" method="post" enctype="multipart/form-data" class="form-horizontal form-bordered" data-parsley-validate="true">
                        @csrf
                        @method('put')

                        <div class="form-group row">
                            <label class="col-form-label col-md-3">Роль</label>
                            <div class="col-md-9">
                                <input type="text" disabled readonly="" class="form-control-plaintext" value="{{ config('role.names.'.$user->roles()->get()->first()->name.'.dolg') }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-md-3">Имя</label>
                            <div class="col-md-9">
                                <input type="text" name="name" value="{{  old('name') ? old('name') : $user->name }}" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                       placeholder="Ваше Имя"
                                       data-parsley-required="true"
                                >
                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        {{ $errors->first('name') }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-md-3">Фамилия</label>
                            <div class="col-md-9">
                                <input type="text" name="lastname" value="{{  old('lastname') ? old('lastname') : $user->lastname }}" class="form-control" placeholder="Ваша Фамилия">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-md-3">Email</label>
                            <div class="col-md-9">
                                <input type="email" name="email" value="{{  old('email') ? old('email') : $user->email }}" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                       placeholder="Ваш Email"
                                       data-parsley-required="true"
                                       data-parsley-type="email">
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        {{ $errors->first('email') }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-md-3">Аватар</label>
                            <div class="col-md-9">

                                @if(isset($user->id) && Storage::disk('public')->exists('user_imgs/'.$user->id.'/thumb_m.jpg'))
                                    <div class="mb-3">
                                        <img src="{{ Storage::disk('public')->url('user_imgs/'.$user->id.'/thumb_m.jpg') }}" alt="">
                                    </div>
                                @endif

                                <input type="file" name="avatar" class="form-control-file">
                            </div>
                        </div>

                        <div class="form-group">
                            <div>
                                <input type="submit" class="btn btn-sm btn-green" value="Сохранить">
                            </div>
                        </div>

                    </form>
                </div>
            </div>
            <!-- end panel -->

        </div>

        <div class="col-lg-6">

            <!-- begin panel -->
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                    </div>
                    <h4 class="panel-title">Смена пароля</h4>
                </div>

                @if(session('user_pass_error'))
                    @include('includes.notify.box_error', ['msg' => session('user_pass_error')])
                @endif

                @if(session('user_pass_success'))
                    @include('includes.notify.box_success', ['msg' => session('user_pass_success')])
                @endif

                <div class="panel-body panel-form">
                    <form action="{{ route('user.update', ['user' => $user->id]) }}" method="post" enctype="multipart/form-data" class="form-horizontal form-bordered">
                        @csrf
                        @method('put')

                        <input type="hidden" name="change_password" value="1">

                        <div class="form-group row">
                            <label class="col-form-label col-md-3">Новый пароль</label>
                            <div class="col-md-9">
                                <input name="password" data-toggle="password" data-placement="before" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" type="password" placeholder="Введите новый пароль"/>
                                @if($errors->has('password'))
                                    <div class="invalid-feedback d-block">
                                        {{ $errors->first('password') }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-md-3">Повторите пароль</label>
                            <div class="col-md-9">
                                <input name="password_confirmation" data-toggle="password" data-placement="before" id="password_confirmation" name="password_confirmation" class="form-control{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}" type="password" placeholder="Повторите пароль" />
                                @if($errors->has('password_confirmation'))
                                    <div class="invalid-feedback d-block">
                                        {{ $errors->first('password_confirmation') }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div>
                                <input type="submit" class="btn btn-sm btn-green" value="Обновить пароль">
                            </div>
                        </div>

                    </form>
                </div>
            </div>
            <!-- end panel -->

        </div>


    </div>


@endsection