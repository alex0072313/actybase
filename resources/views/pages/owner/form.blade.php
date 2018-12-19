@push('css')
    <link href="/assets/plugins/dropzone/min/dropzone.min.css" rel="stylesheet"/>
    <link href="/assets/plugins/bootstrap-wysihtml5/dist/bootstrap3-wysihtml5.min.css" rel="stylesheet"/>
@endpush

@push('js')
    <script src="https://unpkg.com/web-animations-js@2.3.1/web-animations.min.js"></script>
    <script src="https://unpkg.com/hammerjs@2.0.8/hammer.min.js"></script>
    <script src="https://unpkg.com/muuri@0.7.1/dist/muuri.min.js"></script>

    <script src="/assets/plugins/bootstrap-wysihtml5/dist/bootstrap3-wysihtml5.all.min.js"></script>

    <script src="/assets/js/photoboard.js"></script>
    <script src="/assets/js/field_files.js"></script>

    <script>
        if ($('#owner_cat_select').length) {
            var select = $('#owner_cat_select'),
                url;

            @if(isset($owner))
                url = '{{ route('fields.get_for_owner', 'owner_'.$owner->id) }}';
            @else
                url = '{{ route('fields.get_for_owner') }}';
            @endif

            select.on('change', function () {
                var category_id = $(this).val();

                if (!$('.owner_field').length) {
                    $('.primary_info').after(bild_owner_field_form('<div class="fa-3x text-center my-1 text-green"><i class="fas fa-spinner fa-spin"></i></div>'));
                } else {
                    $('.owner_field .panel-body').html('<div class="fa-3x text-center my-3 text-green"><i class="fas fa-spinner fa-spin"></i></div>');
                }

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        category_id: category_id
                    },
                    dataType: 'JSON',
                    success: function (response) {
                        var fields_html = '';

                        if (response['fields'] !== undefined) {
                            for (var i = 0; i < response['fields'].length; i++) {
                                fields_html += response['fields'][i];
                            }
                        }

                        if (fields_html) {
                            $('.owner_field .panel-body').html(fields_html);
                        } else {
                            $('.owner_field').remove();
                        }

                        bild_htmltext();
                    }
                });
            });

        }
        bild_htmltext();

        //
        function bild_owner_field_form(fields) {
            var html = '<div class="panel panel-inverse owner_field">' +
                '<div class="panel-heading">' +
                '<h4 class="panel-title">Дополнительные поля</h4>' +
                '</div>' +
                '<div class="panel-body panel-form">' +
                fields +
                '</div>' +
                '</div>';
            return html;
        }

        function bild_htmltext() {
            $(".wysihtml5").wysihtml5({
                toolbar: {
                    "font-styles": false,
                    "image": false,
                    "size": 'sm'
                }
            });
        }

    </script>
@endpush

@extends('layouts.layout')

@if(isset($owner))
@section('page_header_buttons')
    <a href="{{ route('categories.create') }}" class="btn btn-green btn-xs m-l-5"><i
                class="fas fa-sm fa-fw fa-folder-open"></i> Новая категория</a>
@endsection
@endif

@section('content')

    <form action="{{ isset($owner) ? route('owners.update', 'owner_'.$owner->id) : route('owners.store') }}"
          method="post" enctype="multipart/form-data" class="form-horizontal form-bordered"
          data-parsley-validate="true">
        @csrf
        @if(isset($owner))
            @method('PUT')
        @endif

        <div class="row">
            <div class="col-lg-12 col-xl-6">
                <!-- begin panel -->
                <div class="panel panel-inverse primary_info">
                    <div class="panel-heading">
                        <h4 class="panel-title">Основная информация</h4>
                    </div>

                    <div class="panel-body panel-form">
                        <div class="form-group row">
                            <label class="col-form-label col-md-3">Название</label>
                            <div class="col-md-9">
                                <input type="text" name="name"
                                       value="{{ old('name') ? old('name') : (isset($owner) ? $owner->name : '') }}"
                                       class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
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
                                <select name="category_id" id="owner_cat_select"
                                        {{ isset($owner) ? ' disabled' : ''  }} class="default-select2 form-control{{ $errors->has('category_id') ? ' is-invalid' : '' }}"
                                        {{ isset($owner) ? ' data-owner="'.$owner->id.'"' : '' }} data-search="true"
                                        data-placeholder="Выберете категорию обьекта">
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
                                @if (isset($owner))
                                    <div class="f-s-10 mt-1 text-grey-darker">Выбор категории доступен только на этапе
                                        создания обьекта.
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-md-3">Родительский обьект</label>

                            <div class="col-md-9">
                                <select name="parent_id"
                                        class="default-select2 form-control{{ $errors->has('parent_id') ? ' is-invalid' : '' }}"
                                        data-search="true" data-placeholder="Родительский обьект">
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

                    </div>
                </div>
                <!-- end panel -->

                @if(isset($fields))
                    <div class="panel panel-inverse owner_field">
                        <div class="panel-heading">
                            <h4 class="panel-title">Дополнительные поля</h4>
                        </div>

                        <div class="panel-body panel-form">
                            @foreach($fields as $field)
                                {!! $field !!}
                            @endforeach
                        </div>
                    </div>
                @endif

            </div>

            <div class="col-lg-12 col-xl-6">
                <!-- begin panel -->
                <div class="panel panel-inverse">
                    <div class="panel-heading">
                        <h4 class="panel-title">Изображения</h4>
                    </div>

                    {{-- Загрузчик --}}
                    <div class="image_uploads">
                        <div class="grid">
                            @if(isset($owner))
                                @foreach($owner->images()->orderBy('pos')->get() as $image)
                                    <div class="item" data-for="{{ $image->id }}"
                                         data-filename="{{ $image->filename }}">
                                        <div class="item-content">
                                            <input type="hidden" name="images_pos[]" value="{{ $image->filename }}">

                                            <a href="javascript:;" class="remove text-danger" title="Удалить">
                                                <i class="fas fa-fw fa-times"></i>
                                            </a>

                                            <div class="image"
                                                 style="background-image: url({{ $image->th_url() }});"></div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <fieldset class="text-center pb-3">
                            <a href="javascript:void(0)" onclick="$('#pro-image').click()"
                               class="btn btn-default btn-lg"><i class="fas fa-sm fa-fw fa-upload"></i> Загрузить
                                изображения</a>
                            <input type="file" id="pro-image" name="images[]" style="display: none;"
                                   class="form-control" multiple>
                        </fieldset>
                    </div>
                    {{--  --}}

                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12 col-xl-6">
                <input type="submit" class="btn btn-sm btn-green float-left" value="Сохранить">
                @if(isset($owner))
                    <a href="{{ route('owners.destroy', 'owner_'.$owner->id) }}" data-click="swal-warning"
                       data-title="Подтвердите действие"
                       data-text="Удалить обьект {{ $owner->name }}{{ $owner->childs() ? ' и его потомков ('.$owner->childs()->count().')' : '' }}?"
                       data-classbtn="danger" data-actionbtn="Удалить" data-type="error"
                       class="btn btn-sm btn-danger float-right">Удалить</a>
                @endif
            </div>
        </div>

    </form>
@endsection