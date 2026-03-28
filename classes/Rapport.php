<?php
// =================================================================
// CLASSE Rapport — Génération de PDF (DOMPDF)
// =================================================================

use Dompdf\Dompdf;
use Dompdf\Options;

class Rapport {

    /**
     * Générer le PDF du rapport d'orientation
     */
    public static function generateOrientationPDF($orientationId) {
        $orientation = Orientation::getById($orientationId);
        if (!$orientation) return null;

        $html = self::getOrientationTemplate($orientation);
        
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        $options->set('defaultFont', 'Helvetica');

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // Sauvegarder le fichier
        $filename = 'rapport_orientation_' . $orientationId . '_' . date('YmdHis') . '.pdf';
        $filepath = RAPPORTS_DIR . '/' . $filename;
        
        if (!is_dir(RAPPORTS_DIR)) {
            mkdir(RAPPORTS_DIR, 0755, true);
        }

        file_put_contents($filepath, $dompdf->output());

        // Mettre à jour le chemin en BD
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("UPDATE orientations SET rapport_pdf_path = ? WHERE id = ?");
        $stmt->execute([$filename, $orientationId]);

        return $filepath;
    }

    /**
     * Générer un PDF de liste (export préinscriptions)
     */
    public static function generateListePDF($data, $titre = 'Liste des préinscrits') {
        $html = self::getListeTemplate($data, $titre);
        
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('defaultFont', 'Helvetica');

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        return $dompdf->output();
    }

