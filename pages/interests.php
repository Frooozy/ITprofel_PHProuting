<?php
$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $id = $_POST['id'] ?? null;

    if (!empty($name)) {
        // Kontrola duplicity v databázi
        $check = $db->prepare("SELECT id FROM interests WHERE name = ? AND id != ?");
        $check->execute([$name, $id ?? -1]);
        
        if ($check->fetch()) {
            $error = "Tento zájem již v seznamu existuje!";
        } else {
            if ($id) {
                // Editace stávajícího 
                $stmt = $db->prepare("UPDATE interests SET name = ? WHERE id = ?");
                $stmt->execute([$name, $id]);
                $status = "updated";
            } else {
                // Přidání nového [cite: 67]
                $stmt = $db->prepare("INSERT INTO interests (name) VALUES (?)");
                $stmt->execute([$name]);
                $status = "added";
            }
            // PRG Pattern: přesměrování po úspěchu [cite: 71]
            header("Location: ?page=interests&status=$status");
            exit;
        }
    }
}

// ... zbytek kódu pro načtení seznamu a zobrazení formuláře ...
?>

<?php if ($error): ?>
    <div class="alert" style="background-color: #f8d7da; color: #721c24; border-color: #f5c6cb;">
        <?= htmlspecialchars($error) ?>
    </div>
<?php endif; ?>