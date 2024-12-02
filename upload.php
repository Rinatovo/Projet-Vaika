<?php
$mysqli = new mysqli("localhost", "root", "root", "vaika");

if ($mysqli->connect_error) {
    die("Erreur de connexion à la base de données : " . $mysqli->connect_error);
}

$message = ""; // Initialisation du message

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST["title"];
    $description = $_POST["description"];
    $file = $_FILES["file"];
    
    $fileExtension = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));

    if ($fileExtension == "jpg" || $fileExtension == "jpeg" || $fileExtension == "png") {
        $uploadDir = "uploads/";
        $fileName = uniqid() . "_" . $file["name"];
        $uploadPath = $uploadDir . $fileName;

        if (move_uploaded_file($file["tmp_name"], $uploadPath)) {
            // Enregistrez les informations de l'image dans la base de données
            $insertQuery = "INSERT INTO Images (title, description, file_name) VALUES (?, ?, ?)";
            $stmt = $mysqli->prepare($insertQuery);
            $stmt->bind_param("sss", $title, $description, $fileName);

            if ($stmt->execute()) {
                $message = "Image telechargee avec succes !";
            } else {
                $message = "Erreur lors de l'insertion dans la base de donnees : " . $stmt->error;
            }

            $stmt->close();
        } else {
            $message = "Erreur lors du telechargement de l'image.";
        }
    } else {
        $message = "Seules les images au format JPEG ou PNG sont autorisees.";
    }
}

$mysqli->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Resultat du telechargement</title>
</head>
<body>
    <h1>Resultat du telechargement</h1>
    <p><?php echo $message; ?></p>
    <a href="vaika.php">Retour au formulaire</a>
</body>
</html>
