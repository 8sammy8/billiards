@extends('layouts.admin')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Run time for table: {{ $table->name }} </h1>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title"></h3>
                        </div>

                        <form role="form" action="{{ route('admin.order-tables.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="table_id" value="{{ $table->id ?? '' }}">

                            <div class="card">
                                <div class="card-body">

                                    <div class="col-sm-8">
                                        <div class="form-group">
                                            <label>Select rate</label>
                                            <select class="form-control @error('rate_id') is-invalid @enderror" name="rate_id">
                                                @foreach($rates as $rate)
                                                    @if($rate)
                                                        <option value="{{ $rate->id }}">
                                                            {{ $rate->name }}: {{ money($rate->price) }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            @error('rate_id')
                                                <span class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <!-- radio -->
                                        <div class="form-group">
                                            <div class="form-check mb-4">
                                                <input class="form-check-input" type="radio" name="limit"
                                                       id="limit_free" value="{{ config('settings.order_table_limits.LIMIT_FREE') }}" checked >
                                                <label for="limit_free" class="form-check-label">{{ __('admin.order_table_limit_free') }}</label>
                                            </div>

                                            <div class="form-check mb-4">
                                                <input class="form-check-input" type="radio" name="limit"
                                                       id="limit_time" value="{{ config('settings.order_table_limits.LIMIT_TIME') }}"
                                                    {{ old('limit') == config('settings.order_table_limits.LIMIT_TIME') ? 'checked="checked"' : '' }}>
                                                <label for="limit_time" class="form-check-label">{{ __('admin.order_table_limit_time')  }}</label>

                                                <div class="row">
                                                    <div class="col-lg-5">
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text">Hour</span>
                                                            </div>
                                                            <input type="number" name="limit_hour" id="limit_hour" class="form-control
                                                                   @error('limit_hour') is-invalid @enderror"
                                                                   value="{{ old('limit_hour') }}" min="0" max="24" onclick="$('#limit_time').prop('checked', true)">
                                                            @error('limit_hour')
                                                                <span class="error invalid-feedback">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-5">
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text">Min</span>
                                                            </div>
                                                            <input type="number" name="limit_min" id="limit_min" class="form-control
                                                                   @error('limit_min') is-invalid @enderror"
                                                                   value="{{ old('limit_min') }}" min="0" max="59" onclick="$('#limit_time').prop('checked', true)">
                                                            @error('limit_min')
                                                                <span class="error invalid-feedback">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-check mb-4">
                                                <input class="form-check-input" type="radio" name="limit"
                                                       id="limit_price" value="{{ config('settings.order_table_limits.LIMIT_PRICE') }}"
                                                    {{ old('limit') == config('settings.order_table_limits.LIMIT_PRICE') ? 'checked' : '' }}>
                                                <label for="limit_price" class="form-check-label">{{ __('admin.order_table_limit_price') }}</label>

                                                <div class="row">
                                                    <div class="col-lg-8">
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text">Price</span>
                                                            </div>
                                                            <input type="number" name="limit_price" id="limit_price" class="form-control
                                                                    @error('limit_price') is-invalid @enderror"
                                                                   value="{{ old('limit_price') }}" min="1000" step="1000" onclick="$('#limit_price').prop('checked', true)">
                                                            @error('limit_price')
                                                                <span class="error invalid-feedback">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-success">Start</button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
