@foreach($childs as $category)
    <tr>
        <td>
            @for($_i = 0; $_i < $i; $_i++)
                &nbsp;&nbsp;
            @endfor
            - {{ $category->name }}</td>
        @role('megaroot')
            <td><a class="text-green" href="{{ route('user.edit', $category->user->id) }}">{{ $category->user->name }}</a></td>
        @endrole

        <td class="with-btn" nowrap>
            @if(Auth::user()->can('access', $category))
                <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-sm btn-green m-r-2">Изменить</a>
                <a href="{{ route('categories.destroy', $category->id) }}" data-click="swal-warning" data-title="Подтвердите действие" data-text="Удалить категорию {{ $category->name }}{{ $category->childs()->count() ? ' и ее потомков':'' }}?" data-classbtn="danger" data-actionbtn="Удалить" data-type="error" class="btn btn-sm btn-danger">Удалить</a>
            @else
                <span class="label label-secondary">Нет доступа к изменению</span>
            @endif
        </td>
    </tr>
    @if(count($category->childs))
        @php
            $i = $i+1;
        @endphp
        @include('includes.category.tree_table_item',['childs' => $category->childs, 'i'=>$i])
    @endif
@endforeach