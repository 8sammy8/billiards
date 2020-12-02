@extends('layouts.admin')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>@lang('admin.rates')</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <a href="{{ route('admin.rates.create') }}">
                                    <button type="button" class="btn btn-block btn-primary btn-sm">
                                        <i class="fas fa-plus"></i>
                                        @lang('admin.create')
                                    </button>
                                </a>
                            </h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>@lang('admin.id')</th>
                                    <th>@lang('admin.name')</th>
                                    <th>@lang('admin.price')</th>
                                    <th>@lang('admin.start_time')</th>
                                    <th>@lang('admin.end_time')</th>
                                    <th>@lang('admin.hall_group')</th>
                                    <th>@lang('admin.action')</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($rates as $rate)
                                    <tr>
                                        <td>{{ $rate->id }}</td>
                                        <td>{{ $rate->name }}</td>
                                        <td>{{ money($rate->price) }}</td>
                                        <td>{{ $rate->start_at->format('H:i') }}</td>
                                        <td>{{ $rate->end_at->format('H:i') }}</td>
                                        <td>{{ $rate->hallGroup->name }}</td>
                                        <td>
                                            <a class="btn btn-info btn-sm" href="{{ route('admin.rates.edit', $rate) }}">
                                                <i class="fas fa-pencil-alt">
                                                </i>
                                                @lang('admin.edit')
                                            </a>
                                            <a class="btn btn-danger btn-sm" href="{{ route('admin.rates.destroy', $rate) }}"
                                               onclick="event.preventDefault(); document.getElementById('delete-form{{ $rate->id }}').submit();">
                                                <i class="fas fa-trash">
                                                </i>
                                                @lang('admin.delete')
                                            </a>
                                            <form id="delete-form{{ $rate->id }}" action="{{ route('admin.rates.destroy', $rate) }}" method="POST">
                                                @csrf
                                                @method('delete')
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>

                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
