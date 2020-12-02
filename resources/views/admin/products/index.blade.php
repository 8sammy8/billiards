@extends('layouts.admin')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>@lang('admin.products')</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    @if ($errors->all())
        @dd($errors->all())
    @endif
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <a href="{{ route('admin.products.create') }}">
                                    <button type="button" class="btn btn-block btn-primary btn-sm">
                                        <i class="fas fa-plus"></i>
                                        @lang('admin.create')
                                    </button>
                                </a>
                            </h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                                <div class="row">

                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table id="example1"
                                               class="table table-bordered table-striped dataTable dtr-inline"
                                               role="grid" aria-describedby="example1_info">
                                            <thead>
                                                <tr role="row">
                                                    <th>@lang('admin.id')</th>
                                                    <th>@lang('admin.category')</th>
                                                    <th>@lang('admin.name')</th>
                                                    <th>@lang('admin.code')</th>
                                                    <th>@lang('admin.price')</th>
                                                    <th>@lang('admin.purchase_price')</th>
                                                    <th>@lang('admin.remainder')</th>
                                                    <th>@lang('admin.status')</th>
                                                    <th>@lang('admin.image')</th>
                                                    <th>@lang('admin.updated_time')</th>
                                                    <th>@lang('admin.action')</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
                <!-- /.col -->
            </div>


            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection

@push('styles')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('vendor/admin-lte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/admin-lte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
@endpush
@push('scripts')
    <!-- DataTables -->
    <script src="{{ asset('vendor/admin-lte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/admin-lte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script
        src="{{ asset('vendor/admin-lte/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script
        src="{{ asset('vendor/admin-lte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>

    <script>
        $(document).ready( function () {
            $('#example1').DataTable({
                    "processing" : true,
                    "serverSide" : true,
                    "ajax" : "{{ route('admin.products.index') }}",
                    "columns" : [
                        {data: "id"},
                        {data: "category", name: "category.name"},
                        {data: "name"},
                        {data: "code"},
                        {data: "price"},
                        {data: "purchase_price"},
                        {data: "remainder"},
                        {data: "status"},
                        {data: "img", orderable: false, searchable: false},
                        {data: "updated_at"},
                        {data: "actions", orderable: false, searchable: false}
                    ],
                });
            })
    </script>
@endpush
