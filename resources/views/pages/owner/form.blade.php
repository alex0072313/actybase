@push('css')
    <link href="/assets/plugins/dropzone/min/dropzone.min.css" rel="stylesheet" />
@endpush

@extends('layouts.layout')

@if(isset($owner))
    @section('page_header_buttons')
        <a href="{{ route('categories.create') }}" class="btn btn-green btn-xs m-l-5"><i class="fas fa-sm fa-fw fa-folder-open"></i> Новая категория</a>
    @endsection
@endif

@section('content')

    <form action="{{ isset($owner) ? route('owners.update', 'owner_'.$owner->id) : route('owners.store') }}" method="post" enctype="multipart/form-data" class="form-horizontal form-bordered" data-parsley-validate="true">
        @csrf
        @if(isset($owner))
            @method('PUT')
        @endif

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

                    <div class="panel-body panel-form">
                            <div class="form-group row">
                                <label class="col-form-label col-md-3">Название</label>
                                <div class="col-md-9">
                                    <input type="text" name="name" value="{{ old('name') ? old('name') : (isset($owner) ? $owner->name : '') }}" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                           placeholder="Название обьекта"
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
                                <label class="col-form-label col-md-3">Категория</label>

                                <div class="col-md-9">
                                    <select name="category_id" class="default-select2 form-control{{ $errors->has('category_id') ? ' is-invalid' : '' }}" data-search="true" data-placeholder="Выберете категорию обьекта">
                                        <option></option>
                                        @foreach(App\Category::allToAccess(true) as $cat)
                                            @if(isset($category))
                                                <option value="{{ $cat->id }}"{{ $cat->id == $category->id ? ' selected':'' }} >{{ $cat->name }}</option>
                                            @else
                                                <option value="{{ $cat->id }}"{{ isset($owner) ? $cat->id == $owner->category_id ? ' selected':'' : '' }} >{{ $cat->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    @if ($errors->has('category_id'))
                                        <span class="invalid-feedback" role="alert">
                                            Выберете категорию обьекта!
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-form-label col-md-3">Родительский обьект</label>

                                <div class="col-md-9">
                                    <select name="parent_id" class="default-select2 form-control{{ $errors->has('parent_id') ? ' is-invalid' : '' }}" data-search="true" data-placeholder="Родительский обьект">
                                        <option></option>
                                        <option value="0">-- Без родителя --</option>
                                        @foreach(Auth::user()->company->OwnersByCat() as $cat_name => $cat)
                                            <optgroup label="{{ $cat_name }}">
                                                @foreach($cat as $parent_owner)
                                                    @if(isset($owner))
                                                        @continue($parent_owner->id == $owner->id)
                                                    @endif
                                                    <option value="{{ $parent_owner->id }}"{{ isset($owner) ? $parent_owner->id == $owner->parent_id ? ' selected':'' : '' }} >{{ $parent_owner->name }}</option>
                                                @endforeach
                                            </optgroup>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="clearfix">
                                    <input type="submit" class="btn btn-sm btn-green float-left" value="Сохранить">
                                    @if(isset($owner))
                                        <a href="{{ route('owners.destroy', 'owner_'.$owner->id) }}" data-click="swal-warning" data-title="Подтвердите действие" data-text="Удалить обьект {{ $owner->name }}{{ $owner->childs() ? ' и его потомков ('.$owner->childs()->count().')' : '' }}?" data-classbtn="danger" data-actionbtn="Удалить" data-type="error" class="btn btn-sm btn-danger float-right">Удалить</a>
                                    @endif
                                </div>
                            </div>

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
                        <h4 class="panel-title">Изображения</h4>
                    </div>

                    <div class="">
                        {{-- Загрузчик --}}

                        <div class="image_uploads">

                            <div class="preview-images-zone">
                                @if(isset($owner))
                                    @foreach($owner->images as $image)
                                        <div class="preview-image preview-show-3">
                                            <div class="image-cancel" data-no="3">x</div>
                                            <div class="image-zone">
                                                <img id="pro-img-3" src="{{ Storage::disk('public')->url($image->path) }}">
                                            </div>
                                            <div class="tools-edit-image"><a href="javascript:void(0)" data-no="3" class="btn btn-light btn-edit-image">edit</a></div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <fieldset class="text-center">
                                <a href="javascript:void(0)" onclick="$('#pro-image').click()" class="btn btn-default btn-lg"><i class="fas fa-sm fa-fw fa-upload"></i> Загрузить изображения</a>
                                <input type="file" id="pro-image" name="images[]" style="display: none;" class="form-control" multiple>
                            </fieldset>
                        </div>

                        {{--  --}}
                    </div>

                </div>
            </div>

        </div>

    </form>
@endsection