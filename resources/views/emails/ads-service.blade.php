<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin dịch vụ của bạn</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            padding-bottom: 20px;
        }
        .header h1 {
            font-size: 24px;
            color: #4CAF50;
        }
        .order-details {
            margin-bottom: 20px;
        }
        .order-details h2 {
            font-size: 20px;
            color: #333;
        }
        .order-details p {
            margin: 5px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table th, table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        table th {
            background-color: #f4f4f4;
        }
        .total {
            text-align: right;
            font-size: 18px;
            margin-bottom: 20px;
        }
        .footer {
            text-align: center;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Cảm ơn bạn đã thuê dịch vụ!</h1>
        </div>

        <div class="order-details">
            <h2>Thông tin dịch vụ:</h2>
            <p><strong>Mã dịch vụ:</strong> {{ $ads->id }}</p>
            <p><strong>Tên người mua:</strong> {{ $ads->name }}</p>
            <p><strong>Email:</strong> {{ $ads->email }}</p>
            <p><strong>Số điện thoại:</strong> {{ $ads->phone }}</p>
            <p><strong>Thời hạn:</strong> Từ {{ $ads->start }} đến {{ $ads->end }}</p>
        </div>
        <div class="total">
            <p><strong>Tổng cộng: {{ number_format($ads->price, 0, ',', '.') }} đ</strong></p>
        </div>

        <div class="footer">
            <p>Nếu bạn có bất kỳ câu hỏi nào về đơn hàng, vui lòng liên hệ với chúng tôi qua email <a href="{{config('mail.from.address')}}">{{config('mail.from.address')}}</a>.</p>
            <p>Cảm ơn bạn đã mua sắm tại cửa hàng của chúng tôi!</p>
        </div>
    </div>
</body>
</html>
