@push('css')
    <link href="/assets/plugins/DataTables/media/css/dataTables.bootstrap.min.css" rel="stylesheet" />
    <link href="/assets/plugins/DataTables/extensions/Buttons/css/buttons.bootstrap.min.css" rel="stylesheet" />
    <link href="/assets/plugins/DataTables/extensions/Responsive/css/responsive.bootstrap.min.css" rel="stylesheet" />
    <link href="/assets/plugins/DataTables/extensions/FixedHeader/css/fixedHeader.bootstrap.min.css" rel="stylesheet" />
@endpush

@push('js')
    <script src="/assets/plugins/DataTables/media/js/jquery.dataTables.js"></script>
    <script src="/assets/plugins/DataTables/media/js/dataTables.bootstrap.min.js"></script>
    <script src="/assets/plugins/DataTables/extensions/Buttons/js/dataTables.buttons.min.js"></script>
    <script src="/assets/plugins/DataTables/extensions/Buttons/js/buttons.bootstrap.min.js"></script>
    <script src="/assets/plugins/DataTables/extensions/Buttons/js/buttons.flash.min.js"></script>
    <script src="/assets/plugins/DataTables/extensions/Buttons/js/jszip.min.js"></script>
    <script src="/assets/plugins/DataTables/extensions/Buttons/js/pdfmake.min.js"></script>
    <script src="/assets/plugins/DataTables/extensions/Buttons/js/vfs_fonts.min.js"></script>
    <script src="/assets/plugins/DataTables/extensions/Buttons/js/buttons.html5.min.js"></script>
    <script src="/assets/plugins/DataTables/extensions/Buttons/js/buttons.print.min.js"></script>
    <script src="/assets/plugins/DataTables/extensions/Responsive/js/dataTables.responsive.min.js"></script>
    <script src="/assets/plugins/DataTables/extensions/FixedHeader/js/dataTables.fixedHeader.min.js"></script>
    <script>

        $("#data-table-default").DataTable({
            responsive: true,
            paging: false,
            bInfo : false,
            fixedHeader: {
                headerOffset: $('#header').outerHeight()
            },
            dom: 'Bfrtip',
            buttons: [
                { extend: 'copyHtml5', text: '<i class="fas fa-fw fa-copy"></i> Скопировать в буфер' },
                { extend: 'excel', text: '<i class="fas fa-fw fa-table"></i> Сохранить в Excel' },
                { extend: 'pdf', text: '<i class="fas fa-fw fa-file-pdf"></i> Сохранить в Pdf' },
            ],
            language: {
                searchPlaceholder: "Поиск по обьектам...",
                search: '',
                zeroRecords: "Обьектов не найдено",

                buttons: {
                    copyTitle: 'Сохранено в буфер',
                    copySuccess: {
                        _: '%d обьектов скопированно',
                        1: '1 обьект скопирован'
                    }
                }

            }
        });
        
    </script>
@endpush
    
@extends('layouts.layout')

@section('content')

    <a href="{{ isset($category) ? route('owners.create_in_cat', 'category_'.$category->id) : route('owners.create') }}" class="btn btn-green btn-lg mb-4"><i class="far fa-fw fa-building"></i> Добавить обьект</a>

    @php
        $list_categories = App\Category::allToAccess(true);
    @endphp

    @if($list_categories->count())
        <!-- Example single danger button -->
        <div class="btn-group mb-4 ml-2">
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-fw fa-folder-open"></i>
                @if(isset($category))
                    Категория обьектов: {{ $category->name }}
                @else
                    Категория обьектов: Все
                @endif
            </button>
            <div class="dropdown-menu">
                @if(isset($category))
                    <a class="dropdown-item" href="{{ route('owners.index') }}">Все</a>
                @endif
                @foreach($list_categories as $cat)
                    @if(isset($category))
                        @continue($category->id == $cat->id)
                    @endif
                    <a class="dropdown-item" href="{{ route('owners.index', 'category_'.$cat->id) }}">{{ $cat->name }}</a>
                @endforeach
            </div>
        </div>
    @endif

    <a href="{{ isset($category) ? route('fields.index', 'category_'.$category->id) : route('fields.index') }}" class="btn btn-default mb-4 ml-2"><i class="fas fa-fw fa-server"></i> Управение доп. полями</a>

    @if($owners)

        {{--@php--}}
            {{--$fields = [];--}}
            {{--$field_ = \App\Field::all();--}}
            {{--$field_types_ = [];--}}

            {{--foreach ($owners as $owner){--}}
                {{--$field_contents = $owner->fields;--}}
                {{--foreach ($field_contents as $field_content){--}}
                    {{--if($field_data = $field_->where('id', $field_content->fileld_id)){--}}
                        {{--$field_types_[] = $field_data->name;--}}
                    {{--}--}}
                    {{--$field = $field_content->field;--}}
                    {{--$fields[$owner->id][$field->name] = $field_content->content;--}}
                {{--}--}}
            {{--}--}}

            {{--dd($field_types_);--}}

        {{--@endphp--}}

        <!-- begin panel -->
        <div class="panel panel-inverse">
            <div class="panel-heading">
                <h4 class="panel-title">Обьекты</h4>
            </div>

            <!-- begin panel-body -->
            <div class="panel-body">
                <table id="data-table-default" class="table row-border table-striped">
                    <thead>
                        <tr>
                            <th width="1%">ID</th>
                            <th width="1%" data-orderable="false"></th>
                            <th class="text-nowrap">Название</th>
                            <th class="text-nowrap">Категория</th>
                            {{--@if($fields->first())--}}
                                {{--@foreach($fields->first() as $field_name => $field_val)--}}
                                    {{--<th class="text-nowrap">{{ $field_name }}</th>--}}
                                {{--@endforeach--}}
                            {{--@endif--}}
                            <th width="1%" data-orderable="false"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($owners as $owner)
                            <tr class="odd gradeX">
                                <td width="1%" class="f-s-600 text-inverse">{{ $owner->id}}</td>
                                <td width="1%" class="with-img"><img src="../assets/img/user/user-1.jpg" class="img-rounded height-30" /></td>
                                <td><a href="{{ route('owners.edit', 'owner_'.$owner->id) }}" class="text-green">{{ $owner->name }}</a></td>
                                <td>{{ $owner->category->name }}</td>

                                {{--@if($fields[$owner->id])--}}
                                    {{--@foreach($fields[$owner->id] as $field_name => $field_val)--}}
                                        {{--<th class="text-nowrap">{{ $field_name }}</th>--}}
                                    {{--@endforeach--}}
                                {{--@endif--}}

                                <td width="1%">
                                    <div class="width-60">
                                        <a href="{{ route('owners.edit', $owner->id) }}" title="Изменить" class="btn btn-xs m-r-2 btn-green"><i class="far fa-xs fa-fw fa-edit"></i></a>
                                        <a href="{{ route('owners.destroy', 'owner_'.$owner->id) }}" title="Удалить" data-click="swal-warning" data-title="Подтвердите действие" data-text="Удалить обьект {{ $owner->name }}{{ $owner->childs()->count() ? ' и его потомков':'' }}?" data-classbtn="danger" data-actionbtn="Удалить" data-type="error" class="btn btn-xs btn-danger"><i class="fas fa-xs fa-fw fa-trash-alt"></i></a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
            <!-- end panel-body -->
        </div>
    @else
        <p class="lead">
            Нет добавленных обьектов
        </p>
    @endif


@endsection