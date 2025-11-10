<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eksa’s Bakes | Register</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="register.css">
</head>

<body>
    <div class="container">
        <!-- KIRI: Gambar produk dessert -->
        <div class="image-side"></div>

        <!-- KANAN: Form Register -->
        <div class="form-side">
            <div class="form-container">
                <h1 class="brand">
                    <img src="" alt="" class="logo">
                    Eksa’s Bakes
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

                <form action="/register" method="POST">
                    @csrf
                    <div class="input-group">
                        <i class="bi bi-person-fill"></i>
                        <input type="text" name="name" placeholder="Username" required>
                    </div>

                    <div class="input-group">
                        <i class="bi bi-envelope-fill"></i>
                        <input type="text"
                            name="email_or_phone"
                            placeholder="Email/Phone Number"
                            required
                            pattern="(^[0-9]{10,13}$)|(^[\w.%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$)"
                            title="Masukkan email valid atau nomor HP (08xxxxxxxxxx)">
                    </div>

                    <div class="input-group">
                        <i class="bi bi-lock-fill"></i>
                        <input type="password" name="password" placeholder="Password" required>
                    </div>

                    <div class="input-group">
                        <i class="bi bi-shield-lock-fill"></i>
                        <input type="password" name="password_confirmation" placeholder="Confirm Password" required>
                    </div>

                    <button type="submit" class="btn-register" href="login">Register</button>
                </form>

                <p class="login-text">
                    Already have an account? <a href="login">Login</a>
                </p>
            </div>
        </div>
    </div>
    <script>
        const snackbar = document.getElementById("snackbar");

        if (snackbar) {
            snackbar.classList.add("show");

            // auto hide snackbar
            setTimeout(() => {
                snackbar.classList.remove("show");
            }, 3000);
        }

        // redirect hanya kalau ada session success
        @if(session('success'))
        setTimeout(() => {
            window.location.href = "/login";
        }, 3500);
        @endif

        function closeSnackbar() {
            if (snackbar) snackbar.classList.remove("show");
        }
    </script>

</body>

</html>