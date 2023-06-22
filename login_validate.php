<?php
// Auteur: Akram Daidoune
function ConnectDb(){
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "login";
   
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        // Stel de PDO-foutmodus in op uitzondering
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

session_start();

// Controleer of het formulier is verzonden
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $gebruikersnaam = $_POST['gebruikersnaam'];
    $wachtwoord = $_POST['wachtwoord'];

    // Maak een databaseverbinding
    $conn = ConnectDb();

    if ($conn) {
        try {
            // Bereid de SQL-query voor om gebruikersgegevens op te halen
            $stmt = $conn->prepare("SELECT * FROM users WHERE gebruikersnaam = :gebruikersnaam AND wachtwoord = :wachtwoord");
            $stmt->bindParam(':gebruikersnaam', $gebruikersnaam);
            $stmt->bindParam(':wachtwoord', $wachtwoord);

            // Voer de query uit
            $stmt->execute();

            // Controleer of er een gebruiker bestaat met de opgegeven gebruikersnaam en wachtwoord
            if ($stmt->rowCount() > 0) {
                // Authenticatie succesvol
                $_SESSION['gebruikersnaam'] = $gebruikersnaam;
                echo "Je bent ingelogd met de volgende gegevens: <br>
                Gebruikersnaam: $gebruikersnaam <br>
                Wachtwoord: $wachtwoord";
            } else {
                // Authenticatie mislukt
                echo "Inloggen is mislukt.";
            }
        } catch (PDOException $e) {
            echo "Fout tijdens het inloggen: " . $e->getMessage();
        }
    }
}
?>
<html>
<title>Login pagina</title>
</head>
<body>
    <h1>Login</h1>
    <form action="login_validate.php" method="POST">
        <label for="gebruikersnaam">Gebruikersnaam:</label>
        <input type="text" id="gebruikersnaam" name="gebruikersnaam" required><br>
        <label for="wachtwoord">Wachtwoord:</label>
        <input type="password" id="wachtwoord" name="wachtwoord" required><br>
        <input type="submit" value="Inloggen">
    </form>
    <a href="register.php">Registreren</a>
</html>