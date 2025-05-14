<!-- resources/views/admin/invoice.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Invoice #{{ $order->id }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        .invoice-header { margin-bottom: 20px; }
        .invoice-info { margin-bottom: 30px; }
        .table { width: 100%; border-collapse: collapse; }
        .table th, .table td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        .table th { background-color: #f2f2f2; }
        .text-right { text-align: right; }
        .mt-4 { margin-top: 16px; }
        .mb-4 { margin-bottom: 16px; }
    </style>
</head>
<body>
    <div class="invoice-header">
        <h1>Invoice #{{ $order->id }}</h1>
        <p>Date: {{ $order->created_at->format('M d, Y') }}</p>
    </div>
    
    <div class="invoice-info">
        <div style="float: left; width: 50%;">
            <h3>Billed To:</h3>
            <p>{{ $order->name }}<br>
            {{ $order->address }}<br>
            {{ $order->city }}, {{ $order->zip }}</p>
        </div>
        <div style="float: right; width: 50%; text-align: right;">
            <h3>Payment Method:</h3>
            <p>{{ strtoupper($order->payment_method) }}<br>
            Status: {{ ucfirst($order->payment_status) }}<br>
            @if($order->transaction_id)
            Transaction ID: {{ $order->transaction_id }}
            @endif</p>
        </div>
        <div style="clear: both;"></div>
    </div>
    
    <table class="table">
        <thead>
            <tr>
                <th>Product</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
            <tr>
                <td>{{ $item->product->name }}</td>
                <td>${{ number_format($item->price, 2) }}</td>
                <td>{{ $item->quantity }}</td>
                <td>${{ number_format($item->price * $item->quantity, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" class="text-right">Subtotal</td>
                <td>${{ number_format($order->total, 2) }}</td>
            </tr>
            <tr>
                <td colspan="3" class="text-right">Shipping</td>
                <td>$0.00</td>
            </tr>
            <tr>
                <td colspan="3" class="text-right">Total</td>
                <td>${{ number_format($order->total, 2) }}</td>
            </tr>
        </tfoot>
    </table>
    
    <div class="mt-4">
        <p>Thank you for your business!</p>
    </div>
</body>
</html>