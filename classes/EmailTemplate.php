<?php
/**
 * Email Templates - Fournit des templates HTML avec CSS pour mails
 */

class EmailTemplate {
    /**
     * Crée un wrapper d'email avec header et footer
     */
    public static function wrap($message, $title = 'UCAO Orientation') {
        return "
            <table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" style=\"table-layout: fixed; background-color: #f5f5f5;\">
                <tr>
                    <td align=\"center\" style=\"padding: 20px;\">
                        <table cellpadding=\"0\" cellspacing=\"0\" style=\"width: 100%; max-width: 600px; background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.1);\">
                            <!-- Header -->
                            <tr>
                                <td style=\"background: linear-gradient(135deg, #180391 0%, #8B0000 100%); padding: 32px 24px; text-align: center;\">
                                    <h1 style=\"color: #FFD700; margin: 0; font-size: 24px; font-weight: 700; font-family: Arial, sans-serif;\">$title</h1>
                                </td>
                            </tr>
                            <!-- Content -->
                            <tr>
                                <td style=\"padding: 32px 24px; color: #333333; font-family: Arial, sans-serif; line-height: 1.6; font-size: 15px;\">
                                    $message
                                </td>
                            </tr>
                            <!-- Footer -->
                            <tr>
                                <td style=\"background-color: #f9f9f9; padding: 24px; border-top: 1px solid #eee; text-align: center; color: #999999; font-family: Arial, sans-serif; font-size: 12px;\">
                                    <p style=\"margin: 0 0 8px 0;\"><strong>UCAO-UUC — Cotonou, Bénin</strong></p>
                                    <p style=\"margin: 0;\">Ceci est un message automatisé. Cet email a été envoyé à votre adresse car vous êtes enregistré auprès de l'Université Catholique d'Afrique de l'Ouest.</p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        ";
    }

    /**
     * Formatte un paragraphe
     */
    public static function paragraph($text) {
        return '<p style=\"margin: 0 0 16px 0; color: #333333;\">' . nl2br(htmlspecialchars($text)) . '</p>';
    }

    /**
     * Crée une section de texte principal
     */
    public static function body($greeting, $content, $closing = null) {
        $html = '<h2 style=\"margin: 0 0 16px 0; color: #180391; font-size: 18px;\">' . htmlspecialchars($greeting) . '</h2>';
        $html .= '<div style=\"margin: 16px 0 24px 0; color: #555555;\">' . nl2br(htmlspecialchars($content)) . '</div>';

        if ($closing) {
            $html .= '<p style=\"margin: 24px 0 0 0; color: #333333;\">' . htmlspecialchars($closing) . '</p>';
        }

        return $html;
    }
}
?>
