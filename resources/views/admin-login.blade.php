<!DOCTYPE html>
<html>
<head>
    <title>تسجيل دخول المدير</title>
    <meta charset="UTF-8">
</head>
<body>
    <h1>تسجيل دخول المدير</h1>

    @if($errors->any())
        <div style="color:red;">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="/admin-login">
        @csrf
        <label>البريد الإلكتروني:</label><br>
        <input type="email" name="email" required><br><br>

        <label>كلمة المرور:</label><br>
        <input type="password" name="password" required><br><br>

        <button type="submit">تسجيل دخول</button>
    </form>
</body>
</html>
