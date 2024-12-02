<?php
$mysqli = new mysqli("localhost", "root", "root", "vaika");

if ($mysqli->connect_error) {
    die("Erreur de connexion à la base de données : " . $mysqli->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST["nom"];
    $prenom = $_POST["prenom"];
    $email = $_POST["email"];
    $motDePasse = $_POST["motDePasse"]; // Hachage du mot de passe

    $insertQuery = "INSERT INTO Utilisateurs (Nom, Prenom, Email, MotDePasse) VALUES (?, ?, ?, ?)";
    $stmt = $mysqli->prepare($insertQuery);
    $stmt->bind_param("ssss", $nom, $prenom, $email, $motDePasse);

    if ($stmt->execute()) {
        $message = "Inscription réussie !";
    } else {
        $message = "Erreur lors de l'inscription : " . $stmt->error;
    }

    $stmt->close();
}

$mysqli->close();
?>

<!DOCTYPE html>

<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Inscription a VAIKA </title>
    <link rel="stylesheet" href="style.css">
   </head>
<body>
  <div class="wrapper">
    <h2>Inscription</h2>
    <form method="post" action="index.php">
      <div class="input-box">
        <input type="text" name="nom" placeholder="Entrer votre nom" required>
      </div>
      <div class="input-box">
        <input type="text" name="prenom" placeholder="Entrer votre prenom" required>
      </div>
      <div class="input-box">
        <input type="email" name="email" placeholder="Entrer votre email" required>
      </div>
      <div class="input-box">
      <input type="password" name="motDePasse" placeholder="Entrer votre mot de passe" required>
</div>

      <div class="policy">
        <input type="checkbox">
        <h3>J'accepte les termes et les condition </h3>
      </div>
      <div class="input-box button">
        <input type="Submit" value="Register Now">
      </div>
      <div class="text">
        <h3> Vous avez deja un compte ? <a href="connection.php">Connecter vous</a></h3>
      </div>
    </form>
  </div>

</body>
</html>
