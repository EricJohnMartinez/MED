@extends('layouts.admin')

@section('title', 'Product Management')
@section('content-header', 'Product Management')
@section('content-actions')
    @if (Auth::user()->roles == 'pharmacy')
        <a href="{{ route('products.create') }}" class="btn btn-success"><i class="fas fa-plus"></i> Add New Product</a>
    @endif
    @if (Auth::user()->roles == 'admin')
    <a href="{{ route('products.create') }}" class="btn btn-success"><i class="fas fa-plus"></i> Add New Product</a>
@endif
@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('plugins/sweetalert2/sweetalert2.min.css') }}">
@endsection
@section('content')

    <div class="container-fluid m-0 p-0">
        <form action="{{ route('products.index') }}" method="GET">
            <div class="d-flex w-100">
                <input value="{{ $query }}" class="form-control w-100" name="query" type="search"
                    placeholder="Search Product Code / Name of Drug" aria-label="Search">

                <input class="btn btn-outline-success" type="submit"Search />
            </div>
        </form>
    </div>

    <div class="card product-list">
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead class="thead-dark">
                    <tr>
                        <!-- -->
                        <th>Product Code</th>
                        <th>Brand Name</th>
                        <th>Dosage/Frequency</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Medicine Type</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <td>{{ $product->barcode }}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->dosage }}</td>
                            <td>{{ $product->quantity }} </td>
                            <td>{{ config('settings.currency_symbol') }}{{ $product->price }}</td>
                            <td>{{ $product->medicinetype }}</td>
                            <td>
                                @if ($product->quantity <= 0)
                                <span class="right badge badge-{{ $product->status ? 'danger' : 'danger' }}"> {{ $product->status ? 'Inactive' : 'Inactive' }} </span>
                                @else
                                <span class="right badge badge-{{ $product->status ? 'success' : 'danger' }}"> {{ $product->status ? 'Active' : 'Inactive' }} </span>          
                                @endif
                            </td>
                            <td>{{ $product->created_at }}</td>
                            <td>{{ $product->updated_at }}</td>
                            @if (Auth::user()->roles == 'pharmacy')
                                <td>
                                    <a href="{{ route('products.edit', $product) }}" class="btn btn-primary"><i
                                            class="fas fa-edit"></i></a>
                                    <button class="btn btn-danger btn-delete"
                                        data-url="{{ route('products.destroy', $product) }}"><i
                                            class="fas fa-trash"></i></button>
                                </td>
                                
                            @endif

                            @if (Auth::user()->roles == 'admin')
                            <td>
                                <a href="{{ route('products.edit', $product) }}" class="btn btn-primary"><i
                                        class="fas fa-edit"></i></a>
                                <button class="btn btn-danger btn-delete"
                                    data-url="{{ route('products.destroy', $product) }}"><i
                                        class="fas fa-trash"></i></button>
                            </td>
                            
                        @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
            
        </div>
    </div><!-- -->
@endsection

@section('js')
    <script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $(document).on('click', '.btn-delete', function() {
                $this = $(this);
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                    title: 'Are you sure?',
                    text: "Do you really want to delete this product?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No',
                    reverseButtons: true
                }).then((result) => {
                    if (result.value) {
                        $.post($this.data('url'), {
                            _method: 'DELETE',
                            _token: '{{ csrf_token() }}'
                        }, function(res) {
                            $this.closest('tr').fadeOut(500, function() {
                                $(this).remove();
                            })
                        })
                    }
                })
            })
        })
    </script>
@endsection
