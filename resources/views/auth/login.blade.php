
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Login Administrator | Konservasi Bersenyum</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
          rel="stylesheet">

    <style>
        :root {
            --maroon: #801629;
            --maroon-dark: #5d1020;
            --cream: #fff9e8;
            --gold: #f0cf68;
            --text: #333333;
        }

        * {
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            background: var(--cream);
            font-family: Arial, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-wrapper {
            width: 100%;
            max-width: 950px;
            min-height: 560px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            background: white;
            border-radius: 22px;
            overflow: hidden;
            box-shadow: 0 15px 45px rgba(80, 20, 30, .12);
        }

        .login-banner {
            background: linear-gradient(
                145deg,
                var(--maroon),
                var(--maroon-dark)
            );
            color: white;
            padding: 55px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .brand-logo {
            width: 55px;
            height: 55px;
            background: var(--gold);
            color: var(--maroon);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
            font-weight: bold;
            margin-bottom: 25px;
        }

        .login-banner h1 {
            font-size: 35px;
            font-weight: 700;
            line-height: 1.25;
        }

        .login-banner p {
            color: #f1dce0;
            line-height: 1.8;
            margin-top: 15px;
        }

        .login-form {
            padding: 60px 45px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-form h2 {
            color: var(--maroon);
            font-weight: 700;
            margin-bottom: 8px;
        }

        .login-form .subtitle {
            color: #777;
            margin-bottom: 30px;
        }

        .form-label {
            font-weight: 600;
            color: var(--text);
        }

        .form-control {
            padding: 13px 15px;
            border-radius: 10px;
            border: 1px solid #ddd;
        }

        .form-control:focus {
            border-color: var(--maroon);
            box-shadow: 0 0 0 3px rgba(128, 22, 41, .1);
        }

        .btn-login {
            background: var(--maroon);
            color: white;
            padding: 13px;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            transition: .3s;
        }

        .btn-login:hover {
            background: var(--maroon-dark);
            color: white;
            transform: translateY(-2px);
        }

        .btn-login:disabled {
            opacity: .7;
            cursor: not-allowed;
            transform: none;
        }

        .alert {
            border-radius: 10px;
            font-size: 14px;
        }

        .password-wrapper {
            position: relative;
        }

        .toggle-password {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            border: none;
            background: transparent;
            color: #777;
        }

        @media (max-width: 768px) {
            .login-wrapper {
                grid-template-columns: 1fr;
                max-width: 460px;
            }

            .login-banner {
                padding: 30px;
            }

            .login-banner h1 {
                font-size: 27px;
            }

            .login-banner p {
                margin-bottom: 0;
            }

            .login-form {
                padding: 35px 25px;
            }
        }

        @media (max-width: 380px) {
            body {
                padding: 10px;
            }

            .login-form {
                padding: 28px 18px;
            }
        }
    </style>
</head>

<body>

    <div class="login-wrapper">

        <!-- Bagian Informasi -->
        <div class="login-banner">

            <div class="brand-logo">K</div>

            <h1>
                Konservasi Bersenyum
            </h1>

            <p>
                Bersama menciptakan perubahan positif
                melalui pendidikan, pemberdayaan,
                dan kepedulian terhadap masyarakat.
            </p>

            <div class="mt-4">
                <small>
                    &copy; 2026 Konservasi Bersenyum
                </small>
            </div>

        </div>

        <!-- Bagian Form Login -->
        <div class="login-form">

            <h2>Selamat Datang!</h2>

            <p class="subtitle">
                Silakan login untuk mengakses dashboard administrator.
            </p>

            <div id="alertMessage"></div>

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <form id="loginForm"
                  action="{{ route('login.process') }}"
                  method="POST">

                @csrf

                <div class="mb-3">

                    <label class="form-label">
                        Email Administrator
                    </label>

                    <input
                        type="email"
                        name="email"
                        id="email"
                        class="form-control"
                        placeholder="Masukkan email"
                        autocomplete="username"
                        required
                    >

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Password
                    </label>

                    <div class="password-wrapper">

                        <input
                            type="password"
                            name="password"
                            id="password"
                            class="form-control"
                            placeholder="Masukkan password"
                            autocomplete="current-password"
                            required
                        >

                        <button
                            type="button"
                            class="toggle-password"
                            id="togglePassword"
                            aria-label="Tampilkan password"
                        >
                            <i class="bi bi-eye"></i>
                        </button>

                    </div>

                </div>

                <button
                    type="submit"
                    class="btn btn-login w-100 mt-3"
                    id="btnLogin"
                >
                    <span id="btnText">
                        <i class="bi bi-box-arrow-in-right me-2"></i>
                        Login Administrator
                    </span>
                </button>

            </form>

            <div class="text-center mt-4">
                <small class="text-secondary">
                    Halaman khusus administrator
                </small>
            </div>

        </div>

    </div>

    <script>
        // Menampilkan atau menyembunyikan password
        document.getElementById('togglePassword')
            .addEventListener('click', function () {

                const password = document.getElementById('password');
                const icon = this.querySelector('i');

                if (password.type === 'password') {
                    password.type = 'text';
                    icon.classList.replace('bi-eye', 'bi-eye-slash');
                } else {
                    password.type = 'password';
                    icon.classList.replace('bi-eye-slash', 'bi-eye');
                }
            });


        // Proses login menggunakan AJAX Fetch API
        document.getElementById('loginForm')
            .addEventListener('submit', async function (e) {

                e.preventDefault();

                const form = this;
                const button = document.getElementById('btnLogin');
                const btnText = document.getElementById('btnText');
                const alertMessage = document.getElementById('alertMessage');

                const email = document.getElementById('email').value;
                const password = document.getElementById('password').value;

                alertMessage.innerHTML = '';

                button.disabled = true;
                btnText.innerHTML =
                    '<span class="spinner-border spinner-border-sm me-2"></span>Memproses...';

                try {

                    const response = await fetch(form.action, {

                        method: 'POST',

                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector(
                                'meta[name="csrf-token"]'
                            ).content
                        },

                        body: JSON.stringify({
                            email: email,
                            password: password
                        })

                    });

                    const result = await response.json();

                    if (response.ok && result.success) {

                        alertMessage.innerHTML = `
                            <div class="alert alert-success">
                                ${result.message}
                            </div>
                        `;

                        window.location.href = result.redirect;

                    } else {

                        alertMessage.innerHTML = `
                            <div class="alert alert-danger">
                                ${result.message || 'Terjadi kesalahan.'}
                            </div>
                        `;

                    }

                } catch (error) {

                    alertMessage.innerHTML = `
                        <div class="alert alert-danger">
                            Tidak dapat terhubung ke server.
                            Silakan coba kembali.
                        </div>
                    `;

                } finally {

                    button.disabled = false;

                    btnText.innerHTML = `
                        <i class="bi bi-box-arrow-in-right me-2"></i>
                        Login Administrator
                    `;

                }

            });
    </script>

</body>
</html>
