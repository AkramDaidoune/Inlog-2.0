<?php
// Auteur: Akram Daidoune
// Functie om verbinding te maken met de database
function connectDb(){
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "login";
   
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        // Stel de PDO-foutmodus in op exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        echo "Verbonden met de database.";
        return $conn;
    } 
    catch(PDOException $e) {
        echo "Verbinding mislukt: " . $e->getMessage();
        return null;
    }
}

// Controleren of de gebruiker is ingelogd
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    // Gebruiker is al ingelogd, redirect naar de homepage
    header("Location: homepage.php");
    exit;
} else {
    session_start();
    
    // Controleren of het formulier is ingediend
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Controleren van de gebruikersnaam en het wachtwoord
        $gebruikersnaam = $_POST["gebruikersnaam"];
        $wachtwoord = $_POST["wachtwoord"];
    
        if ($gebruikersnaam === "jouw_gebruikersnaam" && $wachtwoord === "jouw_wachtwoord") {
            $_SESSION["gebruikersnaam"] = $gebruikersnaam;
            
            // Redirect naar de homepage
            header("Location: homepage.php");
            exit();
        } else {
            $errorMessage = "Ongeldige gebruikersnaam of wachtwoord.";
        }
    }
}
?>
<html>
<title>Login pagina</title>
</head>
<body>
    <h1>Inloggen...</h1>
    <form action="login_validate.php" method="POST">
        <label for="gebruikersnaam">Gebruikersnaam:</label>
        <input type="text" id="gebruikersnaam" name="gebruikersnaam" required><br>
        <label for="wachtwoord">Wachtwoord:</label>
        <input type="password" id="wachtwoord" name="wachtwoord" required><br>
        <input type="submit" value="Inloggen">
    </form>
    <a href="register.php">Registreren</a>
</html>