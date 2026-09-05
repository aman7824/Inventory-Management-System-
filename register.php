<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Staff - InventoryX</title>
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
        .register-card {
            background: var(--bg-card);
            backdrop-filter: blur(10px);
            padding: 2.5rem;
            border-radius: 1.5rem;
            border: 1px solid var(--border);
            width: 100%;
            max-width: 450px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }
        .register-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        .register-header i {
            font-size: 2.5rem;
            color: var(--primary);
            margin-bottom: 1rem;
        }
        .register-header h2 {
            font-size: 1.5rem;
            font-weight: 700;
        }
        .register-header p {
            color: var(--text-muted);
            font-size: 0.875rem;
        }
        .msg {
            padding: 0.75rem;
            border-radius: 0.5rem;
            margin-bottom: 1rem;
            display: none;
            text-align: center;
            font-size: 0.875rem;
        }
        .msg-error { background: rgba(239, 68, 68, 0.1); color: #ef4444; }
        .msg-success { background: rgba(16, 185, 129, 0.1); color: #10b981; }
    </style>
</head>
<body>
    <div class="register-card">
        <div class="register-header">
            <i class="fas fa-user-plus"></i>
            <h2>Staff Registration</h2>
            <p>Create a new staff member account</p>
        </div>
        
        <div id="msgBox" class="msg"></div>

        <form id="registerForm">
            <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="full_name" class="form-control" placeholder="John Doe" required>
            </div>
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control" placeholder="johndoe123" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control" placeholder="••••••••" required>
            </div>
            <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; margin-top: 1rem;">
                <i class="fas fa-user-check"></i> Register Staff
            </button>
        </form>

        <div style="margin-top: 1.5rem; text-align: center; font-size: 0.875rem; color: var(--text-muted);">
            Already have an account? <a href="login.php" style="color: var(--primary); text-decoration: none;">Sign In</a>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $('#registerForm').on('submit', function(e) {
            e.preventDefault();
            const formData = $(this).serialize() + '&action=register&role=staff';
            
            const btn = $(this).find('button');
            const originalText = btn.html();
            btn.html('<i class="fas fa-spinner fa-spin"></i> Registering...').prop('disabled', true);
            $('#msgBox').hide();

            $.ajax({
                url: 'api/users_handler.php',
                type: 'POST',
                data: formData,
                success: function(response) {
                    if (response.success) {
                        $('#msgBox').removeClass('msg-error').addClass('msg-success').text(response.message).fadeIn();
                        $('#registerForm')[0].reset();
                        setTimeout(() => {
                            window.location.href = 'login.php';
                        }, 2000);
                    } else {
                        $('#msgBox').removeClass('msg-success').addClass('msg-error').text(response.message).fadeIn();
                        btn.html(originalText).prop('disabled', false);
                    }
                },
                error: function() {
                    $('#msgBox').removeClass('msg-success').addClass('msg-error').text('An error occurred. Please try again.').fadeIn();
                    btn.html(originalText).prop('disabled', false);
                }
            });
        });
    </script>
</body>
</html>
