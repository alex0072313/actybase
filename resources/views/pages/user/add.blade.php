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
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
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
                    <form action="{{ route('users.store') }}" method="post" enctype="multipart/form-data" class="form-horizontal form-bordered" data-parsley-validate="true">
                        @csrf

                        <div class="form-group row">
                            <label class="col-form-label col-md-3">Имя</label>
                            <div class="col-md-9">
                                <input type="text" name="name" value="{{  old('name') }}" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                       placeholder="Имя"
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
                                <input type="text" name="lastname" value="{{ old('lastname') }}" class="form-control" placeholder="Фамилия">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-md-3">Email</label>
                            <div class="col-md-9">
                                <input type="email" name="email" value="{{ old('email') }}" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                       placeholder="Email адрес"
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
                                <input type="file" name="avatar" class="form-control-file">
                            </div>
                        </div>

                        <div class="form-group">
                            <div>
                                <input type="submit" class="btn btn-sm btn-green" value="Добавить">
                            </div>
                        </div>

                    </form>
                </div>
            </div>
            <!-- end panel -->

        </div>


    </div>


@endsection