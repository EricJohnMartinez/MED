<!DOCTYPE html>
<html>

<head>
    <title>Receipt of {{ $order->name }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        .total {
            font-weight: bold;
        }

        .text-right {
            text-align: right;
        }
    </style>
</head>

<body>
    
    <div>
        <p><strong>Receipt Details:</strong></p>
        <p>Name: {{ $order->name }}</p>
        <p>Room Number: @if ($order->room_number)
                #{{ $order->room_number }}
            @else
                N/A
            @endempty</p>
        <p>Doctor: @if ($order->doctor)
                {{ $order->doctor }}
            @else
                N/A
            @endempty
        </p>
        <p>Nurse: @if ($order->nurse)
                {{ $order->nurse }}
            @else
                N/A
            @endempty</p>
        <p>Date and Time: {{ Carbon\Carbon::parse($order->created_at)->format('h:m a M d, Y ') }}</p>
    </div>
    <table>
        <thead>
            <tr>
                <th>Item</th>
                <th>Quantity</th>
                <th class="text-right">Price</th>
                <th class="text-right">Total</th>
            </tr>
        </thead>
        <tbody>
            @php
                $grand_total = 0; // initialize the grand total to zero
            @endphp
            @foreach ($order->items as $item)
                @php
                    $item_total = $item->quantity * $item->price; // calculate the total price for the item
                    $grand_total += $item_total; // add the item total to the grand total
                @endphp
                <tr>
                    <td>{{ $item->product_name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td class="text-right">{{ number_format($item->price, 2) }}</td>
                    <td class="text-right">Php {{ number_format($item_total, 2) }} </td>
                </tr>
            @endforeach
            <tr>
                <td colspan="3" class="text-right total">Grand Total:</td>
                <td class="text-right total">Php {{ number_format($grand_total, 2) }}</td>
            </tr>
        </tbody>
    </table>
</body>

</html>