<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "login";

// Verbinding maken met de database met behulp van PDO
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Er is een fout opgetreden bij het verbinden met de database: " . $e->getMessage());
}

session_start();

if (isset($_SESSION['gebruikersnaam'])) {
    $gebruikersnaam = $_SESSION['gebruikersnaam'];
    $wachtwoord = $_SESSION['wachtwoord'];
    $message = "Welkom! Je bent ingelogd en kunt nu beginnen.";
} else {
    $message = "Je bent momenteel niet ingelogd. Log in om verder te gaan.";
    $gebruikersnaam = "";
    $wachtwoord = "";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welkom</title>
</head>
<body>
    <h1>PDO login en registratie</h1>
    <br>
    <h2>Welkom op de HOME-pagina!</h2>
    <br>
    <p><?php echo $message; ?></p>
    <?php if (isset($_SESSION['gebruikersnaam'])) { ?>
        <p>Gebruikersnaam: <?php echo $gebruikersnaam; ?></p>
        <p>Wachtwoord: <?php echo $wachtwoord; ?></p>
    <?php } ?>
    <?php if (!isset($_SESSION['gebruikersnaam'])) { ?>
        <br>
        <a href="login_form.php">Inloggen</a>
    <?php } ?>
</body>
</html>

