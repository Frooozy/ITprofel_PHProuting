<?php
/**
 * Připojení k SQLite databázi
 */

try {
    // 1. Vytvoření/otevření souboru s databází
    $db = new PDO('sqlite:database.db');

    // 2. Nastavení vyhazování výjimek v případě chyb
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 3. Automatické vytvoření tabulky, pokud ještě neexistuje
    // (Zajišťuje funkčnost CRUD operací pro interests.php)
    $db->exec("CREATE TABLE IF NOT EXISTS interests (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT NOT NULL
    )");

} catch (PDOException $e) {
    // V případě chyby připojení vypíše hlášku
    die("Chyba připojení k databázi: " . $e->getMessage());
}