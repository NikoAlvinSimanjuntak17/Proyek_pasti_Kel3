<!-- resources/views/auth/register.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<body>
    <h1>Register</h1>
    @if ($errors->any())
        <div>{{ $errors->first() }}</div>
    @endif
    <form action="{{ route('register') }}" method="POST">
        @csrf
        <label for="name">Name</label>
        <input type="text" name="name" id="name" required value="{{ old('name') }}"><br>
        <label for="email">Email</label>
        <input type="email" name="email" id="email" required value="{{ old('email') }}"><br>
        <label for="password">Password</label>
        <input type="password" name="password" id="password" required><br>
        <button type="submit">Register</button>
    </form>
</body>
</html>
