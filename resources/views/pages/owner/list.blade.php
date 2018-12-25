@push('css')
    <link href="/assets/plugins/DataTables/media/css/dataTables.bootstrap.min.css" rel="stylesheet" />
    <link href="/assets/plugins/DataTables/extensions/Responsive/css/responsive.bootstrap.min.css" rel="stylesheet" />
@endpush

@push('js')
    <script src="/assets/plugins/DataTables/media/js/jquery.dataTables.js"></script>
    <script src="/assets/plugins/DataTables/media/js/dataTables.bootstrap.min.js"></script>
    <script src="/assets/plugins/DataTables/extensions/Responsive/js/dataTables.responsive.min.js"></script>
    <script>

        $("#data-table-default").DataTable({
            responsive:!0
        });
        
    </script>
@endpush
    
@extends('layouts.layout')

@section('content')

    <a href="{{ isset($category) ? route('owners.create_in_cat', 'category_'.$category->id) : route('owners.create') }}" class="btn btn-green btn-lg mb-4">Добавить обьект</a>
    <a href="{{ isset($category) ? route('fields.index', 'category_'.$category->id) : route('fields.index') }}" class="btn btn-default mb-4 ml-2">Управение доп. полями</a>

    @if($owners)
        <!-- begin panel -->
        <div class="panel panel-inverse">
            <div class="panel-heading">
                <h4 class="panel-title">Обьекты</h4>
            </div>

            <!-- begin panel-body -->
            <div class="panel-body">
                <table id="data-table-default" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th width="1%"></th>
                            <th width="1%" data-orderable="false"></th>
                            <th class="text-nowrap">Название</th>
                            <th class="text-nowrap">Категория</th>
                            <th width="1%" data-orderable="false"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($owners as $owner)
                            <tr class="odd gradeX">
                                <td width="1%" class="f-s-600 text-inverse">ID#{{ $owner->id}}</td>
                                <td width="1%" class="with-img"><img src="../assets/img/user/user-1.jpg" class="img-rounded height-30" /></td>
                                <td><a href="{{ route('owners.edit', 'owner_'.$owner->id) }}" class="text-green">{{ $owner->name }}</a></td>
                                <td>{{ $owner->category->name }}</td>
                                <td>
                                    <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-xs m-r-2 btn-danger"><i class="fas fa-xs fa-fw fa-trash-alt"></i></a>
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