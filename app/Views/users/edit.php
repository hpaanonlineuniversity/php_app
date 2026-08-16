<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit User</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; }
        input { width: 300px; padding: 8px; }
        button { padding: 8px 15px; background: #007bff; color: white; border: none; cursor: pointer; }
        .note { font-size: 0.85em; color: #666; }
    </style>
</head>
<body>
    <h2>Edit User</h2>

    <form action="/user/update/<?= htmlspecialchars($user['id']) ?>" method="POST">
        <!-- CSRF Token -->
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">

        <div class="form-group">
            <label>Name:</label>
            <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>" required>
        </div>

        <div class="form-group">
            <label>Email:</label>
            <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
        </div>

        <div class="form-group">
            <label>New Password:</label>
            <input type="password" name="password">
            <div class="note">* Password မပြောင်းလိုပါက လွတ်ထားခဲ့ပါ။</div>
        </div>

        <button type="submit">Update User</button>
        <a href="/user/index">Cancel</a>
    </form>
</body>
</html>
