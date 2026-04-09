<?php
// classes/Mailer.php

require_once dirname(__DIR__) . "/vendor/autoload.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Mailer
{
    private $mail;
    private $error;

    public function __construct()
    {
        $this->mail = new PHPMailer(true);
        $this->setup();
    }

    private function setup()
    {
        try {
            // Utilisation des constantes définies dans config/app.php
            $this->mail->isSMTP();
            
            // On vérifie si les constantes existent, sinon on utilise des valeurs par défaut
            $host = defined('SMTP_HOST') ? SMTP_HOST : 'mail37.lwspanel.com';
            $port = defined('SMTP_PORT') ? SMTP_PORT : 465;
            $user = defined('SMTP_USER') ? SMTP_USER : 'ucaotech@ucaobenin.org';
            $pass = defined('SMTP_PASS') ? SMTP_PASS : 'Uc@oTech2026';
            $fromEmail = defined('SMTP_FROM') ? SMTP_FROM : $user;
            $fromName = defined('SMTP_FROM_NAME') ? SMTP_FROM_NAME : 'UCAO-Orientation';
            $secure = defined('SMTP_SECURE') ? SMTP_SECURE : 'ssl';

            $this->mail->Host = $host;
            $this->mail->SMTPAuth = true;
            $this->mail->Username = $user;
            $this->mail->Password = $pass;
            $this->mail->Port = $port;
            
            if ($secure === 'ssl' || $port === 465) {
                $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            } else {
                $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            }

            $this->mail->Timeout = 20;
            
            // Options SSL pour LWS (souvent nécessaires pour éviter les erreurs de certificat)
            $this->mail->SMTPOptions = [
                "ssl" => [
                    "verify_peer" => false,
                    "verify_peer_name" => false,
                    "allow_self_signed" => true
                ]
            ];

            $this->mail->CharSet = "UTF-8";
            $this->mail->setFrom($fromEmail, $fromName);
            $this->mail->isHTML(true);

            // Activer le debug pour voir l'erreur exacte dans les logs si ça échoue encore
            $this->mail->SMTPDebug = 2;
            $this->mail->Debugoutput = function($str, $level) {
                error_log("SMTP Debug: $str");
            };
            
        } catch (Exception $e) {
            $this->error = $e->getMessage();
        }
    }

    /**
     * Envoie un email générique
     * Retourne un array avec 'success' et 'message'
     */
    public function send($to, $subject, $body, $attachments = [], $replyTo = null)
    {
        try {
            if (empty($to)) {
                return ['success' => false, 'message' => 'Adresse email invalide'];
            }

            $this->mail->clearAddresses();
            $this->mail->clearAttachments();
            $this->mail->clearReplyTos();

            $this->mail->addAddress($to);
            $this->mail->Subject = (string)$subject;
            $this->mail->Body = (string)$body;

            if ($replyTo) {
                $this->mail->addReplyTo($replyTo);
            }

            if (!empty($attachments)) {
                foreach ($attachments as $filePath) {
                    if (file_exists($filePath)) {
                        $this->mail->addAttachment($filePath);
                    }
                }
            }

            $sent = $this->mail->send();

            if ($sent) {
                return ['success' => true, 'message' => 'Email envoyé avec succès'];
            } else {
                $this->error = $this->mail->ErrorInfo;
                error_log("Mailer Error: " . $this->error);
                return ['success' => false, 'message' => $this->error];
            }
        } catch (Exception $e) {
            $this->error = $this->mail->ErrorInfo;
            error_log("Mailer Error: " . $this->error);
            return ['success' => false, 'message' => $this->error];
        }
    }

    /**
     * Méthode spécifique pour le formulaire de contact
     */
    public function sendContactEmail($data)
    {
        try {
            // 1. Notification aux Admins
            $adminEmail = defined('CONTACT_EMAIL') ? CONTACT_EMAIL : 'contact@ucaobenin.org';

            $this->mail->clearAddresses();
            $this->mail->clearReplyTos();
            $this->mail->addAddress($adminEmail);
            $this->mail->addReplyTo($data["email"], $data["nom"] . " " . $data["prenom"]);
            $this->mail->Subject = "Nouveau Message: " . $data["sujet"];

            $adminBody = "<h3>Message de contact reçu</h3>";
            $adminBody .= "<b>Nom:</b> " . htmlspecialchars($data["nom"] . " " . $data["prenom"]) . "<br>";
            $adminBody .= "<b>Email:</b> " . htmlspecialchars($data["email"]) . "<br>";
            $adminBody .= "<b>Sujet:</b> " . htmlspecialchars($data["sujet"]) . "<br><br>";
            $adminBody .= "<b>Message:</b><br>" . nl2br(htmlspecialchars($data["message"]));

            $this->mail->Body = $adminBody;
            $adminSent = $this->mail->send();

            // 2. Accusé de réception au visiteur
            $this->mail->clearAddresses();
            $this->mail->addAddress($data["email"]);
            $this->mail->Subject = "Reçu : " . $data["sujet"];
            $this->mail->Body = "Bonjour " . htmlspecialchars($data["prenom"]) . ",<br><br>Nous avons bien reçu votre message et nous vous répondrons dès que possible.<br><br>Cordialement,<br>L'équipe UCAO.";

            $userSent = $this->mail->send();

            if ($adminSent && $userSent) {
                return ['success' => true, 'message' => 'Message envoyé avec succès'];
            } else {
                $this->error = $this->mail->ErrorInfo;
                return ['success' => false, 'message' => $this->error];
            }
        } catch (Exception $e) {
            $this->error = $this->mail->ErrorInfo;
            return ['success' => false, 'message' => $this->error];
        }
    }

    public function getError() { return $this->error; }
}
