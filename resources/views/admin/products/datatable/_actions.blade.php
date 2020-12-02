<a class="btn btn-info btn-sm"
   href="{{ route('admin.products.edit', $product) }}">
    <i class="fas fa-pencil-alt">
    </i>
    @lang('admin.edit')
</a>
<a class="btn btn-danger btn-sm"
   href="{{ route('admin.products.destroy', $product) }}"
   onclick="event.preventDefault(); document.getElementById('delete-form{{ $product->id }}').submit();">
    <i class="fas fa-trash">
    </i>
    @lang('admin.delete')
</a>
<form id="delete-form{{ $product->id }}"
      action="{{ route('admin.products.destroy', $product) }}"
      method="POST">
    @csrf
    @method('delete')
</form>
