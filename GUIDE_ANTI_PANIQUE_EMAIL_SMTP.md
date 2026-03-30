# Guide Anti-Panique SMTP (PHP + PHPMailer)

But: avoir une procedure simple a suivre quand l'email ne part pas.

## 1) Reflexe initial (2 minutes)

1. Lire exactement le message d'erreur.
2. Identifier la couche qui casse:
- Classe introuvable (autoload/dependances)
- Erreur SMTP (identifiants, port, chiffrement)
- Erreur reseau (URL handler, JSON invalide)
3. Ne pas modifier 10 choses a la fois.

## 2) Checklist "Classe PHPMailer introuvable"

1. Verifier dependances:
```powershell
Test-Path "vendor\autoload.php"
Test-Path "PHPMailer\src\PHPMailer.php"
Test-Path "PHPMailer\src\SMTP.php"
Test-Path "PHPMailer\src\Exception.php"
```
2. Si vendor manque: installer via Composer avec le bon PHP.
3. Si installation manuelle: dossier PHPMailer a la racine du projet.
4. Verifier que le fichier mailer charge bien Composer/fallback manuel.

## 3) Checklist "Composer ne marche pas"

1. Verifier quel PHP est utilise:
```powershell
Get-Command php | Select-Object -ExpandProperty Source
php --ini
php -m | Select-String -Pattern "openssl"
```
2. Sur XAMPP, forcer le bon binaire:
```powershell
& "C:\xampp\php\php.exe" --ini
& "C:\xampp\php\php.exe" -m | Select-String -Pattern "openssl"
& "C:\xampp\php\php.exe" .\composer install --no-interaction
```
3. Si erreur zip/unzip: activer ext-zip ou installer 7zip/git (composer peut cloner en source).

## 4) Checklist SMTP (.env)

Variables minimales:
```env
SMTP_HOST=smtp.votre-domaine.com
SMTP_PORT=587
SMTP_USER=no-reply@votre-domaine.com
SMTP_PASS=mot_de_passe_smtp
SMTP_FROM_EMAIL=no-reply@votre-domaine.com
SMTP_FROM_NAME=Nom Projet
SMTP_ENCRYPTION=tls
SMTP_DEBUG=0
```

Regles:
1. Port 587 => tls
2. Port 465 => ssl
3. FROM_EMAIL doit etre autorise par le serveur SMTP
4. En prod: APP_ENV=production

## 5) Checklist cote Front (fetch)

1. Verifier que form.action pointe vers le bon handler.
2. Verifier que la reponse est JSON avant response.json().
3. Logger status HTTP + content-type en cas d'echec.
4. Afficher erreur claire a l'utilisateur.

## 6) Test rapide de non-regression

1. Syntaxe PHP:
```powershell
php -l "classes/Mailer.php"
php -l "handlers/contact-handler.php"
```
2. Soumettre le formulaire de contact avec un vrai email.
3. Verifier:
- message succes cote UI
- email recu utilisateur
- email recu admin
- aucune erreur fatale dans logs PHP

## 7) Arbre de decision express

1. "Class PHPMailer not found" => dependances/autoload.
2. "Could not authenticate" => SMTP_USER/SMTP_PASS faux ou SMTPAuth bloque.
3. "Connection refused / timeout" => host/port/firewall.
4. "Wrong version number" => mauvais couple port/chiffrement.
5. "Network error" front => handler renvoie HTML/erreur fatale au lieu de JSON.

## 8) Routine pro pour ne plus paniquer

1. Reproduire
2. Isoler (une couche)
3. Corriger minimum
4. Re-tester
5. Documenter la cause + fix

Formule mentale:
Symptome != Cause. Toujours prouver la cause avec un test court.

## 9) Commandes utiles a garder

```powershell
# Verifier structure mail
Test-Path "vendor\autoload.php"
Test-Path "PHPMailer\src\PHPMailer.php"

# Verifier environnement PHP
Get-Command php | Select-Object -ExpandProperty Source
php --ini
php -m | Select-String -Pattern "openssl|zip"

# Composer avec PHP XAMPP
& "C:\xampp\php\php.exe" .\composer install --no-interaction

# Validation syntaxe
php -l "classes/Mailer.php"
php -l "handlers/contact-handler.php"
```

## 10) Template de compte-rendu incident

- Erreur observee:
- Couche impactee:
- Cause racine:
- Correctif applique:
- Verification faite:
- Action preventive:

---

Ce guide est volontairement operationnel: suivez la checklist dans l'ordre.
