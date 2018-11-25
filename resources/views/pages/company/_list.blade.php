@extends('layouts.layout')

@section('content')

    {{--<a href="{{ route('user.add') }}" class="btn btn-green btn-lg mb-4">Добавить менеджера</a>--}}

    @if($companies)
        <!-- begin panel -->
        <div class="panel panel-inverse">
            <div class="panel-heading">
                <div class="panel-heading-btn">
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                </div>
                <h4 class="panel-title">Список компаний</h4>
            </div>

            <!-- begin panel-body -->
            <div class="panel-body">
                <!-- begin table-responsive -->
                <div class="table-responsive">
                    <table class="table table-striped m-b-0">
                        <thead>
                        <tr>
                            <th></th>
                            <th>Название</th>
                            <th>Директор</th>
                            <th>Активна до</th>
                            <th>Сатус</th>
                            <th width="1%"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($companies as $company)
                            <tr>
                                <td class="with-img width-40 pr-0">
                                    @if(Storage::disk('public')->exists('company_imgs/'.$company->id.'/thumb_xs.jpg'))
                                        <a href="{{ route('_company_edit', $company->id) }}" class="text-green">
                                            <img src="{{ Storage::disk('public')->url('company_imgs/'.$company->id.'/thumb_xs.jpg') }}"
                                                 class="rounded-circle"/>
                                        </a>
                                    @endif
                                </td>
                                <td><a href="{{ route('_company_edit', $company->id) }}" class="text-green">{{ $company->name ? $company->name : '-' }}</a></td>
                                <td>{{ $company->boss()->name }}</td>
                                <td>
                                    @php
                                        $active = '';
                                        $bestbefore = new Carbon($company->bestbefore);
                                        if($bestbefore < Carbon::now()){
                                            echo '<span class="text-danger">'.($company->bestbefore ? $company->bestbefore : 'Дата не указана').'</span>';
                                        }else{
                                            echo '<span class="text-green">'.$company->bestbefore.'</span>';
                                        }
                                    @endphp
                                </td>
                                <td>{!! $company->status ? '<span class="label label-green">Включена</span>' : '<span class="label label-secondary">Не включена</span>' !!}</td>
                                <td class="with-btn" nowrap>
                                    <a href="{{ route('_company_edit', $company->id) }}" class="btn btn-sm btn-green m-r-2">Изменить</a>
                                    <a href="{{ route('_company_destroy', $company->id) }}" data-click="swal-warning" data-title="Подтвердите действие" data-text="Удалить компанию{{ $company->name ? ' '.$company->name : '' }}?" data-classbtn="danger" data-actionbtn="Удалить" data-type="error" class="btn btn-sm btn-danger">Удалить</a>
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
            Нет добавленных менеджеров
        </p>
    @endif


@endsection