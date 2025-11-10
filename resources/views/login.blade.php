<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eksa's Bakes | Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('login.css') }}">
</head>

<body>
    <div class="container">
        <!-- KIRI: Gambar Produk -->
        <div class="image-side"></div>

        <!-- KANAN: Form Login -->
        <div class="form-side">
            <div class="form-container">
                <h1 class="brand">
                    <img src="" alt="" class="logo">
                    Eksa's Bakes
                </h1>

                @if ($errors->any())
                <div id="snackbar" class="snackbar error">
                    <span class="snackbar-text">
                        @foreach ($errors->all() as $error)
                        {{ $error }} <br>
                        @endforeach
                    </span>
                    <button class="snackbar-close" onclick="closeSnackbar()">&times;</button>
                </div>
                @endif

                @if (session('success'))
                <div id="snackbar" class="snackbar success">
                    <span class="snackbar-text">{{ session('success') }}</span>
                    <button class="snackbar-close" onclick="closeSnackbar()">&times;</button>
                </div>
                @endif

                <form action="/login" method="POST">
                    @csrf

                    <div class="input-group">
                        <i class="bi bi-envelope-fill"></i>
                        <input type="text" name="login" placeholder="Username/Email/Phone Number" required>
                    </div>

                    <div class="input-group">
                        <i class="bi bi-lock-fill"></i>
                        <input type="password" name="password" placeholder="Password" required>
                    </div>

                    <button type="submit" class="btn-login">Login</button>
                </form>

                <p class="register-text">
                    Don't have an account? <a href="/register">Register</a>
                </p>
            </div>
        </div>
    </div>
    <script>
        const snackbar = document.getElementById("snackbar");

        if (snackbar) {
            snackbar.classList.add("show");

            setTimeout(() => {
                snackbar.classList.remove("show");
            }, 3000);
        }

        // redirect hanya jika login sukses
        @if(session('success'))
        setTimeout(() => {
            window.location.href = "/";
        }, 3500);
        @endif

        function closeSnackbar() {
            snackbar.classList.remove("show");
        }
    </script>

</body>

</html>