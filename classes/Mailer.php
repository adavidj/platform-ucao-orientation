<?php
// =================================================================
// CLASSE Mailer — Envoi d'emails via PHPMailer
// =================================================================

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception as PHPMailerException;

class Mailer {
    private $config;
    private $simulate;

    public function __construct() {
        require_once dirname(__DIR__) . '/config/email.php';
        $this->config = getMailerConfig();
        $this->simulate = $this->config['simulate'];
    }

    /**
     * Envoyer un email unique
     */
    public function send($to, $subject, $htmlBody, $attachments = []) {
        // Mode simulation (dev sans SMTP)
        if ($this->simulate) {
            return $this->logEmail($to, $subject, $htmlBody);
        }

        try {
            $mail = $this->createMailer();
            $mail->addAddress($to);
            $mail->Subject = $subject;
            $mail->Body = $htmlBody;
            $mail->AltBody = strip_tags($htmlBody);

            foreach ($attachments as $attachment) {
                if (file_exists($attachment)) {
                    $mail->addAttachment($attachment);
                }
            }

            $mail->send();
            return ['success' => true, 'message' => 'Email envoyé avec succès.'];
        } catch (PHPMailerException $e) {
            error_log("Erreur envoi email: " . $e->getMessage());
            return ['success' => false, 'message' => 'Erreur d\'envoi: ' . $e->getMessage()];
        }
    }

    /**
     * Envoyer des emails en lot
     */
    public function sendBulk($recipients, $subject, $htmlBody) {
        $sent = 0;
        $errors = 0;

        foreach ($recipients as $email) {
            $result = $this->send($email, $subject, $htmlBody);
            if ($result['success']) {
                $sent++;
            } else {
                $errors++;
            }
            // Pause entre les envois pour éviter le throttling
            if (!$this->simulate) {
                usleep(200000); // 200ms
            }
        }

        return [
            'success' => $errors === 0,
            'message' => "$sent email(s) envoyé(s)" . ($errors > 0 ? ", $errors erreur(s)" : ""),
            'sent' => $sent,
            'errors' => $errors,
        ];
    }

    /**
     * Créer une instance PHPMailer configurée
     */
    private function createMailer() {
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = $this->config['host'];
        $mail->SMTPAuth = true;
        $mail->Username = $this->config['username'];
        $mail->Password = $this->config['password'];
        $mail->SMTPSecure = $this->config['encryption'] === 'tls' ? PHPMailer::ENCRYPTION_STARTTLS : PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = $this->config['port'];
        $mail->setFrom($this->config['from_email'], $this->config['from_name']);
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';
        $mail->SMTPDebug = $this->config['debug'];
        return $mail;
    }

    /**
     * Mode simulation : log les emails au lieu de les envoyer
     */
    private function logEmail($to, $subject, $body) {
        $logDir = APP_ROOT . '/uploads/email_logs';
        if (!is_dir($logDir)) {
            mkdir($logDir, 0755, true);
        }
        $logFile = $logDir . '/email_' . date('Y-m-d_His') . '_' . uniqid() . '.html';
        $logContent = "<!-- TO: $to -->\n<!-- SUBJECT: $subject -->\n<!-- DATE: " . date('Y-m-d H:i:s') . " -->\n\n$body";
        file_put_contents($logFile, $logContent);
        error_log("[MAIL SIMULATION] To: $to | Subject: $subject | Logged to: $logFile");
        return ['success' => true, 'message' => '[SIMULATION] Email loggé avec succès.'];
    }
}
