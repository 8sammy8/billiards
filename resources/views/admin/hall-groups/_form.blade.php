<form role="form"
      action="{{ isset($hallGroup) ? route('admin.hall-groups.update', $hallGroup) : route('admin.hall-groups.store') }}"
      method="POST">
    @csrf
    @isset ($hallGroup)
        @method('PUT')
    @endisset

    <div class="card-body">
        <div class="form-group">
            <label for="name">Hall Group</label>
            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                   placeholder="Enter hall group name"
                   value="{{ old('name', $hallGroup->name ?? '') }}">
            @error('name')
                <span class="error invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</form>
