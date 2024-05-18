<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Body Fit</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f5f5f5;
            font-family: Arial, sans-serif;
        }
        .login-container {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }
        .login-form {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }
        .login-form .form-control {
            border: 1px solid #ced4da;
        }
        .login-form .form-control:focus {
            border-color: #E74C3C;
            box-shadow: none;
        }
        .login-form .btn-login {
            background-color: #E74C3C;
            color: #fff;
            border: none;
        }
        .login-form .btn-login:hover {
            background-color: #c0392b;
        }
        .login-form .form-group label {
            color: #333;
        }
        .login-form .card-header {
            background-color: #fff;
            color: #333;
            border-bottom: none;
            text-align: center;
        }
        .login-form .card-header h3 {
            margin: 0;
            font-family: 'Arial Black', sans-serif;
        }
        .brand-logo {
            font-weight: bold;
            font-size: 24px;
            color: #E74C3C;
        }
        .brand-logo span {
            color: #333;
        }
    </style>
</head>
<body>

<div class="container login-container">
    <div class="login-form">
        <div class="card-header">
            <h3 style="color:darkgoldenrod;" class="brand-logo">MARIANNE<span>FAMILY CENTER</span></h3>
        </div>
        <div class="card-body">
            <form action="adminlogin.php" method="POST">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button style="background-color:darkgoldenrod;" type="submit" class="btn btn-login btn-block">Login</button>
            </form>
        </div>
        <div class="card-footer text-center">
            <!-- <a href="register.php" class="text-secondary">Don't have an account? Register</a> -->
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
