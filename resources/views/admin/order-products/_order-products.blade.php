@if($products->isNotEmpty())
    @foreach($products as $product)
        <tr>
            <td>{{ $product->code }}</td>
            <td>{{ $product->name }}</td>
            <td><img height="50%" src="{{ $product->img ? asset($product->img) : '' }}"/></td>
            <td>
                <select class="form-control" name="product_id[{{ $product->id }}]">
                    @foreach (range(1, $product->remainder, 1) as $quantity)
                        <option value="{{ $quantity }}">{{ $quantity }}</option>
                    @endforeach
                </select>
            </td>
            <td>{{ money($product->price) }}</td>
            <td>
                <button class="btn btn-success"
                        data-product-id="{{ $product->id }}"
                        data-product-code="{{ $product->code }}"
                        data-product-name="{{ $product->name }}"
                        data-product-price="{{ $product->price }}"
                        data-product-img="{{ $product->img ? asset($product->img) : '' }}"
                >
                    <i class="fas fa-plus"></i>
                    @lang('admin.add')
                </button>
            </td>
        </tr>
    @endforeach
@endif
