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

        $pdo = Database::getInstance();
        $stmtM = $pdo->prepare("SELECT id FROM metiers WHERE nom_metier LIKE ? LIMIT 1");
        $stmtM->execute(['%' . $orientation['metier_souhaite'] . '%']);
        $metier = $stmtM->fetch();

        $filieres_details = [];
        if ($metier) {
            $stmtF = $pdo->prepare("
                SELECT f.nom_filiere, f.ecole_faculte, f.description, f.niveau, f.duree, f.competences, f.debouches
                FROM filieres f
                JOIN metiers_filieres mf ON f.id = mf.filiere_id
                WHERE mf.metier_id = ?
            ");
            $stmtF->execute([$metier['id']]);
            $filieres_details = $stmtF->fetchAll();
        }

        $html = self::getOrientationTemplate($orientation, $filieres_details);
        
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
        $stmtUpdate = $pdo->prepare("UPDATE orientations SET rapport_pdf_path = ? WHERE id = ?");
        $stmtUpdate->execute([$filename, $orientationId]);

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
     * Générer un PDF de liste des orientations
     */
    public static function generateOrientationsListePDF($data, $titre = 'Liste des orientations') {
        $html = self::getOrientationsListeTemplate($data, $titre);

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
    private static function getOrientationTemplate($orientation, $filieres_details = []) {
        $date = date('d/m/Y', strtotime($orientation['created_at']));

        // Encoder le logo en base64 pour DOMPDF
        $logoPath = APP_ROOT . '/admin/assets/images/logo-ucao.png';
        $logoData = '';
        if (file_exists($logoPath)) {
            $logoData = 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath));
        }

        $htmlFilieres = '';
        if (!empty($filieres_details)) {
            foreach ($filieres_details as $f) {
                // Formatting specific fields if empty
                $niveau = !empty($f['niveau']) ? $f['niveau'] : 'Baccalauréat';
                $duree = !empty($f['duree']) ? $f['duree'] : '3 ans (Licence)';
                $desc = !empty($f['description']) ? nl2br(e($f['description'])) : '<em>Description non disponible</em>';
                $deb = !empty($f['debouches']) ? nl2br(e($f['debouches'])) : '<em>Non renseigné</em>';
                $competences = !empty($f['competences']) ? nl2br(e($f['competences'])) : '<em>Non renseigné</em>';

                $htmlFilieres .= '
                <div class="filiere-card-detail">
                    <h3 class="filiere-title">' . e($f['nom_filiere']) . '</h3>
                    <div class="filiere-ecole">Établissement : ' . e($f['ecole_faculte']) . '</div>
                    <div class="filiere-desc">' . $desc . '</div>
                    
                    <table class="filiere-table">
                        <tr>
                            <td class="filiere-td-label">Diplôme à obtenir :</td><td class="filiere-td-val">' . e($niveau) . '</td>
                            <td class="filiere-td-label">Durée :</td><td class="filiere-td-val">' . e($duree) . '</td>
                        </tr>
                    </table>

                    <div style="font-size: 11px; padding-left:10px; margin-bottom: 6px;">
                        <strong style="color:#180391;">Compétences acquises :</strong><br>' . $competences . '
                    </div>
                    <div style="font-size: 11px; padding-left:10px;">
                        <strong style="color:#180391;">Débouchés professionnels :</strong><br>' . $deb . '
                    </div>
                </div>';
            }
        } else {
            // Support texte fallback
            $texte = $orientation['filieres_recommandees'] ?? 'Aucune filière exacte trouvée pour ce métier.';
            $htmlFilieres = '<div class="filiere-card-detail"><p>' . e($texte) . '</p></div>';
        }

        return '<!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <style>
                body { font-family: Helvetica, Arial, sans-serif; color: #1a1a2e; line-height: 1.5; margin: 0; padding: 0; }
                .header { background-color: #5c0000; color: white; padding: 20px 40px; border-bottom: 5px solid #FFD700; }
                .header-inner { display: table; width: 100%; }
                .header-logo { display: table-cell; vertical-align: middle; width: 80px; }
                .header-logo img { max-height: 70px; }
                .header-text { display: table-cell; vertical-align: middle; text-align: right; }
                .header h1 { margin: 0 0 5px 0; font-size: 22px; text-transform: uppercase; letter-spacing: 1px; }
                .header p { margin: 0; font-size: 12px; }
                .content { padding: 30px 40px; }
                .section { margin-bottom: 25px; }
                
                .section-title { 
                    color: #5c0000; 
                    font-size: 16px; 
                    font-weight: bold; 
                    border-bottom: 2px solid #e1e1e1; 
                    padding-bottom: 5px; 
                    margin-bottom: 15px; 
                    text-transform: uppercase;
                }
                
                .info-grid { display: table; width: 100%; margin-bottom: 10px; }
                .info-row { display: table-row; }
                .info-label { display: table-cell; padding: 4px 10px 4px 0; font-weight: bold; color: #444; width: 150px; font-size: 12px; border-bottom: 1px dashed #eee; }
                .info-value { display: table-cell; padding: 4px 0; font-size: 13px; border-bottom: 1px dashed #eee; }
                
                .metier-box { background: #fdfbf1; border: 1px solid #FFD700; padding: 15px; text-align: center; font-size: 16px; font-weight: bold; color: #180391; margin-bottom: 25px; border-radius: 5px; }
                
                .filiere-card-detail { background: #ffffff; border: 1px solid #e8e8e8; border-left: 5px solid #180391; padding: 15px; margin-bottom: 18px; border-radius: 4px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
                .filiere-title { margin: 0 0 2px 0; color: #180391; font-size: 15px; }
                .filiere-ecole { font-size: 11px; color: #888; font-style: italic; margin-bottom: 8px; border-bottom: 1px solid #eee; padding-bottom: 5px; }
                .filiere-desc { font-size: 12px; color: #555; margin-bottom: 10px; text-align: justify; }
                .filiere-table { width: 100%; font-size: 11px; margin-bottom: 10px; background: #fafafa; border: 1px solid #eee; }
                .filiere-td-label { padding: 5px; font-weight: bold; width: 25%; color: #333; }
                .filiere-td-val { padding: 5px; width: 25%; }
                
                .arg-box p { font-size: 12px; margin: 0 0 8px 0; text-align: justify; }
                .arg-list { font-size: 12px; margin: 0; padding-left: 20px; }
                
                .footer { background: #1a1a2e; padding: 20px 40px; font-size: 10px; color: #ccc; text-align: center; }
                .badge { display: inline-block; background: #FFD700; color: #1a1a2e; padding: 2px 8px; border-radius: 10px; font-size: 11px; font-weight: bold; }
            </style>
        </head>
        <body>
            <div class="header">
                <div class="header-inner">
                    <div class="header-logo">
                        ' . ($logoData ? '<img src="' . $logoData . '" alt="UCAO">' : '') . '
                    </div>
                    <div class="header-text">
                        <h1>Rapport d\'Orientation</h1>
                        <p>Universite Catholique de l\'Afrique de l\'Ouest — ' . $date . '</p>
                    </div>
                </div>
            </div>
            
            <div class="content">
                <div class="section">
                    <div class="section-title">1. Informations Personnelles</div>
                    <div class="info-grid">
                        <div class="info-row"><div class="info-label">Nom(s) & Prénom(s) :</div><div class="info-value">' . e($orientation['nom'] . ' ' . $orientation['prenom']) . '</div></div>
                        <div class="info-row"><div class="info-label">Email de contact :</div><div class="info-value">' . e($orientation['email']) . '</div></div>
                        <div class="info-row"><div class="info-label">Téléphone :</div><div class="info-value">' . e($orientation['telephone']) . '</div></div>
                        <div class="info-row"><div class="info-label">Série du Baccalauréat :</div><div class="info-value"><span class="badge">' . e($orientation['serie_bac']) . '</span></div></div>
                    </div>
                </div>

                <div class="section">
                    <div class="section-title">2. Résumé du Profil</div>
                    <div class="metier-box">
                        Métier souhaité : ' . e(mb_strtoupper($orientation['metier_souhaite'], 'UTF-8')) . '
                    </div>
                </div>

                <div class="section">
                    <div class="section-title">3. Filières Recommandées</div>
                    ' . $htmlFilieres . '
                </div>

                <div class="section">
                    <div class="section-title">4. Pourquoi choisir l\'UCAO ?</div>
                    <div class="arg-box">
                            <ul class="arg-list">
                                <li><strong>Qualité Académique Reconnue</strong> : Les diplômes sont accrédités par le CAMES et l\'ANAQ-Sup, garantissant une formation de haut niveau (LMD et BTS).</li>
                                <li><strong>Approche Holistique</strong> : L\'éducation intègre la foi, la science et l\'action pour former des leaders intègres.</li>
                                <li><strong>Formation Pratique</strong> : L\'université met l\'accent sur le lien entre la théorie et la pratique, notamment en droit (avec le club OHADA) et en gestion/audit financier.</li>
                                <li><strong>Environnement Épanouissant</strong> : Elle propose un cadre propice à l\'épanouissement intellectuel et spirituel, stimulant la réussite des étudiants.</li>
                                <li><strong>Engagement Professionnel</strong> : L\'UCAO-UUC prépare à des carrières prometteuses grâce à des programmes innovants et une recherche engagée.</li>
                            </ul>
                    </div>
                </div>

                <div class="section" style="page-break-inside: avoid;">
                    <div class="section-title">5. Prochaines Etapes</div>
                    <div class="arg-box">
                        <ol class="arg-list" style="margin-left:5px;">
                            <li>Explorez davantage les filieres listees ci-dessus sur notre site web.</li>
                            <li><strong>Procedez a votre preinscription gratuite</strong> sur notre plateforme officielle.</li>
                            <li>Rassemblez vos releves de notes, diplomes et documents de candidature.</li>
                            <li>Discutez avec nos conseillers pedagogiques si vous avez la moindre interrogation.</li>
                        </ol>
                    </div>
                </div>

                <div class="section" style="page-break-inside: avoid;">
                    <div class="section-title">6. Preinscription en Ligne</div>
                    <div style="background-color: #180391; padding: 20px; border-radius: 8px; text-align: center;">
                        <p style="color: #FFD700; font-size: 14px; margin: 0 0 10px 0; font-weight: bold;">Demarrez votre parcours a l\'UCAO des maintenant !</p>
                        <p style="color: white; font-size: 12px; margin: 0 0 15px 0;">Accedez a notre plateforme d\'orientation et preinscription :</p>
                        <div style="background-color: #FFD700; padding: 12px 25px; border-radius: 5px; display: inline-block;">
                            <a href="' . APP_URL . '/preinscription.php" style="color: #180391; font-weight: bold; font-size: 13px; text-decoration: none;">' . APP_URL . '/preinscription.php</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="footer">
                <strong>UCAO-UUC</strong> — Lot 246 St Jean, Cotonou<br>
                Téléphone : +229 01 21 60 40 70 | Email : contact@ucaobenin.org<br>
                <div style="margin-top:10px; font-size:9px; color:#888;">Ce rapport a été généré automatiquement par la plateforme décisionnelle UCAO-Orientation. © ' . date('Y') . '</div>
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
                <td style="padding:8px 10px;border-bottom:1px solid #eee;font-size:11px;text-align:center">' . ($i + 1) . '</td>
                <td style="padding:8px 10px;border-bottom:1px solid #eee;font-size:11px;font-weight:bold">' . e($row['nom'] . ' ' . $row['prenom']) . '</td>
                <td style="padding:8px 10px;border-bottom:1px solid #eee;font-size:11px">' . e($row['email']) . '</td>
                <td style="padding:8px 10px;border-bottom:1px solid #eee;font-size:11px">' . e($row['telephone']) . '</td>
                <td style="padding:8px 10px;border-bottom:1px solid #eee;font-size:11px;text-align:center"><span style="background:#FFD700;padding:2px 8px;border-radius:10px;font-size:10px">' . e($row['serie_bac']) . '</span></td>
                <td style="padding:8px 10px;border-bottom:1px solid #eee;font-size:11px">' . e($row['nom_filiere'] ?? 'N/A') . '</td>
                <td style="padding:8px 10px;border-bottom:1px solid #eee;font-size:11px;text-align:center">' . e($row['niveau_entree']) . '</td>
                <td style="padding:8px 10px;border-bottom:1px solid #eee;font-size:11px;text-align:center">' . date_fr($row['created_at'], 'd/m/Y') . '</td>
            </tr>';
        }

        $logoPath = APP_ROOT . '/admin/assets/images/logo-ucao.png';
        $logoData = '';
        if (file_exists($logoPath)) {
            $logoData = 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath));
        }

        // Compter par filière
        $filieres = [];
        foreach ($data as $row) {
            $f = $row['nom_filiere'] ?? 'Non définie';
            $filieres[$f] = ($filieres[$f] ?? 0) + 1;
        }

        return '<!DOCTYPE html>
        <html lang="fr">
        <head><meta charset="UTF-8">
        <style>
            body { font-family: Helvetica, Arial, sans-serif; margin: 0; padding: 0; font-size: 12px; }
            .header { background: linear-gradient(135deg, #180391, #5c0000); color: white; padding: 20px 30px; }
            .header-inner { display: table; width: 100%; }
            .header-logo { display: table-cell; vertical-align: middle; width: 60px; }
            .header-logo img { max-height: 50px; }
            .header-text { display: table-cell; vertical-align: middle; }
            .header h1 { margin: 0; font-size: 20px; }
            .header p { margin: 5px 0 0 0; font-size: 11px; opacity: 0.9; }
            .content { padding: 20px 30px; }
            .stats { display: table; width: 100%; margin-bottom: 20px; }
            .stat-box { display: table-cell; background: #f8f9fc; padding: 15px; text-align: center; border: 1px solid #eee; }
            .stat-box h3 { margin: 0; font-size: 24px; color: #180391; }
            .stat-box p { margin: 5px 0 0 0; font-size: 11px; color: #666; }
            table { width: 100%; border-collapse: collapse; }
            th { background: #180391; color: white; padding: 10px; text-align: left; font-size: 11px; }
            .footer { margin-top: 20px; padding: 15px 30px; background: #f8f9fc; font-size: 10px; color: #666; text-align: center; border-top: 3px solid #FFD700; }
        </style>
        </head>
        <body>
            <div class="header">
                <div class="header-inner">
                    <div class="header-logo">' . ($logoData ? '<img src="' . $logoData . '" alt="UCAO">' : '') . '</div>
                    <div class="header-text">
                        <h1>' . e($titre) . '</h1>
                        <p>Généré le ' . date('d/m/Y à H:i') . '</p>
                    </div>
                </div>
            </div>
            <div class="content">
                <div class="stats">
                    <div class="stat-box"><h3>' . count($data) . '</h3><p>Total préinscriptions</p></div>
                    <div class="stat-box"><h3>' . count($filieres) . '</h3><p>Filières différentes</p></div>
                    <div class="stat-box"><h3>' . count(array_unique(array_column($data, 'serie_bac'))) . '</h3><p>Séries de Bac</p></div>
                </div>
                <table>
                    <thead><tr><th style="width:30px;text-align:center">#</th><th>Nom Prénom</th><th>Email</th><th>Téléphone</th><th style="text-align:center">Série</th><th>Filière</th><th style="text-align:center">Niveau</th><th style="text-align:center">Date</th></tr></thead>
                    <tbody>' . $rows . '</tbody>
                </table>
            </div>
            <div class="footer">
                <strong>UCAO-UUC</strong> — Université Catholique de l\'Afrique de l\'Ouest — Cotonou, Bénin<br>
                Document confidentiel — © ' . date('Y') . '
            </div>
        </body></html>';
    }

    /**
     * Template HTML pour la liste des orientations
     */
    private static function getOrientationsListeTemplate($data, $titre) {
        $rows = '';
        foreach ($data as $i => $row) {
            $bg = $i % 2 === 0 ? '#ffffff' : '#f8f9fc';
            $statut = $row['email_envoye'] ? '<span style="color:#28a745;font-weight:bold">Envoyé</span>' : '<span style="color:#ffc107;font-weight:bold">En attente</span>';
            $rows .= '<tr style="background:' . $bg . ';">
                <td style="padding:8px 10px;border-bottom:1px solid #eee;font-size:11px;text-align:center">' . ($i + 1) . '</td>
                <td style="padding:8px 10px;border-bottom:1px solid #eee;font-size:11px;font-weight:bold">' . e($row['nom'] . ' ' . $row['prenom']) . '</td>
                <td style="padding:8px 10px;border-bottom:1px solid #eee;font-size:11px">' . e($row['email']) . '</td>
                <td style="padding:8px 10px;border-bottom:1px solid #eee;font-size:11px">' . e($row['telephone']) . '</td>
                <td style="padding:8px 10px;border-bottom:1px solid #eee;font-size:11px;text-align:center"><span style="background:#FFD700;padding:2px 8px;border-radius:10px;font-size:10px">' . e($row['serie_bac']) . '</span></td>
                <td style="padding:8px 10px;border-bottom:1px solid #eee;font-size:11px">' . e($row['metier_souhaite']) . '</td>
                <td style="padding:8px 10px;border-bottom:1px solid #eee;font-size:11px;text-align:center">' . $statut . '</td>
                <td style="padding:8px 10px;border-bottom:1px solid #eee;font-size:11px;text-align:center">' . date_fr($row['created_at'], 'd/m/Y') . '</td>
            </tr>';
        }

        $logoPath = APP_ROOT . '/admin/assets/images/logo-ucao.png';
        $logoData = '';
        if (file_exists($logoPath)) {
            $logoData = 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath));
        }

        return '<!DOCTYPE html>
        <html lang="fr">
        <head><meta charset="UTF-8">
        <style>
            body { font-family: Helvetica, Arial, sans-serif; margin: 0; padding: 0; font-size: 12px; }
            .header { background: linear-gradient(135deg, #180391, #5c0000); color: white; padding: 20px 30px; }
            .header-inner { display: table; width: 100%; }
            .header-logo { display: table-cell; vertical-align: middle; width: 60px; }
            .header-logo img { max-height: 50px; }
            .header-text { display: table-cell; vertical-align: middle; }
            .header h1 { margin: 0; font-size: 20px; }
            .header p { margin: 5px 0 0 0; font-size: 11px; opacity: 0.9; }
            .content { padding: 20px 30px; }
            .stats { display: table; width: 100%; margin-bottom: 20px; }
            .stat-box { display: table-cell; background: #f8f9fc; padding: 15px; text-align: center; border: 1px solid #eee; }
            .stat-box h3 { margin: 0; font-size: 24px; color: #180391; }
            .stat-box p { margin: 5px 0 0 0; font-size: 11px; color: #666; }
            table { width: 100%; border-collapse: collapse; }
            th { background: #180391; color: white; padding: 10px; text-align: left; font-size: 11px; }
            .footer { margin-top: 20px; padding: 15px 30px; background: #f8f9fc; font-size: 10px; color: #666; text-align: center; border-top: 3px solid #FFD700; }
        </style>
        </head>
        <body>
            <div class="header">
                <div class="header-inner">
                    <div class="header-logo">' . ($logoData ? '<img src="' . $logoData . '" alt="UCAO">' : '') . '</div>
                    <div class="header-text">
                        <h1>' . e($titre) . '</h1>
                        <p>Généré le ' . date('d/m/Y à H:i') . '</p>
                    </div>
                </div>
            </div>
            <div class="content">
                <div class="stats">
                    <div class="stat-box"><h3>' . count($data) . '</h3><p>Total orientations</p></div>
                    <div class="stat-box"><h3>' . count(array_filter($data, fn($r) => $r['email_envoye'])) . '</h3><p>Emails envoyés</p></div>
                    <div class="stat-box"><h3>' . count(array_filter($data, fn($r) => !$r['email_envoye'])) . '</h3><p>En attente</p></div>
                </div>
                <table>
                    <thead><tr><th style="width:30px;text-align:center">#</th><th>Nom Prénom</th><th>Email</th><th>Téléphone</th><th style="text-align:center">Série</th><th>Métier souhaité</th><th style="text-align:center">Statut</th><th style="text-align:center">Date</th></tr></thead>
                    <tbody>' . $rows . '</tbody>
                </table>
            </div>
            <div class="footer">
                <strong>UCAO-UUC</strong> — Université Catholique de l\'Afrique de l\'Ouest — Cotonou, Bénin<br>
                Document confidentiel — © ' . date('Y') . '
            </div>
        </body></html>';
    }
}