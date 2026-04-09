<?php
// =================================================================
// PAGE DE CONNEXION ADMIN
// =================================================================
require_once dirname(__DIR__) . '/config/config.php';
require_once dirname(__DIR__) . '/config/constantes.php';

// Si déjà connecté, rediriger vers le dashboard
if (Auth::isLoggedIn()) {
    redirect('index.php');
}

$error = '';
$success = '';

$flash = get_flash();
if ($flash) {
    if ($flash['type'] === 'error') {
        $error = $flash['message'];
    } else {
        $success = $flash['message'];
    }
}

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $token = $_POST['csrf_token'] ?? '';

    if (!verify_csrf($token)) {
        $error = 'Session expirée. Veuillez réessayer.';
    } elseif (empty($email) || empty($password)) {
        $error = 'Veuillez remplir tous les champs.';
    } else {
        $result = Auth::login($email, $password);
        if ($result['success']) {
            redirect('index.php');
        } else {
            $error = $result['message'];
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Connexion — UCAO Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Poppins:wght@500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        
        :root {
            --primary: #180391;
            --primary-dark: #0e0560;
            --primary-light: #2a15b3;
            --secondary: #8B0000;
            --gold: #FFD700;
            --gold-dark: #ccac00;
            --white: #ffffff;
            --light-gray: #F8F9FC;
            --text-dark: #1a1a2e;
            --text-muted: #636e72;
            --error: #ef4444;
            --font-primary: 'Poppins', sans-serif;
            --font-secondary: 'Open Sans', sans-serif;
        }

        body {
            font-family: var(--font-secondary);
            background: linear-gradient(135deg, var(--primary-dark) 0%, #0a0445 40%, var(--secondary) 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            overflow: hidden;
        }

        /* Background decorations */
        body::before {
            content: '';
            position: absolute;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(255, 215, 0, 0.08) 0%, transparent 70%);
            top: -100px;
            right: -100px;
            border-radius: 50%;
        }
        body::after {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(255, 215, 0, 0.06) 0%, transparent 70%);
            bottom: -80px;
            left: -80px;
            border-radius: 50%;
        }

        .login-container {
            width: 100%;
            max-width: 440px;
            position: relative;
            z-index: 1;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.97);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            padding: 48px 40px;
            box-shadow: 0 32px 64px rgba(0, 0, 0, 0.3), 0 16px 32px rgba(0, 0, 0, 0.2);
            animation: loginSlideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes loginSlideUp {
            from { opacity: 0; transform: translateY(30px) scale(0.98); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        .login-logo {
            text-align: center;
            margin-bottom: 32px;
        }

        .login-logo-circle {
            width: 72px;
            height: 72px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: var(--gold);
            font-family: var(--font-primary);
            font-weight: 700;
            font-size: 24px;
            margin-bottom: 16px;
            box-shadow: 0 8px 24px rgba(24, 3, 145, 0.3);
        }

        .login-logo h1 {
            font-family: var(--font-primary);
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 4px;
        }

        .login-logo p {
            font-size: 0.875rem;
            color: var(--text-muted);
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-family: var(--font-primary);
            font-weight: 600;
            font-size: 0.8125rem;
            color: var(--text-dark);
            margin-bottom: 8px;
        }

        .form-input {
            width: 100%;
            padding: 14px 16px;
            border: 2px solid #E5E8EF;
            border-radius: 12px;
            font-family: var(--font-secondary);
            font-size: 0.9375rem;
            color: var(--text-dark);
            background: var(--light-gray);
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
            outline: none;
        }

        .form-input:focus {
            border-color: var(--primary);
            background: var(--white);
            box-shadow: 0 0 0 4px rgba(24, 3, 145, 0.1);
        }

        .form-input::placeholder {
            color: #9ca3af;
        }

        .login-btn {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: var(--white);
            border: none;
            border-radius: 12px;
            font-family: var(--font-primary);
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            margin-top: 8px;
            position: relative;
            overflow: hidden;
        }

        .login-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.15), transparent);
            transition: left 0.5s;
        }

        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 28px rgba(24, 3, 145, 0.35);
        }

        .login-btn:hover::before {
            left: 100%;
        }

        .login-btn:active {
            transform: translateY(-1px) scale(0.99);
        }

        .error-message {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: var(--error);
            padding: 12px 16px;
            border-radius: 10px;
            font-size: 0.875rem;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            animation: shakeError 0.4s ease;
        }

        .success-message {
            background: #ecfdf5;
            border: 1px solid #a7f3d0;
            color: #059669;
            padding: 12px 16px;
            border-radius: 10px;
            font-size: 0.875rem;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        @keyframes shakeError {
            0%, 100% { transform: translateX(0); }
            20%, 60% { transform: translateX(-6px); }
            40%, 80% { transform: translateX(6px); }
        }

        .login-footer {
            text-align: center;
            margin-top: 24px;
        }

        .login-footer a {
            color: var(--primary);
            text-decoration: none;
            font-size: 0.8125rem;
            font-weight: 600;
            transition: color 0.2s;
        }

        .login-footer a:hover {
            color: var(--secondary);
        }

        @media (max-width: 480px) {
            .login-card {
                padding: 36px 24px;
                border-radius: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-logo">
                <div class="login-logo-circle">UO</div>
                <h1>UCAO Administration</h1>
                <p>Connectez-vous pour accéder au tableau de bord</p>
            </div>

            <?php if ($error): ?>
            <div class="error-message">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                <?= e($error) ?>
            </div>
            <?php endif; ?>

            <?php if ($success): ?>
            <div class="success-message">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                <?= e($success) ?>
            </div>
            <?php endif; ?>

            <form method="POST" action="" autocomplete="off">
                <?= csrf_field() ?>
                
                <div class="form-group">
                    <label for="email">Adresse e-mail</label>
                    <input type="email" id="email" name="email" class="form-input" placeholder="admin@ucao.bj" value="<?= e($_POST['email'] ?? '') ?>" required autofocus>
                </div>

                <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <input type="password" id="password" name="password" class="form-input" placeholder="••••••••" required>
                </div>

                <button type="submit" class="login-btn">Se connecter</button>
            </form>

            <div class="login-footer">
                <a href="<?= APP_URL ?>">← Retour au site</a>
            </div>
        </div>
    </div>
</body>
</html>
