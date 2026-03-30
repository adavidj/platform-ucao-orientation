<?php
// =================================================================
// CONFIGURATION EMAIL (PHPMailer)
// =================================================================

function getMailerConfig() {
    return [
        'host' => env('SMTP_HOST', 'smtp.gmail.com'),
        'port' => (int) env('SMTP_PORT', 587),
        'username' => env('SMTP_USER', ''),
        'password' => env('SMTP_PASS', ''),
        'from_email' => env('SMTP_FROM_EMAIL', 'noreply@ucao.bj'),
        'from_name' => env('SMTP_FROM_NAME', 'UCAO Orientation'),
        'encryption' => env('SMTP_ENCRYPTION', 'tls'),
        'debug' => (int) env('SMTP_DEBUG', 0),
        'allow_self_signed' => env('SMTP_ALLOW_SELF_SIGNED', 'false') === 'true',
        'simulate' => APP_ENV === 'dev' && empty(env('SMTP_USER', '')),
    ];
}
