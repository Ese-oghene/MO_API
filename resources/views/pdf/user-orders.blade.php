<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>User Orders PDF</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            color: #333;
        }

        header {
            display: flex;
            align-items: center;
            border-bottom: 1px solid #ccc;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        header img {
            height: 60px;
            margin-right: 20px;
        }

        h1 {
            margin: 0;
        }

        .order {
            margin-bottom: 30px;
            border-bottom: 1px solid #eee;
            padding-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table, th, td {
            border: 1px solid #aaa;
        }

        th, td {
            padding: 8px;
            text-align: left;
        }

        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 10px;
            color: #888;
        }
    </style>
</head>
<body>

<header>
    <img src="{{ public_path('logo.png') }}" alt="Logo">
    <h1>Order Summary for {{ $user->name }}</h1>
</header>

@foreach ($orders as $order)
    <div class="order">
        <strong>Order ID:</strong> {{ $order->id }}<br>
        <strong>Status:</strong> {{ $order->status }}<br>
        <strong>Total:</strong> ₦{{ number_format($order->total, 2) }}<br>
        <strong>Date:</strong> {{ $order->created_at->format('d M, Y') }}

        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Qty</th>
                    <th>Price (₦)</th>
                    <th>Subtotal (₦)</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->orderItems as $item)
                    <tr>
                        <td>{{ $item->product->name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ number_format($item->price, 2) }}</td>
                        <td>{{ number_format($item->price * $item->quantity, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endforeach

<div class="footer">
    &copy; {{ now()->year }} MO Signitory. All rights reserved.
</div>

</body>
</html>
