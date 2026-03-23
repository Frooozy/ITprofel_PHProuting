<?php
// Načtení databáze (sdílené pro celou aplikaci)
require "db.php"; // [cite: 22]

// 1. Routing: získání stránky z URL pomocí $_GET [cite: 33]
// Pokud parametr 'page' neexistuje, nastaví se výchozí hodnota "home" [cite: 36]
$page = $_GET["page"] ?? "home";

// 2. Definice povolených stránek pro zobrazení [cite: 39]
$allowed_pages = ["home", "interests", "skills"];

// 3. Logika pro výběr obsahu (Routing) [cite: 11]
// Kontrola, zda je zadaná stránka v seznamu povolených [cite: 34]
if (in_array($page, $allowed_pages)) {
    $template = "pages/{$page}.php"; // [cite: 59, 60, 61]
} else {
    // Pokud uživatel zadá neexistující stránku, zobrazí se 404 [cite: 46, 47]
    $template = "pages/not_found.php"; // [cite: 28, 50]
}
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IT Profil - <?= ucfirst($page) ?></title>
    <link rel="stylesheet" href="style.css"> </head>
<body>
    <nav>
        <a href="?page=home">Domů</a> <a href="?page=interests">Zájmy</a> <a href="?page=skills">Dovednosti</a> </nav>

    <main>
        <?php 
        // 5. Vložení obsahu konkrétního souboru ze složky pages/ [cite: 62, 63]
        require $template; 
        ?>
    </main>

    <footer>
        <p>&copy; <?= date("Y") ?> Můj IT Profil</p>
    </footer>
</body>
</html>