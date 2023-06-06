<!DOCTYPE html>
<html data-bs-theme="dark">
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Login Page</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel='stylesheet' type='text/css' media='screen' href='login.css'>
    <script src='main.js'></script>
</head>
<body>
    <img src="logo.png" alt="logo" id="logo">
    <div class="login">
        <form method="post" action="main.php">
            <p id="CampusConnect">Login</p>
            <input type="text" placeholder=" Benutzername" name="Username" class="input" id="Username" value="ChristopherFrey">
            <br>
            <input type="password" placeholder=" Passwort" name="password" class="input" value="Pupsgesicht">
            <br>
            <div id="checkbox"><input type="checkbox" name="Remember"> Remember me</div>
            <br>
            <a href="index.html"><input type="button" value="Einloggen" class="input" id="submit-button">   </a>
            <br>
            <a href="Register.html"><input type="button" value="Registrieren" class="input" id="register-button"></a>
        </form>
    </div>



   
</body>
</html>