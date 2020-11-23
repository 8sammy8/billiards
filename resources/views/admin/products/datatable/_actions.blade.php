<a class="btn btn-info btn-sm"
   href="{{ route('admin.products.edit', $product) }}">
    <i class="fas fa-pencil-alt">
    </i>
    Edit
</a>
<a class="btn btn-danger btn-sm"
   href="{{ route('admin.products.destroy', $product) }}"
   onclick="event.preventDefault(); document.getElementById('delete-form{{ $product->id }}').submit();">
    <i class="fas fa-trash">
    </i>
    Delete
</a>
<form id="delete-form{{ $product->id }}"
      action="{{ route('admin.products.destroy', $product) }}"
      method="POST">
    @csrf
    @method('delete')
</form>
