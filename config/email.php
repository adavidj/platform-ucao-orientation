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
        'debug' => APP_ENV === 'dev' ? 0 : 0,
        'simulate' => APP_ENV === 'dev' && empty(env('SMTP_USER', '')),
    ];
}
