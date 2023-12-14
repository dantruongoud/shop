<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>{{ $data['subject'] }}</h1>
    <p>Người đặt hàng: {{ $data['name'] }}</p>
    <p>Địa chỉ: {{ $data['address'] }}</p>
    <p>Số điện thoại: {{ $data['phone'] }}</p>
    <p>Tổng số tiền thanh toán: {{ $data['total'] }}</p>
    <p>Tổng số lượng đặt hàng: {{ $data['Quantity'] }}</p>
    <p>Thông tin giỏ hàng:</p>
    <ul>
        
        @foreach ($Product as $item)
            <li>
                {{ $item['product']->name }} - Quantity: {{ $item['qty'] }} - Price: {{ $item['product']->price }}
            </li>
        @endforeach
    </ul>
</body>
</html>