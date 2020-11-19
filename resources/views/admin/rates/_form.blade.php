<form role="form"
      action="{{ isset($rate) ? route('admin.rates.update', $rate) : route('admin.rates.store') }}"
      method="POST">
    @csrf
    @isset ($rate)
        @method('PUT')
    @endisset

    <div class="card-body">
        <div class="form-group">
            <label for="name">Rate</label>
            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                   placeholder="Enter rate name" value="{{ old('name', $rate->name ?? '') }}">
            @error('name')
                <span class="error invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="price">Price</label>
            <input type="number" name="price" id="price" class="form-control @error('price') is-invalid @enderror"
                   placeholder="Enter rate price" min="0" step="1000" value="{{ old('price', $rate->price ?? '') }}">
            @error('price')
            <span class="error invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <div class="row">
            <div class="col-sm-4">
                <div class="form-group">
                    <label>Start time</label>
                    <select class="form-control" name="start_at">
                        @foreach(HI_time() as $time)
                            <option value="{{ $time }}"
                                {{ isset($rate) && $rate->start_at === $time ? 'selected' : '' }}>{{ $time }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="form-group">
                    <label>End time</label>
                    <select class="form-control" name="end_at">
                        @foreach(HI_time() as $time)
                            <option value="{{ $time }}"
                                {{ isset($rate) && $rate->end_at === $time ? 'selected' : '' }}>{{ $time }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="form-group">
                <label>Hall group</label>
                <select class="form-control" name="hall_group_id">
                    @foreach ($hallGroups as $hallGroup)
                        <option value="{{ $hallGroup->id }}"
                        {{ isset($rate->hall_group_id) && ($rate->hall_group_id === $hallGroup->id ) ? 'selected' : '' }}
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
