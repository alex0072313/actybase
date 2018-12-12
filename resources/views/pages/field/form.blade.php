@extends('layouts.layout')

@section('content')
    <div class="row">

        <div class="col-lg-6">
            <!-- begin panel -->
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <h4 class="panel-title">Основная информация</h4>
                </div>

                @if(session('field_error'))
                    @include('includes.notify.box_error', ['msg' => session('field_error')])
                @endif

                @if(session('field_success'))
                    @include('includes.notify.box_success', ['msg' => session('field_success')])
                @endif

                <div class="panel-body panel-form">
                    <form action="{{ isset($field) ? route('fields.update', $field->id) : route('fields.store') }}" method="post" enctype="multipart/form-data" class="form-horizontal form-bordered" data-parsley-validate="true">
                        @csrf
                        @if(isset($field))
                            @method('PUT')
                        @endif

                            <div class="form-group row">
                            <label class="col-form-label col-md-3">Название</label>
                            <div class="col-md-9">
                                <input type="text" name="name" value="{{ old('name') ? old('name') : (isset($field) ? $field->name : '') }}" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                       placeholder="Название поля"
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
                            <label class="col-form-label col-md-3">Тип</label>

                            <div class="col-md-9">
                                @if(!isset($field))
                                    <select name="fieldtype_id" class="default-select2 form-control">
                                        @foreach(App\Fieldtype::all() as $type)
                                            <option value="{{ $type->id }}"{{ isset($field) ? $type->id == $field->fieldtype_id ? ' selected':'' : '' }} >{{ $type->name }}</option>
                                        @endforeach
                                    </select>
                                @else
                                    <input class="form-control-plaintext" type="text" placeholder="Тип указывается только при создании" disabled readonly />
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                                <label class="col-form-label col-md-3">Доступно для категорий</label>
                                <div class="col-md-9">
                                    @foreach(App\Category::allToAccess(true) as $cat)
                                        <div class="checkbox checkbox-css">
                                            @if(isset($field))
                                                @if($field->categories)
                                                    <input name="categories[]" value="{{ $cat->id }}" type="checkbox" id="cat_{{ $cat->id }}"{{ $field->categories()->find($cat->id) ? ' checked':'' }} />
                                                @else
                                                    <input name="categories[]" value="{{ $cat->id }}" type="checkbox" id="cat_{{ $cat->id }}" />
                                                @endif
                                            @else
                                                <input name="categories[]" value="{{ $cat->id }}" type="checkbox" id="cat_{{ $cat->id }}" />
                                            @endif
                                            <label for="cat_{{ $cat->id }}">{{ $cat->name }}</label>
                                        </div>
                                    @endforeach
                                     @if ($errors->has('categories'))
                                         <div class="alert alert-danger fade show mt-3">
                                            Необходимо выбрать как минимум 1 категорию
                                         </div>
                                    @endif
                                </div>
                            </div>

                        <div class="form-group">
                            <div class="clearfix">
                                <input type="submit" class="btn btn-sm btn-green float-left" value="Сохранить">
                                @if(isset($field))
                                    <a href="{{ route('fields.destroy', $field->id) }}" data-click="swal-warning" data-title="Подтвердите действие" data-text="Удалить поле {{ $field->name }}?" data-classbtn="danger" data-actionbtn="Удалить" data-type="error" class="btn btn-sm btn-danger float-right">Удалить</a>
                                @endif
                            </div>
                        </div>

                    </form>
                </div>
            </div>
            <!-- end panel -->
        </div>

    </div>
@endsection