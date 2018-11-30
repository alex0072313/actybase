@push('js')
    <script src="/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
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

                @if(session('category_error'))
                    @include('includes.notify.box_error', ['msg' => session('category_error')])
                @endif

                @if(session('category_success'))
                    @include('includes.notify.box_success', ['msg' => session('category_success')])
                @endif

                <div class="panel-body panel-form">
                    <form action="{{ isset($category) ? route('categories.update', $category->id) : route('categories.store') }}" method="post" enctype="multipart/form-data" class="form-horizontal form-bordered" data-parsley-validate="true">
                        @csrf
                        @if(isset($category))
                            @method('PUT')
                        @endif

                            <div class="form-group row">
                            <label class="col-form-label col-md-3">Название</label>
                            <div class="col-md-9">
                                <input type="text" name="name" value="{{ old('name') ? old('name') : (isset($category) ? $category->name : '') }}" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
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
                            <label class="col-form-label col-md-3">Родительская категория</label>

                            <div class="col-md-9">
                                <select name="parent_id" class="default-select2 form-control" data-placeholder="Выберете категорию">
                                    <option></option>
                                    <option value="0">-- Без родителя --</option>
                                    @foreach(App\Category::allToAccess() as $cat)
                                        @if(isset($category))
                                            @continue($cat->id == $category->id)
                                        @endif
                                        <option value="{{ $cat->id }}"{{ isset($category) ? $cat->id == $category->parent_id ? ' selected':'' : '' }} >{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>

                        <div class="form-group">
                            <div class="clearfix">
                                <input type="submit" class="btn btn-sm btn-green float-left" value="Сохранить">
                                @if(isset($category))
                                    <a href="{{ route('categories.destroy', $category->id) }}" data-click="swal-warning" data-title="Подтвердите действие" data-text="Удалить категорию {{ $category->name }}{{ $category->childs()->count() ? ' и ее потомков':'' }}?" data-classbtn="danger" data-actionbtn="Удалить" data-type="error" class="btn btn-sm btn-danger float-right">Удалить</a>
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