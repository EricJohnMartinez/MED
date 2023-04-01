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

            {{-- <div class="container-fluid m-0 p-0">
                <form action="{{ route('orders.index') }}" method="GET">
                    <div class="d-flex w-100">
                        <input value="{{ $query }}" class="form-control w-100" name="query" type="search" placeholder="Search" aria-label="Search">
        
                        <input class="btn btn-outline-success" type="submit"Search/>
                    </div>
                </form>
            </div> --}}

            

            <div class="row">
                <!-- <div class="col-md-3"></div> -->
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
            {{-- <form action="{{ route('orders.index') }}" method="GET">
                <input type="text" name="search" placeholder="Search by order number">
                <button type="submit">Search</button>
            </form> --}}
            
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
                        {{-- @if (auth()->user()->roles == 'pharmacy')
                            <th>Total</th>
                        @endif
                        @if (auth()->user()->roles == 'pharmacy')
                            <th>Received</th>
                        @endif
                        <th>Status</th>
                        @if (auth()->user()->roles == 'pharmacy')
                            <th>Remain.</th>
                        @endif --}}
                        <th>Order Placed</th>
                        <th>Order Completed</th>
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
                            {{-- @if (auth()->user()->roles == 'pharmacy')
                                <td>{{ config('settings.currency_symbol') }} {{ $order->formattedTotal() }}</td>
                            @endif
                            @if (auth()->user()->roles == 'pharmacy')
                                <td>{{ config('settings.currency_symbol') }} {{ $order->formattedReceivedAmount() }}</td>
                            @endif
                            <td>
                                @if ($order->receivedAmount() == 0)
                                    <span class="badge badge-danger">Not Paid</span>
                                @elseif($order->receivedAmount() < $order->total())
                                    <span class="badge badge-warning">Partial</span>
                                @elseif($order->receivedAmount() == $order->total())
                                    <span class="badge badge-success">Paid</span>
                                @elseif($order->receivedAmount() > $order->total())
                                    <span class="badge badge-info">Change</span>
                                @endif
                            </td>
                            @if (auth()->user()->roles == 'pharmacy')
                                <td>{{ config('settings.currency_symbol') }}
                                    {{ number_format($order->total() - $order->receivedAmount(), 2) }}
                                </td>
                            @endif --}}
                            <td>{{ $order->created_at }}</td>
                            <td>{{ $order->updated_at }}</td>
                        </tr>
                    @endforeach
                </tbody>
                {{-- @if (auth()->user()->roles == 'pharmacy')
                    <tfoot>
                        <!-- -->
                        <tr>
                            <th></th>
                            <th></th>
                            <th>{{ config('settings.currency_symbol') }} {{ number_format($total, 2) }}</th>
                            <th>{{ config('settings.currency_symbol') }} {{ number_format($receivedAmount, 2) }}</th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </tfoot>
                @endif --}}

            </table>
            {{ $orders->render() }}
        </div>
    </div><!-- -->

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

            // setInterval(() => {
            //     getCurrentOrderCount()
            //     if (newCount > count) {
            //         if (document.getElementById('alert').classList.contains('d-none')) {
            //             document.getElementById('alert').classList.remove('d-none')
            //         }
            //     } else {
            //         document.getElementById('alert').classList.add('d-none')
            //     }
            // }, 1000);




        }
    </script>
@endsection
