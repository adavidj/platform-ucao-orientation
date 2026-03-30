# Guide Anti-Panique Dev Web (PHP + JS + SQL + SMTP + Deploy)

Objectif: garder la maitrise en incident, corriger vite, sans casser le reste.

## 1) Methode universelle (R-I-C-V)

1. Reproduire
- Refaire l'erreur avec un cas simple et note exacte du message.

2. Isoler
- Identifier la couche en echec: Front, API/Handler, PHP runtime, DB, SMTP, infra.

3. Corriger minimum
- Un changement a la fois, petit et reversible.

4. Verifier
- Re-test du cas initial + 1 test de non-regression.

Regle d'or: symptome != cause. Prouver la cause avec un test court.

---

## 2) Checklist de triage express (5 minutes)

1. Quelle URL casse?
2. Quel code HTTP?
3. Le serveur renvoie JSON, HTML, ou rien?
4. Erreur en console navigateur?
5. Erreur dans logs PHP/Apache/Nginx?

Commandes utiles:

```powershell
# Processus/ports
netstat -ano | findstr :80
netstat -ano | findstr :443

# PHP CLI
php -v
php --ini
php -m

# Syntaxe rapide
php -l "handlers/contact-handler.php"
php -l "classes/Mailer.php"
```

---

## 3) Frontend (JS/fetch)

Symptomes courants:
- "Network Error"
- JSON parse error
- CORS

Procedure:
1. Verifier `form.action` et methode HTTP.
2. Logger status, content-type, body.
3. Ne parser JSON que si `content-type` contient `application/json`.
4. Afficher une erreur utilisateur claire.

Snippet robuste:

```javascript
fetch(url, options)
  .then(async (response) => {
    const ct = response.headers.get('content-type') || '';
    const text = await response.text();

    if (!ct.includes('application/json')) {
      throw new Error(`Reponse non JSON (${response.status}) -> ${text.slice(0, 200)}`);
    }

    const data = JSON.parse(text);
    if (!response.ok) {
      throw new Error(data.message || `HTTP ${response.status}`);
    }
    return data;
  });
```

---

## 4) Backend PHP (handlers)

Checklist:
1. Verifier la methode (`POST`, `GET`).
2. Valider les entrees (null, vide, format).
3. Toujours retourner une structure JSON stable.
4. Eviter les constantes depreciees (ex: `FILTER_SANITIZE_STRING`).
5. Capturer exceptions et logger la vraie erreur.

Pattern JSON stable:

```php
header('Content-Type: application/json; charset=utf-8');

try {
    // traitement
    echo json_encode(['success' => true, 'message' => 'OK']);
} catch (Throwable $e) {
    http_response_code(500);
    error_log($e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Erreur serveur']);
}
```

---

## 5) Base de donnees (MySQL)

Symptomes:
- Table inexistante
- Colonne inconnue
- Connexion refusee

Procedure:
1. Confirmer les variables `.env` DB.
2. Tester connexion avec script court.
3. Verifier structure (`DESCRIBE table`).
4. Verifier charset/collation.

Commandes utiles:

```sql
SHOW TABLES;
DESCRIBE messages_contact;
SELECT COUNT(*) FROM messages_contact;
```

---

## 6) SMTP / Email

Symptomes:
- Class not found
- Authentication failed
- Connection timeout
- Wrong version number

Procedure:
1. Verifier autoload (`vendor/autoload.php`).
2. Verifier PHPMailer present (Composer ou dossier manuel).
3. Verifier `.env` SMTP complet.
4. Aligner port/chiffrement:
- 587 -> tls
- 465 -> ssl
5. Monter temporairement `SMTP_DEBUG=2`.

---

## 7) Composer / Dependances

Procedure:
1. Verifier quel PHP CLI est utilise.
2. Verifier extensions critiques: openssl, zip.
3. Installer via le bon binaire PHP.

Commandes utiles:

```powershell
Get-Command php | Select-Object -ExpandProperty Source
php --ini
php -m | Select-String -Pattern "openssl|zip"
& "C:\xampp\php\php.exe" .\composer install --no-interaction
```

---

## 8) Infra locale (XAMPP/WAMP)

Checklist:
1. Apache demarre?
2. MySQL demarre?
3. Bon virtual host/DocumentRoot?
4. URL de projet correcte?
5. Permissions ecriture sur dossiers upload/log?

---

## 9) Non-regression minimum avant de livrer

1. Le flux casse est corrige.
2. Un flux voisin est toujours OK.
3. Syntaxe PHP sans erreur.
4. Logs propres (pas d'erreur fatale).
5. Config sensible non committee (`.env` ignore).

---

## 10) Template d'incident a reutiliser

- Date/heure:
- Contexte:
- Symptome:
- Couche impactee:
- Cause racine:
- Correctif minimal:
- Verification:
- Prevention:

---

## 11) Playbook personnel anti-stress

1. Respirer 30 secondes, relire l'erreur exacte.
2. Ouvrir une note et ecrire hypothese A/B/C.
3. Tester A avec une commande rapide.
4. Si faux, passer a B (sans bricoler partout).
5. Apres fix, noter la lecon dans un guide.

Formule mentale:
"Je ne devine pas, je verifie."

---

## 12) Mini arbre de decision

1. Front dit "Network Error"
- verifier URL, status HTTP, content-type.

2. Backend dit "Class ... not found"
- verifier autoload et dependances.

3. Backend dit "SQLSTATE..."
- verifier schema + donnees + permissions DB.

4. SMTP dit "Auth failed"
- verifier user/pass + from autorise.

5. Timeout connexion
- verifier host/port/firewall.

---

Ce document est pense pour execution rapide en situation reelle.
L'objectif n'est pas d'avoir raison vite, mais de trouver vrai vite.
