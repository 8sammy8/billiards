@extends('layouts.admin')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>@lang('admin.hall_groups')</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <a href="{{ route('admin.hall-groups.create') }}">
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
                                    <th>@lang('admin.action')</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($hallGroups as $hallGroup)
                                    <tr>
                                        <td>{{ $hallGroup->id }}</td>
                                        <td>{{ $hallGroup->name }}</td>
                                        <td>
                                            <a class="btn btn-info btn-sm" href="{{ route('admin.hall-groups.edit', $hallGroup) }}">
                                                <i class="fas fa-pencil-alt">
                                                </i>
                                                @lang('admin.edit')
                                            </a>
                                            <a class="btn btn-danger btn-sm" href="{{ route('admin.hall-groups.destroy', $hallGroup) }}"
                                               onclick="event.preventDefault(); document.getElementById('delete-form{{ $hallGroup->id }}').submit();">
                                                <i class="fas fa-trash">
                                                </i>
                                                @lang('admin.delete')
                                            </a>
                                            <form id="delete-form{{ $hallGroup->id }}" action="{{ route('admin.hall-groups.destroy', $hallGroup) }}" method="POST">
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
