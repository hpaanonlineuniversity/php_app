<!DOCTYPE html>
<html>
<head><title><?= $title ?></title></head>
<body>
    <h1>User List</h1>
    <ul>
        <?php foreach ($users as $user): ?>
            <li><?= htmlspecialchars($user['name']) ?> - <?= htmlspecialchars($user['email']) ?></li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
