<form role="form"
      action="{{ isset($product) ? route('admin.products.update', $product) : route('admin.products.store') }}"
      method="POST" enctype="multipart/form-data">
    @csrf
    @isset ($product)
        @method('PUT')
    @endisset

    <div class="card-body">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="col-sm-6">
            <div class="form-group">
                <label>@lang('admin.category')</label>
                <select class="form-control" name="category_id">
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ isset($product->category_id) && ($product->category_id === $category->id ) ? 'selected' : '' }}
                        >{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="name">@lang('admin.name')</label>
            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                   placeholder="@lang('admin.enter_product_name')" value="{{ old('name', $product->name ?? '') }}">
            @error('name')
                <span class="error invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="code">@lang('admin.code')</label>
            <input type="number" name="code" id="code" class="form-control @error('code') is-invalid @enderror"
                   placeholder="@lang('admin.enter_product_code')" value="{{ old('code', $product->code ?? '') }}">
            @error('code')
                <span class="error invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="price">@lang('admin.price')</label>
            <input type="number" name="price" id="price" class="form-control @error('price') is-invalid @enderror"
                   placeholder="@lang('admin.enter_product_price')" min="0" step="500" value="{{ old('price', $product->price ?? '') }}">
            @error('price')
                <span class="error invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="purchase_price">@lang('admin.purchase_price')</label>
            <input type="number" name="purchase_price" id="purchase_price" class="form-control @error('purchase_price') is-invalid @enderror"
                   placeholder="@lang('admin.enter_product_purchase_price')" min="0" step="500" value="{{ old('purchase_price', $product->purchase_price ?? '') }}">
            @error('purchase_price')
                <span class="error invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="remainder">@lang('admin.remainder')</label>
            <input type="number" name="remainder" id="remainder" class="form-control @error('remainder') is-invalid @enderror"
                   placeholder="@lang('admin.enter_product_remainder')" min="0" step="1" value="{{ old('remainder', $product->remainder ?? '') }}">
            @error('remainder')
                <span class="error invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                <input type="checkbox" name="status" class="custom-control-input" id="status" value="1"
                    {{ old('status') || (isset($product->status) && $product->status) ? 'checked' : '' }}
                >
                <label class="custom-control-label" for="status">@lang('admin.status_show_hide')</label>
            </div>
        </div>

        @if(isset($product) && !empty($product->img))
            <div id="image">
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">@lang('admin.image')</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <img src="{{ $product->img ? asset($product->img) : '' }}">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-offset-3 col-sm-offset-3 col-md-3 col-sm-3 ">
                        <button type="button" class="btn btn-danger btn-sm" id="image-delete">@lang('admin.remove_image_q')</button>
                    </div>
                </div>
            </div>
        @endif

        <div class="form-group @error('img') is-invalid @enderror">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="img">@lang('admin.upload_image')</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="file" id="img" name="img" class="form-control col-md-7 col-xs-12">
            </div>
            @error('img')
                <span class="error invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary">@lang('admin.save')</button>
    </div>
</form>
