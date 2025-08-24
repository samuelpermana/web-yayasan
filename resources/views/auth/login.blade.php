<!DOCTYPE html>
<html>
<head>
    <title>Login - YAYASAN AYAH BIGEL</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="logo-section">
                <div class="logo">
            <a href="/"><img src="/img/logoyayasan.png" alt="Ummahatul Mukminin Logo"></a>
        </div>
                <h1 class="login-title">Sign in to Yayasan</h1>
                <p class="login-subtitle">Ummahatul Mukminin</p>
            </div>

            <form method="POST" action="{{ route('login.process') }}" id="loginForm">
                @csrf
                <div class="form-group">
                    <label for="username" class="form-label">Username</label>
                    <input 
                        id="username" 
                        type="text" 
                        class="form-control" 
                        name="username" 
                        value="{{ old('username') }}" 
                        required 
                        autofocus
                        placeholder="name@work-email.com"
                    >
                    @error('username')
                        <div class="error-message">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <input 
                        id="password" 
                        type="password" 
                        class="form-control" 
                        name="password" 
                        required
                        placeholder="Enter your password"
                    >
                    @error('password')
                        <div class="error-message">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <button type="submit" class="btn-login" id="loginBtn">
                    <span>LOG IN</span>
                </button>
            </form>

            

            

            <div class="forgot-password">
                <a href="#" onclick="showComingSoon('Forgot Password')">Forgot your password?</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Add loading state to login button
        document.getElementById('loginForm').addEventListener('submit', function() {
            const btn = document.getElementById('loginBtn');
            const btnText = btn.querySelector('span');
            btn.classList.add('loading');
            btnText.textContent = 'SIGNING IN...';
        });

        // Show coming soon alert
        function showComingSoon(feature) {
            alert(feature + ' integration coming soon!');
        }

        // Add smooth focus transitions
        const inputs = document.querySelectorAll('.form-control');
        inputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.style.transform = 'translateY(-1px)';
            });
            
            input.addEventListener('blur', function() {
                this.style.transform = 'translateY(0)';
            });
        });

        // Keyboard navigation
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                document.getElementById('loginForm').dispatchEvent(new Event('submit'));
            }
        });
    </script>
</body>
</html>
