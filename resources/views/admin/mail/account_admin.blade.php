<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Thông tin tài khoản quản trị của bạn</title>
</head>
<body>
Chào <b>{{ $admin['full_name'] }}</b>
<p>Dưới đây là thông tin tài khoản quản trị của bạn</p>
<p>Email: {{ $admin['email'] }}</p>
<p>Mật khẩu: {{ $password }}</p>
<p>Bạn truy cập đường dẫn sau để đăng nhập vào trang quản trị: <a href="{{ route('dashboard.index') }}">Tại đây</a></p>
</body>
</html>
