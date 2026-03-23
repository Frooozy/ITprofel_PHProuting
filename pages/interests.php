<?php
/** * LOGIKA (PRG Pattern & CRUD) 
 * Poznámka: Proměnná $db je dostupná z index.php
 */

// 1. MAZÁNÍ (Delete)
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $db->prepare("DELETE FROM interests WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: ?page=interests&status=deleted"); // Redirect
    exit;
}

// 2. PŘIDÁVÁNÍ / EDITACE (Create/Update)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $id = $_POST['id'] ?? null;

    if (!empty($name)) {
        if ($id) {
            // Update
            $stmt = $db->prepare("UPDATE interests SET name = ? WHERE id = ?");
            $stmt->execute([$name, $id]);
            $status = "updated";
        } else {
            // Create
            $stmt = $db->prepare("INSERT INTO interests (name) VALUES (?)");
            $stmt->execute([$name]);
            $status = "added";
        }
        header("Location: ?page=interests&status=$status"); // Redirect (PRG)
        exit;
    }
}

// 3. PŘÍPRAVA DAT PRO EDITACI
$edit_interest = null;
if (isset($_GET['edit'])) {
    $edit_id = (int)$_GET['edit'];
    $stmt = $db->prepare("SELECT * FROM interests WHERE id = ?");
    $stmt->execute([$edit_id]);
    $edit_interest = $stmt->fetch();
}

// 4. NAČTENÍ SEZNAMU (Read)
$interests = $db->query("SELECT * FROM interests ORDER BY id DESC")->fetchAll();
?>

<h2>Správa mých zájmů</h2>

<?php if (isset($_GET['status'])): ?>
    <div class="alert">
        <?php
            if ($_GET['status'] === 'added') echo "Zájem byl úspěšně přidán.";
            if ($_GET['status'] === 'deleted') echo "Zájem byl smazán.";
            if ($_GET['status'] === 'updated') echo "Zájem byl upraven.";
        ?>
    </div>
<?php endif; ?>

<form method="post" action="?page=interests">
    <input type="hidden" name="id" value="<?= $edit_interest['id'] ?? '' ?>">
    <input type="text" name="name" placeholder="Název zájmu" value="<?= $edit_interest['name'] ?? '' ?>" required>
    <button type="submit"><?= $edit_interest ? 'Upravit' : 'Přidat' ?></button>
    <?php if ($edit_interest): ?>
        <a href="?page=interests">Zrušit</a>
    <?php endif; ?>
</form>

<hr>

<ul>
    <?php foreach ($interests as $item): ?>
        <li>
            <?= htmlspecialchars($item['name']) ?>
            <a href="?page=interests&edit=<?= $item['id'] ?>">Editovat</a>
            <a href="?page=interests&delete=<?= $item['id'] ?>" onclick="return confirm('Opravdu smazat?')">Smazat</a>
        </li>
    <?php endforeach; ?>
</ul>