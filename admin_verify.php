<?php
require_once 'includes/db.php';
require_once 'includes/auth.php';

requireAdmin();

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['password'] ?? '';
    
    // Fetch current user from DB to verify password
    $stmt = $pdo->prepare("SELECT password FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['admin_verified_at'] = time();
        $redirect = $_SESSION['redirect_after_verify'] ?? 'users.php';
        unset($_SESSION['redirect_after_verify']);
        header("Location: $redirect");
        exit();
    } else {
        $error = "Invalid password. Access denied.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Admin - InventoryX</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        body { justify-content: center; align-items: center; background: #0f172a; }
        .verify-card {
            background: var(--dark-lite);
            padding: 2.5rem;
            border-radius: 1rem;
            border: 1px solid var(--border);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }
        .icon { font-size: 3rem; color: var(--primary); margin-bottom: 1rem; }
        .alert { padding: 0.75rem; border-radius: 0.5rem; margin-bottom: 1rem; background: rgba(239, 68, 68, 0.1); color: #ef4444; font-size: 0.875rem; }
    </style>
</head>
<body>
    <div class="verify-card">
        <div class="icon"><i class="fas fa-shield-halved"></i></div>
        <h2>Confirm Access</h2>
        <p style="color: var(--text-muted); margin-bottom: 2rem; font-size: 0.875rem;">Please enter your password to continue to User Management</p>

        <?php if ($error): ?>
            <div class="alert"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group" style="text-align: left;">
                <label>Admin Password</label>
                <input type="password" name="password" class="form-control" placeholder="••••••••" required autofocus>
            </div>
            <div style="display: flex; gap: 1rem; margin-top: 2rem;">
                <a href="index.php" class="btn btn-secondary" style="flex: 1; justify-content: center;">Cancel</a>
                <button type="submit" class="btn btn-primary" style="flex: 2; justify-content: center;">Verify Password</button>
            </div>
        </form>
    </div>
</body>
</html>
