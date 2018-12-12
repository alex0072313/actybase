@extends('layouts.layout')

@section('content')

    <a href="{{ route('fieldtypes.create') }}" class="btn btn-green btn-lg mb-4">Добавить новый тип</a>

    @if($fieldtypes)
        <!-- begin panel -->
        <div class="panel panel-inverse">
            <div class="panel-heading">
                <h4 class="panel-title">Список типов</h4>
            </div>

            <!-- begin panel-body -->
            <div class="panel-body">
                <!-- begin table-responsive -->
                <div class="table-responsive">
                    <table class="table table-striped m-b-0">
                        <thead>
                        <tr>
                            <th>Название</th>
                            <th width="1%"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($fieldtypes as $fieldtype)
                            <tr>
                                <td>{{ $fieldtype->name }}</td>
                                <td class="with-btn" nowrap>
                                    <a href="{{ route('fieldtypes.edit', $fieldtype->id) }}" class="btn btn-sm btn-green m-r-2">Изменить</a>
                                    <a href="{{ route('fieldtypes.destroy', $fieldtype->id) }}" data-click="swal-warning" data-title="Подтвердите действие" data-text="Удалить поле {{ $fieldtype->name }}?" data-classbtn="danger" data-actionbtn="Удалить" data-type="error" class="btn btn-sm btn-danger">Удалить</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- end table-responsive -->
            </div>
            <!-- end panel-body -->
        </div>
    @else
        <p class="lead">
            Нет добавленных категорий
        </p>
    @endif


@endsection