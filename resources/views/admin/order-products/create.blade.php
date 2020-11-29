@extends('layouts.admin')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1> {{ isset($order->table) ? 'Add product to ' . $order->table->name : 'Create order' }}</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Products</h3>
                        </div>
                        <div class="card-body">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Choose product category</label>
                                    <select class="form-control" name="category_id" id="category">
                                        <option value="" selected>Select</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ isset($product->category_id) && ($product->category_id === $category->id ) ? 'selected' : '' }}
                                            >{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <table class="table table-bordered table-hover text-center">
                                <thead>
                                <tr>
                                    <th>Product code</th>
                                    <th>Product name</th>
                                    <th>Image</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody id="products-body">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Cart</h3>
                        </div>
                            @include('admin.order-products._form')
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="{{ asset('money.js') }}"></script>
    <script>
        $(document).ready(function () {
            var products_body = $('#products-body');
            var cart_body = $('#cart-body');
            var cart_products = [];
            var order_table_url = '{{ isset($order->table) ? route('admin.order-tables.show', $order->id) : false }}';
            var order_products_url = '{{ route('admin.order-products.index') }}';

            $('#category').on('change', function () {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "GET",
                    url: "{{ route('admin.order-products.create') }}",
                    data: {'category_id': $(this).val()},
                    success: function (data) {
                        products_body.html(data);
                        initSelectsAdd();
                    }
                }).fail (function () {
                    products_body.empty();
                });
            });

            function initSelectsAdd() {
                products_body.find('.btn-success').each(function (i, e) {
                    $(e).click(function () {
                        addToCart($(this))
                    })
                })
            }
            function addToCart(elem) {
                var e = $(elem);
                var e_id = e.data('product-id');
                var e_code = e.data('product-code');
                var e_name = e.data('product-name');
                var e_price = e.data('product-price');
                var e_img = e.data('product-img');
                var e_select_val = parseInt(products_body.find('select[name="product_id[' + e_id +']"]').val());

                var cart_table_tr = "<tr>\n" +
                    "            <td>" + e_code + "</td>\n" +
                    "            <td>" + e_name + "</td>\n" +
                    "            <td><img height=\"50%\" src=\"" + e_img + "\"/></td>\n" +
                    "            <td>\n" + e_select_val +
                    "            </td>\n" +
                    "            <td>\n" + moneyFormat(e_select_val * e_price) +
                    "            </td>\n" +
                    "            <td>\n" +
                    "                <button class=\"btn btn-danger\"\n" +
                    "                        data-product-id=\""+ e_id +"\"\n" +
                    "                        data-product-quantity=\""+ e_select_val +"\"\n" +
                    "                >\n" +
                    "                    <i class=\"fas fa-minus\"></i>\n" +
                    "                    Remove \n" +
                    "                </button>\n" +
                    "            </td>\n" +
                    "        </tr>";

                cart_body.prepend(cart_table_tr);
                initSelectsRemove();

                var plused = cart_products.find(function (item) {
                    if (item.id === e_id) {
                        return item.quantity = item.quantity + e_select_val
                    }
                })
                if (!plused) {
                    cart_products.push({
                        'id' : e_id,
                        'quantity' : e_select_val
                    })
                }
            }

            function initSelectsRemove() {
                cart_body.find('.btn-danger').each(function (i, e) {
                    var ev_click = $._data($(e).get(0), 'events');

                    if(ev_click === undefined || ev_click.click === undefined)
                    {
                        $(e).bind("click", function () {
                            removeFromCart($(e))
                        })
                    }
                })
            }
            function removeFromCart(elem) {
                var pr_id = parseInt($(elem).data('product-id'))
                var pr_qt = parseInt($(elem).data('product-quantity'));

                cart_products.find(function (item, index) {

                    if (item && item.id === pr_id) {
                        if(item.quantity === pr_qt){
                            cart_products.splice(index, 1)
                        }else{
                            item.quantity = item.quantity - pr_qt
                        }
                    }
                })
                $(elem).parent().parent().remove()
            }

            $('#checkout').click(function () {
                if(cart_products.length === 0) {
                    return toastr.error('Please add product to cart!')
                }

                var order_id = '{{ $order->id ?? '' }}';

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    url: "{{ route('admin.order-products.store') }}",
                    data: {
                        'order_id': order_id,
                        'products': cart_products
                    },
                    success: function (data) {
                        window.location.href = (order_id && order_table_url) ? order_table_url : order_products_url
                    }
                }).fail (function () {
                    toastr.error(data.message)
                    console.log('error')
                });
            })
        })
    </script>
@endpush