    /**
     * Template HTML pour le rapport d'orientation
     */
    private static function getOrientationTemplate($orientation) {
        $filieres = $orientation['filieres_recommandees'] ?? 'Aucune filière recommandée';
        $date = date('d/m/Y', strtotime($orientation['created_at']));
        
        return '<!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <style>
                body { font-family: Helvetica, Arial, sans-serif; color: #1a1a2e; line-height: 1.6; margin: 0; padding: 0; }
                .header { background: linear-gradient(135deg, #180391, #5c0000); color: white; padding: 30px 40px; }
                .header h1 { margin: 0; font-size: 24px; }
                .header p { margin: 5px 0 0; opacity: 0.8; font-size: 12px; }
                .content { padding: 30px 40px; }
                .section { margin-bottom: 25px; }
                .section-title { color: #180391; font-size: 16px; font-weight: bold; border-bottom: 3px solid #FFD700; padding-bottom: 8px; margin-bottom: 15px; }
                .info-grid { display: table; width: 100%; }
                .info-row { display: table-row; }
                .info-label { display: table-cell; padding: 6px 15px 6px 0; font-weight: bold; color: #555; width: 180px; font-size: 13px; }
                .info-value { display: table-cell; padding: 6px 0; font-size: 13px; }
                .filiere-card { background: #f0f0ff; border-left: 4px solid #180391; padding: 15px; margin-bottom: 12px; border-radius: 4px; }
                .filiere-card h3 { margin: 0 0 5px; color: #180391; font-size: 14px; }
                .filiere-card p { margin: 3px 0; font-size: 12px; color: #555; }
                .footer { background: #f5f5f5; padding: 20px 40px; font-size: 11px; color: #888; border-top: 2px solid #FFD700; }
                .badge { display: inline-block; background: #FFD700; color: #180391; padding: 3px 10px; border-radius: 12px; font-size: 11px; font-weight: bold; }
            </style>
        </head>
        <body>
            <div class="header">
                <h1>📄 Rapport d\'Orientation — UCAO</h1>
                <p>Université Catholique de l\'Afrique de l\'Ouest — Généré le ' . $date . '</p>
            </div>
            <div class="content">
                <div class="section">
                    <div class="section-title">Informations Personnelles</div>
                    <div class="info-grid">
                        <div class="info-row"><div class="info-label">Nom :</div><div class="info-value">' . e($orientation['nom']) . '</div></div>
                        <div class="info-row"><div class="info-label">Prénom :</div><div class="info-value">' . e($orientation['prenom']) . '</div></div>
                        <div class="info-row"><div class="info-label">Email :</div><div class="info-value">' . e($orientation['email']) . '</div></div>
                        <div class="info-row"><div class="info-label">Téléphone :</div><div class="info-value">' . e($orientation['telephone']) . '</div></div>
                        <div class="info-row"><div class="info-label">Série du Bac :</div><div class="info-value"><span class="badge">' . e($orientation['serie_bac']) . '</span></div></div>
                    </div>
                </div>

                <div class="section">
                    <div class="section-title">Métier Souhaité</div>
                    <p style="font-size: 16px; font-weight: bold; color: #180391;">' . e($orientation['metier_souhaite']) . '</p>
                </div>

                <div class="section">
                    <div class="section-title">Filières Recommandées</div>
                    <div class="filiere-card">
                        <p>' . e($filieres) . '</p>
                    </div>
                </div>

                <div class="section">
                    <div class="section-title">Pourquoi Choisir l\'UCAO ?</div>
                    <p style="font-size: 13px;">L\'UCAO offre un environnement académique d\'excellence, reconnu dans toute l\'Afrique de l\'Ouest. Avec plus de 45 formations, un taux d\'insertion professionnelle de 95% et un réseau de partenaires internationaux, votre avenir commence ici.</p>
                </div>

                <div class="section">
                    <div class="section-title">Prochaines Étapes</div>
                    <p style="font-size: 13px;">1. Consultez en détail les filières recommandées sur notre site<br>
                    2. Effectuez votre pré-inscription en ligne<br>
                    3. Préparez votre dossier (relevés de notes, diplômes, pièce d\'identité)<br>
                    4. Notre équipe vous contactera pour finaliser votre inscription</p>
                </div>
            </div>
            <div class="footer">
                <strong>UCAO-UUC</strong> — Lot 246 St Jean, Cotonou | Tél: +229 01 21 60 40 70 | Email: contact@ucaobenin.org<br>
                Ce rapport a été généré automatiquement par la plateforme UCAO-Orientation. © ' . date('Y') . '
            </div>
        </body>
        </html>';
    }

    /**
     * Template HTML pour la liste des préinscrits
     */
    private static function getListeTemplate($data, $titre) {
        $rows = '';
        foreach ($data as $i => $row) {
            $bg = $i % 2 === 0 ? '#ffffff' : '#f8f9fc';
            $rows .= '<tr style="background:' . $bg . ';">
                <td style="padding:6px 10px;border-bottom:1px solid #eee;font-size:11px;">' . ($i + 1) . '</td>
                <td style="padding:6px 10px;border-bottom:1px solid #eee;font-size:11px;">' . e($row['nom'] . ' ' . $row['prenom']) . '</td>
                <td style="padding:6px 10px;border-bottom:1px solid #eee;font-size:11px;">' . e($row['email']) . '</td>
                <td style="padding:6px 10px;border-bottom:1px solid #eee;font-size:11px;">' . e($row['telephone']) . '</td>
                <td style="padding:6px 10px;border-bottom:1px solid #eee;font-size:11px;">' . e($row['serie_bac']) . '</td>
                <td style="padding:6px 10px;border-bottom:1px solid #eee;font-size:11px;">' . e($row['nom_filiere'] ?? 'N/A') . '</td>
                <td style="padding:6px 10px;border-bottom:1px solid #eee;font-size:11px;">' . e($row['niveau_entree']) . '</td>
                <td style="padding:6px 10px;border-bottom:1px solid #eee;font-size:11px;">' . date_fr($row['created_at'], 'd/m/Y') . '</td>
            </tr>';
        }

        return '<!DOCTYPE html>
        <html lang="fr">
        <head><meta charset="UTF-8">
        <style>
            body { font-family: Helvetica, Arial, sans-serif; margin: 0; padding: 20px; font-size: 12px; }
            h1 { color: #180391; font-size: 18px; border-bottom: 3px solid #FFD700; padding-bottom: 8px; }
            table { width: 100%; border-collapse: collapse; margin-top: 15px; }
            th { background: #180391; color: white; padding: 8px 10px; text-align: left; font-size: 11px; }
            .footer { margin-top: 20px; font-size: 10px; color: #999; text-align: center; }
        </style>
        </head>
        <body>
            <h1>' . e($titre) . '</h1>
            <p style="color:#666;">Généré le ' . date('d/m/Y à H:i') . ' — Total : ' . count($data) . ' enregistrement(s)</p>
            <table>
                <thead><tr><th>#</th><th>Nom Prénom</th><th>Email</th><th>Téléphone</th><th>Série Bac</th><th>Filière</th><th>Niveau</th><th>Date</th></tr></thead>
                <tbody>' . $rows . '</tbody>
            </table>
            <div class="footer">UCAO-Orientation — Document confidentiel — © ' . date('Y') . '</div>
        </body></html>';
    }
}
