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
                Dr. {{ $order->doctor }}
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
        @foreach ($order->items as $item)
            <tr>
                <td>{{ $item->product_name }}</td>
                <td>{{ $item->quantity }}</td>
                <!-- <td class="text-right">{{ $item->price }}</td> -->
                <td class="text-right">{{ number_format($item->price, 2) }}</td>
                <td class="text-right">Php {{ number_format($item->quantity * $item->price, 2) }} </td>
            </tr>
        @endforeach

    </tbody>
</table>
</body>

</html>
