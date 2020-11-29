@extends('layouts.admin')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>All tables</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
            @foreach($hallGroups as $hallGroup)
                @if($hallGroup->tables->count())
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-primary card-outline">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <i class="fas fa-edit"></i>
                                        {{ $hallGroup->name }}
                                    </h3>
                                </div>
                                <div class="card-body pad table-responsive">
                                    @foreach($hallGroup->tables as $table)
                                        <div class="col-md-4 mb-4">
                                            <a href="{{ \Table::getUrl($table, $orders) }}">
                                                <button type="button"
                                                        class="btn btn-block btn-{{ \Table::getCssClass($table, $orders) }} btn-lg"
                                                        data-end-time="{{ \Table::getEndTime($table, $orders) }}"
                                                        data-id="{{ $table->id }}"
                                                        data-name-table="{{ $table->name }}"
                                                >
                                                    {{ $table->name }}
                                                    <span class="" id="timer{{ $table->id }}"></span>
                                                </button>
                                            </a>
                                        </div>
                                    @endforeach

                                </div>
                                <!-- /.card -->
                            </div>
                        </div>
                        <!-- /.col -->
                    </div>
                @endif
            <!-- ./row -->
            @endforeach
        </div><!-- /.container-fluid -->
    </section>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
                var alerted = [];
                $('.btn-block').each(function (i, e) {
                    if ($(e).data('end-time')) {
                        var end_date = new Date($(e).data('end-time'));
                        doCountDown(end_date, i, $(e));

                        alerted[i] = ((end_date.getTime() - new Date().getTime()) > 0) ? true: false;
                        if (!alerted[i]) {
                            showTimeIsOutAlert($(e).data('name-table'))
                        }
                    }
                })

                function doCountDown(target, i, e) {
                    window.setInterval(function () {
                        var left_time = timeDiff(target);
                        if (left_time === '00:00:00' && alerted[i] === false){
                            $(e).hasClass('btn-success') ? $(e).removeClass('btn-success').addClass('btn-danger') : '';
                            alerted[i] = true;
                            showTimeIsOutAlert($(e).data('name-table'))
                        }

                        $('#timer' + $(e).data('id')).text(left_time);
                    }, 1000);

                    var lag = 1020 - (new Date() % 100);
                    setTimeout(function () {
                        doCountDown(target);
                    }, lag);
                }

                function showTimeIsOutAlert(table_name)
                {
                    window.setInterval(function () {
                        toastr.error('Time is out ' + table_name + '!')
                    }, 15000);
                }

                function timeDiff(target) {
                    function z(n) {
                        return (n < 10 ? '0' : '') + n;
                    }

                    var timeDiff = target - (new Date());
                    var hours = Math.abs(timeDiff / 3.6e6 | 0);
                    var minutes = Math.abs(timeDiff % 3.6e6 / 6e4 | 0);
                    var seconds = Math.abs(timeDiff % 6e4 / 1e3 | 0);

                    return z(hours) + ':' + z(minutes) + ':' + z(seconds);
                }
            }
        )
    </script>
@endpush
