<form role="form"
      action="{{ isset($category) ? route('admin.categories.update', $category) : route('admin.categories.store') }}"
      method="POST">
    @csrf
    @isset ($category)
        @method('PUT')
    @endisset

    <div class="card-body">
        <div class="form-group">
            <label for="name">Category</label>
            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                   placeholder="Enter category name"
                   value="{{ old('name', $category->name ?? '') }}">
            @error('name')
                <span class="error invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                <input type="checkbox" name="status" class="custom-control-input" id="status" value="1"
                    {{ old('status') || (isset($category->status) && $category->status) ? 'checked' : '' }}
                >
                <label class="custom-control-label" for="status">Status (Block/Active) category</label>
            </div>
        </div>

    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</form>
