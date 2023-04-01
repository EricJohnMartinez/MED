@extends('layouts.admin')

@section('title', 'Patient Info')

@section('content')
    <form action="{{ route('customers.update', $customer) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">

                <li class="breadcrumb-item "><a href="#info">Patient Info</a></li>
                <li class="breadcrumb-item "><a href="#history">Medication Summarys</a></li>
            </ol>
        </nav>

        <div class="card" >
            
            <div class="card-body"  id="info">
                <div class="row">
                    <div class="col-md-12">

                    <table class="table table-bordered table-hover">
                <thead class="thead-dark">

                </thead>
                <tbody>
                
                    <tr>Patient Name:    </tr><tr>   <h4 id="info" class="mb-2">      {{$customer->first_name}} {{$customer->last_name}}</h4></tr>
                    <tr>Nickname:        </tr><tr>    <h4 id="info" class="mb-2">     {{$customer->nickname}}</h4></tr>
                    <tr>Doctor's Name:   </tr><tr>     <h4 id="info" class="mb-2">   {{$customer->doctor_name}}</h4></tr>
                    <tr>Nurse on Duty:   </tr><tr>      <h4 id="info" class="mb-2">   {{$customer->name_of_nurse}}</h4></tr>
                    <tr>Room Number:     </tr><tr>      <h4 id="info" class="mb-2">   {{$customer->room_number}}</h4></tr>
                    <tr>Email:           </tr><tr>      <h4 id="info" class="mb-2">   {{$customer->email}}</h4></tr>
                    <tr>Date of Birth:   </tr><tr>      <h4 id="info" class="mb-2">   {{$customer->date_of_birth}}</h4></tr>
                    <tr>Sex:              </tr><tr>      <h4 id="info" class="mb-2">  {{$customer->sex}}</h4></tr>
                    <tr>Height:              </tr><tr>      <h4 id="info" class="mb-2">  {{$customer->height}}</h4></tr>
                    <tr>Weight:              </tr><tr>      <h4 id="info" class="mb-2">  {{$customer->weight}}</h4></tr>
                    <tr>Marital Status:  </tr><tr>      <h4 id="info" class="mb-2">   {{$customer->marital_status}}</h4></tr>
                    <tr>Philhealth:      </tr><tr>       <h4 id="info" class="mb-2">  {{$customer->philhealth}}</h4></tr>
                    <tr>Contact Number:   </tr><tr>      <h4 id="info" class="mb-2">  {{$customer->phone}}</h4></tr>
                    <tr>Address:           </tr><tr>     <h4 id="info" class="mb-2">  {{$customer->address}}</h4></tr>
                    <tr>In case of emergency:</tr><tr>   <h4 id="info" class="mb-2"> {{$customer->emergency}}</h4></tr>
                
            </tbody>
                </table>
</div>
<div class="col-md-12" id="history">
    <br>
<table class="table table-bordered table-hover">
    <h1>Medication Summary</h1>
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Patient</th>
                        <th>Nurse on-Duty</th>
                      
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
              

            </table>
</div>
         
                </div>
<!-- 
                @foreach ($orders as $order)

                <a target="_blank" href="{{ route('order.viewReceipt', $order->id) }}">
                                        {{ $order->getCustomerName() }}
                                    </a>
                @endforeach -->
                

                
    
@endsection

@section('js')
    <script src="{{ asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            bsCustomFileInput.init();
        });
    </script>
@endsection
