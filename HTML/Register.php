<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>CampusConnect - Register</title>
    <meta name="description" content="Register">
    <link rel="stylesheet" type="text/css" href="swipecss.css" media="screen">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <style>
        body {
            width: 100%;
            height: 100%;
            margin: 0;
            background-color: #f8f9fa;
            overflow: scroll;
        }

        .register-container {
            width: 400px;
            margin: 100px auto;
            padding: 30px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .register-form {
            margin-bottom: 20px;
        }

        .form-group label {
            font-weight: bold;
        }

        .form-group input[type="text"],
        .form-group input[type="email"],
        .form-group input[type="password"] {
            border-radius: 5px;
            padding: 12px;
            border: 1px solid #ced4da;
            font-size: 16px;
            width: 100%;
        }

        .form-group input[type="text"]:focus,
        .form-group input[type="email"]:focus,
        .form-group input[type="password"]:focus {
            outline: none;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
            border-color: #80bdff;
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

        .form-group .login-link {
            display: block;
            text-align: center;
            margin-top: 20px;
        }

        .form-group .login-link a {
            color: #343a40;
            text-decoration: none;
            transition: all 0.3s;
        }

        .form-group .login-link a:hover {
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
            margin-top: 20px;
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
        <span class="logo-text">CampusConnect</span>
    </header>
    <main>
        <div class="container register-container">
            <h2 class="text-center mb-4">Register</h2>
            <form class="register-form">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" placeholder="Enter name">
                </div>
                <div class="form-group">
                    <label for="surname">Surname</label>
                    <input type="text" class="form-control" id="surname" placeholder="Enter surname">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" placeholder="Enter email">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" placeholder="Enter password">
                </div>
                <div class="form-group">
                    <label for="confirm-password">Confirm Password</label>
                    <input type="password" class="form-control" id="confirm-password" placeholder="Confirm password">
                </div>
                <div class="form-group">
                    <label for="course">Course</label>
                    <input type="text" class="form-control" id="course" placeholder="Enter course">
                </div>
                <button type="submit" class="btn btn-primary btn-block">Register</button>
                <p class="text-center login-link">Already have an account? <a href="login.php">Login</a></p>
            </form>
        </div>
    </main>
    <footer class="footer">
        <p>&copy; 2023 CampusConnect. All rights reserved.</p>
    </footer>
</body>
</html>