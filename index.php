<?php
// Načtení databáze (sdílené pro celou aplikaci)
require "db.php";

// 1. Routing: získání stránky z URL (výchozí je 'home')
$page = $_GET["page"] ?? "home"; [cite: 36]

// 2. Definice povolených stránek
$allowed_pages = ["home", "interests", "skills"];

// 3. Logika pro výběr obsahu
if (in_array($page, $allowed_pages)) {
    $template = "pages/{$page}.php"; [cite: 58]
} else {
    $template = "pages/not_found.php"; [cite: 28, 47]
}
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>IT Profil</title>
    <link rel="stylesheet" href="style.css"> [cite: 29]
</head>
<body>
    <nav> [cite: 52]
        <a href="?page=home">Domů</a> [cite: 54]
        <a href="?page=interests">Zájmy</a> [cite: 55]
        <a href="?page=skills">Dovednosti</a> [cite: 55]
    </nav>

    <main>
        <?php 
        // 5. Vložení obsahu konkrétní stránky
        require $template; [cite: 62] 
        ?>
    </main>
</body>
</html>