@extends('layouts.admin')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Product edit</h1>
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
                        @include('admin.products._form')
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@if(isset($product) && !empty($product->img))
    @push('scripts')
        <script>
            $(function () {
                $('#image-delete').click(function () {
                    if (!confirm('Remove image?')) return;

                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: '{{ route('admin.products.image.delete', $product->id) }}',
                        type: 'post',
                        dataType: 'json'
                    }).done(function (data) {
                        $('#image').remove();
                    }).fail(function (data) {
                        alert('Error to remove image, please try again after reload page!')
                    });
                });
            });
        </script>
    @endpush
@endif
