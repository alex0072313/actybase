@extends('layouts.layout')

@section('content')

    <a href="{{ isset($category) ? route('fields.create_in_cat', 'category_'.$category->id) : route('fields.create') }}" class="btn btn-green btn-lg mb-4">Добавить новое поле</a>

    @php
        $list_categories = App\Category::allToAccess(true);
    @endphp

    @if($list_categories->count())
        <!-- Example single danger button -->
        <div class="btn-group mb-4 ml-2">
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                @if(isset($category))
                    Категория полей: {{ $category->name }}
                @else
                    Категория полей: Все
                @endif
            </button>
            <div class="dropdown-menu">
                @if(isset($category))
                    <a class="dropdown-item" href="{{ route('fields.index') }}">Все</a>
                @endif
                @foreach($list_categories as $cat)
                    @if(isset($category))
                        @continue($category->id == $cat->id)
                    @endif
                    <a class="dropdown-item" href="{{ route('fields.index', 'category_'.$cat->id) }}">{{ $cat->name }}</a>
                @endforeach
            </div>
        </div>
    @endif

    @if($fields->count())
        <!-- begin panel -->
        <div class="panel panel-inverse">
            <div class="panel-heading">
                <h4 class="panel-title">Список дополнительных полей</h4>
            </div>

            <!-- begin panel-body -->
            <div class="panel-body">
                <!-- begin table-responsive -->
                <div class="table-responsive">
                    <table class="table table-striped m-b-0">
                        <thead>
                        <tr>
                            <th>Название</th>
                            <th>Доступно для категорий</th>
                            <th width="1%"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($fields as $field)
                            <tr>
                                <td>{{ $field->name }}</td>
                                <td>
                                    @php
                                        $cats = $field->categories->map(function ($cat){
                                            return '<a href="'. route('fields.index', 'category_'.$cat->id) .'" class="btn btn-xs btn-grey">'.$cat->name.'</a>';
                                        })->toArray();


                                        echo implode('&nbsp;&nbsp;',$cats);
                                        //var_dump($cats);
                                    @endphp
                                </td>
                                <td class="with-btn" nowrap>
                                    <a href="{{ route('fields.edit', 'field_'.$field->id) }}" class="btn btn-sm btn-green m-r-2">Изменить</a>
                                    <a href="{{ route('fields.destroy', 'field_'.$field->id) }}" data-click="swal-warning" data-title="Подтвердите действие" data-text="Удалить поле {{ $field->name }}?" data-classbtn="danger" data-actionbtn="Удалить" data-type="error" class="btn btn-sm btn-danger">Удалить</a>
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
            Нет добавленных полей
        </p>
    @endif


@endsection