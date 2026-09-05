<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - InventoryX</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <script>
        (function() {
            const theme = localStorage.getItem('theme') || 'dark';
            document.documentElement.setAttribute('data-theme', theme);
        })();
    </script>
    <style>
        body {
            justify-content: center;
            align-items: center;
            background-color: var(--bg-main);
            background-image: radial-gradient(at 0% 0%, hsla(253,16%,7%,1) 0, transparent 50%), 
                              radial-gradient(at 50% 0%, hsla(225,39%,30%,1) 0, transparent 50%), 
                              radial-gradient(at 100% 0%, hsla(339,49%,30%,1) 0, transparent 50%);
        }
        [data-theme="light"] body {
            background-image: radial-gradient(at 0% 0%, hsla(210,40%,98%,1) 0, transparent 50%), 
                              radial-gradient(at 50% 0%, hsla(210,40%,90%,1) 0, transparent 50%), 
                              radial-gradient(at 100% 0%, hsla(210,40%,95%,1) 0, transparent 50%);
        }
        .login-card {
            background: var(--bg-card);
            backdrop-filter: blur(10px);
            padding: 3rem;
            border-radius: 1.5rem;
            border: 1px solid var(--border);
            width: 100%;
            max-width: 400px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }
        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        .login-header i {
            font-size: 3rem;
            color: var(--primary);
            margin-bottom: 1rem;
        }
        .login-header h2 {
            font-size: 1.5rem;
            font-weight: 700;
        }
        .login-header p {
            color: var(--text-muted);
            font-size: 0.875rem;
        }
        .error-msg {
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
            padding: 0.75rem;
            border-radius: 0.5rem;
            margin-bottom: 1rem;
            display: none;
            text-align: center;
            font-size: 0.875rem;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="login-header">
            <i class="fas fa-boxes-stacked"></i>
            <h2>Welcome Back</h2>
            <p>Access your inventory dashboard</p>
        </div>
        
        <div id="errorMsg" class="error-msg"></div>

        <form id="loginForm">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control" placeholder="Enter your username" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control" placeholder="••••••••" required>
            </div>
            <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; margin-top: 1rem;">
                <i class="fas fa-sign-in-alt"></i> Sign In
            </button>
        </form>

        <div style="margin-top: 1.5rem; text-align: center; font-size: 0.875rem; color: var(--text-muted);">
            Don't have an account? <a href="register.php" style="color: var(--primary); text-decoration: none;">Register Staff</a>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $('#loginForm').on('submit', function(e) {
            e.preventDefault();
            const formData = $(this).serialize() + '&action=login';
            
            const btn = $(this).find('button');
            const originalText = btn.html();
            btn.html('<i class="fas fa-spinner fa-spin"></i> Signing In...').prop('disabled', true);
            $('#errorMsg').hide();

            $.ajax({
                url: 'api/users_handler.php',
                type: 'POST',
                data: formData,
                success: function(response) {
                    if (response.success) {
                        window.location.href = 'index.php';
                    } else {
                        $('#errorMsg').text(response.message).fadeIn();
                        btn.html(originalText).prop('disabled', false);
                    }
                },
                error: function() {
                    $('#errorMsg').text('An error occurred. Please try again.').fadeIn();
                    btn.html(originalText).prop('disabled', false);
                }
            });
        });
    </script>
</body>
</html>
