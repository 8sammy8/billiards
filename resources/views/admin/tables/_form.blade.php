<form role="form"
      action="{{ isset($table) ? route('admin.tables.update', $table) : route('admin.tables.store') }}"
      method="POST">
    @csrf
    @isset ($table)
        @method('PUT')
    @endisset

    <div class="card-body">
        <div class="form-group">
            <label for="name">Table</label>
            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                   placeholder="Enter table name"
                   value="{{ old('name', $table->name ?? '') }}">
            @error('name')
                <span class="error invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                <input type="checkbox" name="status" class="custom-control-input" id="status" value="1"
                    {{ old('status') || (isset($table->status) && $table->status) ? 'checked' : '' }}
                >
                <label class="custom-control-label" for="status">Status (Show/Hide) table</label>
            </div>
        </div>

        <div class="col-sm-6">
            <!-- select -->
            <div class="form-group">
                <label>Hall group</label>
                <select class="form-control" name="hall_group_id">
                    @foreach ($hallGroups as $hallGroup)
                        <option value="{{ $hallGroup->id }}"
                        {{ isset($table->hall_group_id) && ($table->hall_group_id === $hallGroup->id ) ? 'selected' : '' }}
                        >{{ $hallGroup->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</form>
