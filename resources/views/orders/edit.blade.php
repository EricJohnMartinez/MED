@extends('layouts.admin')

@section('title', 'Orders List')
@section('content-header', 'Order List')
@section('content-actions')
    @if (Auth::user()->roles == 'admin')
        <a href="{{ route('cart.index') }}" class="btn btn-success">Place Order</a>
    @endif
@endsection

@section('content')
    <div class="card">
        <!-- -->
        <div class="card-body">
            <div id="alert" class="alert alert-primary d-none" role="alert">
                New order added. Click here to
                <a class="text-primary" href="javascript:window.location.href=window.location.href">reload </a>
            </div>

            <div class="row">
                
                <div class="col-md-12">
                    <form action="{{ route('orders.index') }}">
                        <div class="row">
                            <div class="col-md-5">
                                <input type="date" name="start_date" class="form-control"
                                    value="{{ request('start_date') }}" />
                            </div>
                            <div class="col-md-5">
                                <input type="date" name="end_date" class="form-control"
                                    value="{{ request('end_date') }}" />
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-primary" type="submit"><i class="fas fa-filter"></i> Filter</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <hr>
       
            
            @if (auth()->user()->roles == 'pharmacy')
            @endif

            <div class="container-fluid m-0 p-0">
                <form action="{{ route('orders.index') }}" method="GET">
                    <p>
                        Station Numbers
                    </p>
                    <div class="d-flex w-100">

                        <select name="station" class="custom-select">
                            <option @if (empty($station) || $station == '1') selected="selected" @endif value="1">One</option>
                            <option @if ($station == '2') selected="selected" @endif value="2">Two</option>
                            <option @if ($station == '3') selected="selected" @endif value="3">Three
                            </option>
                            <option @if ($station == '4') selected="selected" @endif value="4">Four
                            </option>
                            <option @if ($station == '5') selected="selected" @endif value="5">Five
                            </option>
                            <option @if ($station == '6') selected="selected" @endif value="6">Six
                            </option>
                        </select>

                        <input class="btn btn-outline-success" type="submit"Search />
                    </div>
                </form>
            </div>

            <div class="container-fluid m-0 p-0">
                <form action="{{ route('orders.index') }}" method="GET">
                    <div class="d-flex w-100">
                        <input class="form-control w-100" name="search" type="search" placeholder="Search ID" aria-label="Search">
        
                        <input class="btn btn-outline-success" type="submit"Search/>
                    </div>
                </form>
            </div>



            <table class="table table-bordered table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Patient</th>
                        <th>Nurse on-Duty</th>
                      
                        <th>Order Placed</th>
                        <th>Order Completed</th>
                        @if (auth()->user()->roles == 'admin')
                        <th>Action</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr>
                            <td>{{ $order->customer_id }}</td>
                            <td>
                                @if ($order->customer)
                                    <a target="_blank" href="{{ route('order.viewReceipt', $order->id) }}">
                                        {{ $order->getCustomerName() }}
                                    </a>
                                @else
                                    Walk-in Customer
                                @endif
                            </td>
                            <td>{{ $order->nurse ?? 'N\A' }}</td>
                           
                            <td>{{ $order->created_at }}</td>
                            <td>{{ $order->updated_at }}</td>
                        
                            @if (auth()->user()->roles == 'admin')
                            
                            <td>
                               
                                <a href="{{ route('orders.edit', $order) }}" class="btn btn-primary"><i
                                    class="fas fa-edit"></i></a>

                                <button class="btn btn-danger btn-delete"
                                data-url="{{ route('orders.destroy', $order) }}"><i
                                    class="fas fa-trash"></i></button></td>
                            @endif
                            
                        </tr>
                    @endforeach
                </tbody>
        

            </table>
            {{ $orders->render() }}
        </div>
    </div>

    <script>
        window.onload = (event) => {
            let loaded = false
            let count = null
            let newCount = null

            async function getCurrentOrderCount() {

                const res = await fetch('/order-count', {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json'
                    }
                });


                const data = await res.json();

                if (loaded == false) {
                    count = data.count
                }

                if (loaded == false && count != null) {
                    newCount = data.count
                }

                loaded = true

            }


        }
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
                    text: "Do you really want to delete this Order?",
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
    </script>
@endsection



