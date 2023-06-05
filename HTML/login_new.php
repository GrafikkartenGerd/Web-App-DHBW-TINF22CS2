<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>CampusConnect</title>
    <meta name="description" content="Swiping">
    <link rel="stylesheet" type="text/css" href="login_new.css" media="screen">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    
    <style>
        body {
            width: 100%;
            height: 100%;
            margin: 0;
            background-color: #f8f9fa;
            overflow: scroll;
        }

        .login-container {
            width: 400px;
            margin: 100px auto;
            padding: 30px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .login-form {
            margin-bottom: 20px;
        }

        .form-group label {
            font-weight: bold;
        }

        .form-group input[type="email"],
        .form-group input[type="password"] {
            border-radius: 5px;
            padding: 12px;
            border: 1px solid #ced4da;
            font-size: 16px;
        }

        .form-group input[type="email"]:focus,
        .form-group input[type="password"]:focus {
            outline: none;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
            border-color: #80bdff;
        }

        .form-group .remember-me {
            margin-top: 10px;
            font-size: 14px;
        }

        .form-group .remember-me label {
            font-weight: normal;
        }

        .form-group .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            transition: all 0.3s;
        }

        .form-group .btn-primary:hover {
            background-color: #0069d9;
            border-color: #0062cc;
        }

        .form-group .register-link {
            display: block;
            text-align: center;
            margin-top: 20px;
        }

        .form-group .register-link a {
            color: #343a40;
            text-decoration: none;
            transition: all 0.3s;
        }

        .form-group .register-link a:hover {
            color: #212529;
        }

        .header {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: left;
        }

        .header img {
            height: 60px;
            width: 60px;
            margin-right: 10px;
        }

        .header span {
            font-size: 30px;
            font-weight: bold;
        }

        .footer {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
        }

        .footer p {
            margin: 0;
        }

        .logo-text {
            font-size: 24px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <header class="header">
        <img src="logo.png" alt="Logo">
        <span>CampusConnect</span>
    </header>
    <main>
        <div class="container login-container">
            <h2 class="text-center mb-4">Login</h2>
            <form class="login-form">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" placeholder="Enter email">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" placeholder="Enter password">
                </div>
                <div class="form-group">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="rememberMe">
                        <label class="form-check-label" for="rememberMe">Remember me</label>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Login</button>
                <p class="text-center register-link">Don't have an account? <a href="register_new.php">Register</a></p>
            </form>
        </div>
    </main>
    <footer class="footer">
        <p>&copy; 2023 CampusConnect. All rights reserved.</p>
    </footer>
</body>
</html>