@foreach ($pro as $k => $p)
    <tr>
        <th scope="row">{{ $k + 1 }}</th>
        <td>
            <a href="{{ url('admin/product/view', [$p['id']]) }}">
                {{ substr($p['name'], 0, 30) }}{{ strlen($p['name']) > 30 ? '...' : '' }}
            </a>
        </td>
        <td>
            {{ $p['price'] }}
        </td>
        <td>
            {{ $p['qty'] }}
        </td>
        <td>
            <label class="switch">
                <input type="checkbox" class="status" id="{{ $p['id'] }}"
                    {{ $p->status == 1 ? 'checked' : '' }}>
                <span class="slider round"></span>
            </label>
        </td>
        <td>
            <a class="btn btn-primary btn-sm" href="{{ url('admin/product/edit', [$p['id']]) }}">
                <i class="tio-edit"></i>{{ trans('messages.Edit') }}
            </a>
            <a class="btn btn-danger btn-sm" href="javascript:"
                onclick="form_alert('product-{{ $p['id'] }}','Want to delete this item ?')">
                <i class="tio-add-to-trash"></i> {{ trans('messages.Delete') }}
            </a>
            <form action="{{ url('admin/product/delete', [$p['id']]) }}" method="post"
                id="product-{{ $p['id'] }}">
                @csrf @method('delete')
            </form>
        </td>
    </tr>
@endforeach
