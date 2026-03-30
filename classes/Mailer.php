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
            // Utilisation des variables du .env via la fonction env()
            $this->mail->isSMTP();
            $this->mail->Host = env("SMTP_HOST", "mail37.lwspanel.com");
            $this->mail->SMTPAuth = true;
            $this->mail->Username = env("SMTP_USER", "ucaotech@ucaobenin.org");
            $this->mail->Password = env("SMTP_PASS", "Uc@oTech2026");
            
            // On récupère le port et l''encryption du .env
            $port = (int)env("SMTP_PORT", 587);
            $encryption = strtolower(env("SMTP_ENCRYPTION", "tls"));
            
            $this->mail->Port = $port;
            
            if ($encryption === "ssl" || $port === 465) {
                $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            } else {
                $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            }

            $this->mail->Timeout = 20;
            
            // Options SSL pour LWS (souvent nécessaires)
            $allowSelfSigned = env("SMTP_ALLOW_SELF_SIGNED", "false") === "true";
            $this->mail->SMTPOptions = [
                "ssl" => [
                    "verify_peer" => !$allowSelfSigned,
                    "verify_peer_name" => !$allowSelfSigned,
                    "allow_self_signed" => $allowSelfSigned
                ]
            ];

            $this->mail->CharSet = "UTF-8";
            $this->mail->setFrom(
                env("SMTP_FROM_EMAIL", env("SMTP_USER")), 
                env("SMTP_FROM_NAME", "UCAO-Orientation")
            );
            $this->mail->isHTML(true);

            // Debug controlé par le .env
            $this->mail->SMTPDebug = (int)env("SMTP_DEBUG", 0);
            
        } catch (Exception $e) {
            $this->error = $e->getMessage();
        }
    }

    public function sendContactEmail($data)
    {
        try {
            // Email Admin
            $this->mail->clearAddresses();
            $this->mail->clearReplyTos();
            $this->mail->addAddress(env("SMTP_FROM_EMAIL", "ucaotech@ucaobenin.org"));
            $this->mail->addReplyTo($data["email"], $data["nom"] . " " . $data["prenom"]);
            $this->mail->Subject = "Contact: " . $data["sujet"];
            
            $body = "<h3>Nouveau message de contact</h3>";
            $body .= "<b>De:</b> " . htmlspecialchars($data["nom"] . " " . $data["prenom"]) . " (" . $data["email"] . ")<br>";
            $body .= "<b>Sujet:</b> " . htmlspecialchars($data["sujet"]) . "<br><br>";
            $body .= "<b>Message:</b><br>" . nl2br(htmlspecialchars($data["message"]));
            
            $this->mail->Body = $body;
            $this->mail->send();

            // Email Accusé de réception
            $this->mail->clearAddresses();
            $this->mail->addAddress($data["email"]);
            $this->mail->Subject = "Confirmation de réception - UCAO";
            $this->mail->Body = "Bonjour " . htmlspecialchars($data["prenom"]) . ",<br><br>Nous avons bien reçu votre message et reviendrons vers vous rapidement.<br><br>Cordialement,<br>L''équipe UCAO.";
            
            $this->mail->send();
            return true;
        } catch (Exception $e) {
            $this->error = $this->mail->ErrorInfo;
            return false;
        }
    }

    public function getError() { return $this->error; }
}