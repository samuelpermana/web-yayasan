<!DOCTYPE html>
<html>
<head>
    <title>Login - YAYASAN AYAH BIGEL</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body class="bg-light d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow p-4" style="width: 400px;">
        <h3 class="text-center mb-4">Login</h3>
        <form method="POST" action="{{ route('login.process') }}">
            @csrf
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input id="username" type="text" class="form-control" name="username" value="{{ old('username') }}" required autofocus>
                @error('username')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input id="password" type="password" class="form-control" name="password" required>
                @error('password')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
    </div>
</body>
</html>
