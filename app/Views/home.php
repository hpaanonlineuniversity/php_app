<!DOCTYPE html>
<html>
<head>
    <title><?= $title ?></title>
</head>
<body>
    <h1>User List</h1>
    
    <?php if (!empty($users)): ?>
        <ul>
            <?php foreach ($users as $user): ?>
                <li><?= htmlspecialchars($user['name']) ?> - <?= htmlspecialchars($user['email']) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No users found.</p>
    <?php endif; ?>
</body>
</html>