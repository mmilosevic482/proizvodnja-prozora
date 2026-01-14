<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрација | Proizvodnja Prozora</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .register-wrapper {
            width: 100%;
            max-width: 480px;
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .register-container {
            background: white;
            border-radius: 24px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .register-header {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            color: white;
            padding: 40px 30px;
            text-align: center;
            position: relative;
        }

        .register-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #10b981, #34d399);
        }

        .register-header h1 {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 8px;
            letter-spacing: -0.5px;
        }

        .register-header p {
            font-size: 15px;
            opacity: 0.9;
            font-weight: 400;
        }

        .register-body {
            padding: 40px 35px;
        }

        /* Error Messages - Laravel Style */
        .alert-danger {
            background: linear-gradient(135deg, #fed7d7 0%, #feb2b2 100%);
            border: 2px solid #fc8181;
            color: #9b2c2c;
            border-radius: 12px;
            padding: 16px;
            margin-bottom: 25px;
            font-size: 14px;
            font-weight: 500;
            animation: shake 0.5s ease-in-out;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
            20%, 40%, 60%, 80% { transform: translateX(5px); }
        }

        /* Success Message */
        .alert-success {
            background: linear-gradient(135deg, #c6f6d5 0%, #9ae6b4 100%);
            border: 2px solid #68d391;
            color: #22543d;
            border-radius: 12px;
            padding: 16px;
            margin-bottom: 25px;
            font-weight: 500;
        }

        .form-label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-control {
            width: 100%;
            padding: 16px 20px;
            font-size: 16px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            background: #f8fafc;
            transition: all 0.3s ease;
            outline: none;
            color: #2d3748;
        }

        .form-control:focus {
            border-color: #4f46e5;
            background: white;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }

        .form-control::placeholder {
            color: #a0aec0;
            font-weight: 400;
        }

        .mb-4 {
            margin-bottom: 30px !important;
        }

        .password-wrapper {
            position: relative;
        }

        .toggle-password {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #a0aec0;
            cursor: pointer;
            font-size: 18px;
            z-index: 10;
        }

        .phone-input {
            padding-left: 50px !important;
        }

        .phone-prefix {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: #4a5568;
            font-weight: 500;
            z-index: 10;
        }

        .register-button {
            width: 100%;
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            color: white;
            border: none;
            padding: 18px;
            font-size: 16px;
            font-weight: 600;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
            letter-spacing: 0.5px;
            position: relative;
            overflow: hidden;
        }

        .register-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(79, 70, 229, 0.3);
        }

        .register-button:active {
            transform: translateY(0);
        }

        .register-button.loading {
            opacity: 0.8;
            cursor: not-allowed;
        }

        .register-button.loading::after {
            content: '';
            position: absolute;
            width: 20px;
            height: 20px;
            top: 50%;
            left: 50%;
            margin-left: -10px;
            margin-top: -10px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-top: 3px solid white;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .login-section {
            text-align: center;
            font-size: 15px;
            color: #718096;
            padding-top: 25px;
            margin-top: 25px;
            border-top: 1px solid #e2e8f0;
        }

        .login-section a {
            color: #4f46e5;
            text-decoration: none;
            font-weight: 700;
            margin-left: 5px;
            transition: color 0.2s;
        }

        .login-section a:hover {
            color: #3730a3;
            text-decoration: underline;
        }

        .password-strength {
            height: 4px;
            background: #e2e8f0;
            border-radius: 2px;
            margin-top: 8px;
            overflow: hidden;
            position: relative;
        }

        .strength-bar {
            height: 100%;
            width: 0%;
            border-radius: 2px;
            transition: all 0.3s ease;
        }

        .strength-weak { background: #f56565; }
        .strength-medium { background: #ed8936; }
        .strength-strong { background: #48bb78; }

        .password-hint {
            font-size: 12px;
            color: #a0aec0;
            margin-top: 6px;
            display: block;
        }

        /* Logo */
        .logo-placeholder {
            width: 60px;
            height: 60px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 28px;
        }

        /* Responsive */
        @media (max-width: 520px) {
            .register-container {
                border-radius: 20px;
            }

            .register-header {
                padding: 30px 20px;
            }

            .register-body {
                padding: 30px 25px;
            }

            .register-header h1 {
                font-size: 24px;
            }

            .form-control {
                padding: 14px 16px;
                font-size: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="register-wrapper">
        <div class="register-container">
            <div class="register-header">
                <div class="logo-placeholder">
                    <i class="fas fa-user-plus"></i>
                </div>
                <h1>Регистрација</h1>
                <p>Креирајте ваш налог</p>
            </div>

            <div class="register-body">
                <!-- Laravel Error Messages -->
                @if($errors->any())
                    <div class="alert-danger">
                        @foreach($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <!-- Success Message (npr. nakon uspešne registracije) -->
                @if(session('success'))
                    <div class="alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Registration Form -->
                <form method="POST" action="{{ route('register') }}" id="registerForm">
                    @csrf

                    <!-- Ime i prezime -->
                    <div class="mb-4">
                        <label for="name" class="form-label">IME I PREZIME</label>
                        <input type="text"
                               class="form-control"
                               id="name"
                               name="name"
                               value="{{ old('name') }}"
                               placeholder="Петар Петровић"
                               required
                               autofocus
                               autocomplete="name">
                    </div>

                    <!-- Email -->
                    <div class="mb-4">
                        <label for="email" class="form-label">EMAIL</label>
                        <input type="email"
                               class="form-control"
                               id="email"
                               name="email"
                               value="{{ old('email') }}"
                               placeholder="primer@email.com"
                               required
                               autocomplete="email">
                    </div>

                    <!-- Telefon -->
                    <div class="mb-4">
                        <label for="phone" class="form-label">TELEFON</label>
                        <div class="position-relative">
                            <span class="phone-prefix">+381</span>
                            <input type="tel"
                                   class="form-control phone-input"
                                   id="phone"
                                   name="phone"
                                   value="{{ old('phone') }}"
                                   placeholder="60 123 4567"
                                   pattern="[0-9\s]{9,15}"
                                   title="Unesite broj telefona bez +381 prefiksa"
                                   autocomplete="tel">
                        </div>
                        <small class="password-hint">Format: 60 123 4567</small>
                    </div>

                    <!-- Lozinka -->
                    <div class="mb-4">
                        <label for="password" class="form-label">LOZINKA</label>
                        <div class="password-wrapper">
                            <input type="password"
                                   class="form-control"
                                   id="password"
                                   name="password"
                                   placeholder="• • • • • • • • • • • • • • • • • • • • •"
                                   required
                                   minlength="8"
                                   autocomplete="new-password">
                            <button type="button" class="toggle-password" data-target="password">
                                <i class="far fa-eye"></i>
                            </button>
                        </div>
                        <div class="password-strength">
                            <div class="strength-bar" id="passwordStrength"></div>
                        </div>
                        <small class="password-hint">Minimum 8 karaktera (slova, brojevi i znakovi)</small>
                    </div>

                    <!-- Potvrda lozinke -->
                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label">POTVRDA LOZINKE</label>
                        <div class="password-wrapper">
                            <input type="password"
                                   class="form-control"
                                   id="password_confirmation"
                                   name="password_confirmation"
                                   placeholder="• • • • • • • • • • • • • • • • • • • • •"
                                   required
                                   autocomplete="new-password">
                            <button type="button" class="toggle-password" data-target="password_confirmation">
                                <i class="far fa-eye"></i>
                            </button>
                        </div>
                        <small class="password-hint" id="passwordMatch"></small>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="register-button" id="submitButton">
                        РЕГИСТРУЈ СЕ
                    </button>
                </form>

                <!-- Login Link -->
                <div class="login-section">
                    Већ имате налог?
                    <a href="{{ route('login') }}">Пријавите се</a>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle password visibility
            document.querySelectorAll('.toggle-password').forEach(button => {
                button.addEventListener('click', function() {
                    const targetId = this.getAttribute('data-target');
                    const passwordInput = document.getElementById(targetId);
                    const icon = this.querySelector('i');

                    if (passwordInput.type === 'password') {
                        passwordInput.type = 'text';
                        icon.classList.remove('fa-eye');
                        icon.classList.add('fa-eye-slash');
                    } else {
                        passwordInput.type = 'password';
                        icon.classList.remove('fa-eye-slash');
                        icon.classList.add('fa-eye');
                    }
                });
            });

            // Password strength indicator
            const passwordInput = document.getElementById('password');
            const strengthBar = document.getElementById('passwordStrength');
            const passwordConfirm = document.getElementById('password_confirmation');
            const passwordMatch = document.getElementById('passwordMatch');

            passwordInput.addEventListener('input', function() {
                const password = this.value;
                let strength = 0;

                // Length check
                if (password.length >= 8) strength += 25;
                if (password.length >= 12) strength += 15;

                // Complexity checks
                if (/[A-Z]/.test(password)) strength += 20;
                if (/[a-z]/.test(password)) strength += 20;
                if (/[0-9]/.test(password)) strength += 20;
                if (/[^A-Za-z0-9]/.test(password)) strength += 20;

                // Cap at 100
                strength = Math.min(strength, 100);

                // Update strength bar
                strengthBar.style.width = strength + '%';

                // Set color based on strength
                if (strength < 40) {
                    strengthBar.className = 'strength-bar strength-weak';
                } else if (strength < 70) {
                    strengthBar.className = 'strength-bar strength-medium';
                } else {
                    strengthBar.className = 'strength-bar strength-strong';
                }

                // Check password match
                checkPasswordMatch();
            });

            // Check password confirmation
            passwordConfirm.addEventListener('input', checkPasswordMatch);

            function checkPasswordMatch() {
                if (passwordConfirm.value === '') {
                    passwordMatch.textContent = '';
                    passwordMatch.style.color = '#a0aec0';
                    return;
                }

                if (passwordInput.value === passwordConfirm.value) {
                    passwordMatch.textContent = '✓ Lozinke se poklapaju';
                    passwordMatch.style.color = '#48bb78';
                } else {
                    passwordMatch.textContent = '✗ Lozinke se ne poklapaju';
                    passwordMatch.style.color = '#f56565';
                }
            }

            // Phone number formatting
            const phoneInput = document.getElementById('phone');
            phoneInput.addEventListener('input', function() {
                let value = this.value.replace(/\D/g, '');

                // Format as XX XXX XXXX
                if (value.length > 2) {
                    value = value.substring(0, 2) + ' ' + value.substring(2);
                }
                if (value.length > 6) {
                    value = value.substring(0, 6) + ' ' + value.substring(6, 10);
                }

                this.value = value.substring(0, 12); // Max length
            });

            // Form submission
            const form = document.getElementById('registerForm');
            const submitButton = document.getElementById('submitButton');

            form.addEventListener('submit', function(e) {
                // Basic validation
                if (passwordInput.value !== passwordConfirm.value) {
                    e.preventDefault();
                    passwordMatch.textContent = '✗ Lozinke moraju da se poklapaju!';
                    passwordMatch.style.color = '#f56565';
                    passwordConfirm.focus();
                    return;
                }

                // Show loading state
                submitButton.classList.add('loading');
                submitButton.disabled = true;
                submitButton.innerHTML = '';

                // Continue with form submission
            });

            // Auto-focus on first error field
            const firstError = document.querySelector('.form-control.is-invalid');
            if (firstError) {
                firstError.focus();
            }
        });
    </script>
</body>
</html>
