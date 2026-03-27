<?php
// =================================================================
// CONFIGURATION & DATA
// =================================================================

// Global Site Variables
$site_name = "UCAO - Orientation";
$site_logo_path = "assets/images/logo-ucao.png";
$site_lang = "fr";
$site_charset = "UTF-8";
$primary_font = "'Poppins', sans-serif";
$secondary_font = "'Open Sans', sans-serif";

// Color Palette
$colors = [
    'couleur_primaire' => '#180391',
    'couleur_secondaire' => '#8B0000',
    'couleur_primaire_light' => '#2a15b3',
    'couleur_primaire_dark' => '#0e0560',
    'couleur_secondaire_light' => '#b30000',
    'couleur_secondaire_dark' => '#5c0000',
    'gold' => '#FFD700',
    'white' => '#FFFFFF',
    'light_gray' => '#F8F9FC',
    'medium_gray' => '#E5E8EF',
    'dark_gray' => '#2D3436',
    'text_light' => '#F0F0F0',
    'text_dark' => '#1a1a2e'
];

// Navigation Menu Items (Accueil is added directly in header.php)
$nav_items = [
    ['name' => 'Découvrir l\'UCAO', 'url' => 'decouvrir-ucao.php'],
    ['name' => 'Nos Formations', 'url' => 'nos-formations.php'],
    ['name' => 'Orientation', 'url' => 'orientation.php'],
    ['name' => 'Pré-inscription', 'url' => 'preinscription.php'],
    ['name' => 'À Propos', 'url' => 'a-propos.php'],
    ['name' => 'Contact', 'url' => 'contact.php']
];

// Footer Links
$footer_links = [
    'Menu' => [
        ['name' => 'Accueil', 'url' => 'index.php'],
        ['name' => 'Découvrir l\'UCAO', 'url' => 'decouvrir-ucao.php'],
        ['name' => 'Formations', 'url' => 'nos-formations.php'],
        ['name' => 'Orientation', 'url' => 'orientation.php'],
        ['name' => 'Pré-inscription', 'url' => 'preinscription.php'],
        ['name' => 'À Propos', 'url' => 'a-propos.php']
    ],
    'Contact' => [
        ['name' => '+229 01 21 60 40 70', 'url' => 'tel:+22901216040 70'],
        ['name' => '+229 01 56 35 14 41', 'url' => 'tel:+2290156351441'],
        ['name' => 'contact@ucaobenin.org', 'url' => 'mailto:contact@ucaobenin.org'],
        ['name' => 'Lot 246 St Jean, Cotonou', 'url' => 'contact.php']
    ]
];

// Social Media Links
$social_links = [
    'Facebook' => ['url' => 'https://facebook.com/UCAOBENIN', 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg>'],
    'WhatsApp' => ['url' => 'https://wa.me/22956351441', 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>'],
    'Instagram' => ['url' => 'https://instagram.com/ucaobenin', 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>'],
    'TikTok' => ['url' => 'https://tiktok.com/@ucaouuc', 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1-.1z"/></svg>']
];
