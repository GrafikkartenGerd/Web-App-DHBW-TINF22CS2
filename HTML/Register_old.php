<!DOCTYPE html>
<html data-bs-theme="dark">
<head>

    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Registrieren</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel='stylesheet' type='text/css' media='screen' href='Register.css'>
    <script src='main.js'></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <img src="logo.png" alt="logo" id="logo">
    <div class="Register">
        <form method="post" action="main.php">
            <p id="CampusConnect">Register</p>
            <input type="text"  placeholder=" Benutzername" name="Username" id="Username" value="ChristopherFrey">
            <br>
            <input type="password" placeholder=" Passwort" name="password" id="password1"  value="Pupsgesicht">
            <br>
            <input type="password" placeholder="Passwort Wiederholen" name="password" id="password2" class="input" value="Pupsgesicht">
            <br>
            <br>
            <input type="button" value="Registrieren"  id="submit-button"> 
        </form>
    </div>



   
</body>
</html>