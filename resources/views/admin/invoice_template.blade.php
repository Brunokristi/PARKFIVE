<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice</title>
</head>
<body>
    <h1>Faktúra č. {{ $variable_symbol }}</h1>
    <h2>Supplier</h2>
    <p>{{ $supplier_name }}</p>
    <p>{{ $supplier_address }}</p>

    <h2>Customer</h2>
    <p>{{ $customer_name }}</p>
    <p>{{ $customer_address }}</p>

    <h2>Items</h2>
    <table>
        <thead>
            <tr>
                <th>Description</th>
                <th>Quantity</th>
                <th>Unit Price</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($items as $item)
            <tr>
                <td>{{ $item['description'] }}</td>
                <td>{{ $item['quantity'] }}</td>
                <td>{{ $item['unit_price'] }}</td>
                <td>{{ $item['total'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h2>Total</h2>
    <p>€{{ $total }}</p>

    <h2>QR Code</h2>
    <img src="{{ $qr_code }}" alt="QR Code">
</body>
</html>
