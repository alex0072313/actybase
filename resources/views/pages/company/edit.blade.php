@extends('layouts.layout')

@section('content')
    <div class="row">

        <div class="col-lg-6">
            <!-- begin panel -->
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <h4 class="panel-title">Основная информация</h4>
                </div>

                @if(session('company_error'))
                    @include('includes.notify.box_error', ['msg' => session('company_error')])
                @endif

                @if(session('company_success'))
                    @include('includes.notify.box_success', ['msg' => session('company_success')])
                @endif

                <div class="panel-body panel-form">
                    <form action="{{ route('user_company') }}" method="post" enctype="multipart/form-data" class="form-horizontal form-bordered" data-parsley-validate="true">
                        @csrf

                        @if($company->bestbefore)
                            <div class="form-group row">
                                <label class="col-form-label col-md-3">Активна до</label>
                                <div class="col-md-9">
                                    <input type="text" disabled readonly="" class="form-control-plaintext text-green" value="{{ $company->bestbefore }}">
                                </div>
                            </div>
                        @endif

                        <div class="form-group row">
                            <label class="col-form-label col-md-3">Название компании</label>
                            <div class="col-md-9">
                                <input type="text" name="name" value="{{ old('name') ? old('name') : $company->name }}" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                       placeholder="Название компании"
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
                            <label class="col-form-label col-md-3">Логотип</label>
                            <div class="col-md-9">

                                @if(isset($company->id) && Storage::disk('public')->exists('company_imgs/'.$company->id.'/thumb_m.jpg'))
                                    <div class="mb-3">
                                        <img src="{{ Storage::disk('public')->url('company_imgs/'.$company->id.'/thumb_m.jpg') }}" alt="">
                                    </div>
                                @endif

                                <input type="file" name="logo" class="form-control-file">
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

    </div>
@endsection