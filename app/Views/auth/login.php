<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 50px; background: #f8f9fa; }
        .login-card { width: 320px; padding: 20px; background: white; margin: 0 auto; border-radius: 5px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; }
        input { width: 100%; padding: 8px; box-sizing: border-box; }
        button { width: 100%; padding: 8px; background: #007bff; color: white; border: none; cursor: pointer; border-radius: 4px; }
        .error { color: red; margin-bottom: 15px; font-size: 0.9em; }
    </style>
</head>
<body>
    <div class="login-card">
        <h2>System Login</h2>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="error"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <form action="/auth/authenticate" method="POST">
            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">

            <div class="form-group">
                <label>Email:</label>
                <input type="email" name="email" required>
            </div>

            <div class="form-group">
                <label>Password:</label>
                <input type="password" name="password" required>
            </div>

            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
