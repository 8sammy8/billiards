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
                <label>Choose product category</label>
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
            <label for="name">Product name</label>
            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                   placeholder="Enter product name" value="{{ old('name', $product->name ?? '') }}">
            @error('name')
                <span class="error invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="code">Code</label>
            <input type="number" name="code" id="code" class="form-control @error('code') is-invalid @enderror"
                   placeholder="Enter product code" value="{{ old('code', $product->code ?? '') }}">
            @error('code')
                <span class="error invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="price">Price</label>
            <input type="number" name="price" id="price" class="form-control @error('price') is-invalid @enderror"
                   placeholder="Enter product price" min="0" step="500" value="{{ old('price', $product->price ?? '') }}">
            @error('price')
                <span class="error invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="purchase_price">Purchase price</label>
            <input type="number" name="purchase_price" id="purchase_price" class="form-control @error('purchase_price') is-invalid @enderror"
                   placeholder="Enter purchase price" min="0" step="500" value="{{ old('purchase_price', $product->purchase_price ?? '') }}">
            @error('purchase_price')
                <span class="error invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="remainder">Remainder</label>
            <input type="number" name="remainder" id="remainder" class="form-control @error('remainder') is-invalid @enderror"
                   placeholder="Enter remainder" min="0" step="1" value="{{ old('remainder', $product->remainder ?? '') }}">
            @error('remainder')
                <span class="error invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                <input type="checkbox" name="status" class="custom-control-input" id="status" value="1"
                    {{ old('status') || (isset($product->status) && $product->status) ? 'checked' : '' }}
                >
                <label class="custom-control-label" for="status">Status (Show/Hide) product</label>
            </div>
        </div>

        @if(isset($product) && !empty($product->img))
            <div id="image">
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Image</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <img src="{{ $product->img ? asset($product->img) : '' }}">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-offset-3 col-sm-offset-3 col-md-3 col-sm-3 ">
                        <button type="button" class="btn btn-danger btn-sm" id="image-delete">Remove image</button>
                    </div>
                </div>
            </div>
        @endif

        <div class="form-group @error('img') is-invalid @enderror">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="img">Upload image</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="file" id="img" name="img" class="form-control col-md-7 col-xs-12">
            </div>
            @error('img')
                <span class="error invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</form>
