
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galerie d'images</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #fafafa;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            background-color: #405DE6;
            color: #fff;
            padding: 20px;
            margin: 0;
        }

        .navbar {
            background-color: #007BFF;
            padding: 10px 0;
        }

        .navbar-brand {
            font-size: 24px;
            color: #fff;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
        }

        .gallery {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            margin: -5px;
        }

        .image-container {
            margin: 5px;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            width: calc(33.33% - 10px);
            border-radius: 5px;
            hover .image opacity: 0.3;

        }
       
        img {
            width: 100%;
            height: auto;
            border-top-left-radius: 5px;
            border-top-right-radius: 5px;
        }

        .image-details {
            padding: 10px;
        }

        .comments {
            background-color: #fff;
            border-top: 1px solid #ddd;
            padding: 10px;
        }

        .user-avatar {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            margin-right: 10px;
            object-fit: cover;
        }

        .comment {
            margin: 5px 0;
        }

        .btn-download {
            background-color: #007BFF;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 8px 12px;
            text-decoration: none;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">GALERIE</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="vaika.php">Publier une photo</a>
        </li>
      </ul>
    </div>

  
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="inscription.php">Inscription</a>
        </li>
      </ul>

      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="connection.php">Connexion</a>
        </li>
      </ul>
   

  </div>
</nav>
<div class="container">
    <div class="gallery">
        <?php
        require_once("config.php");
        $mysqli = new mysqli("localhost", "root", "root", "vaika");
        // Start the session
        session_start();

        // Check if a user is logged in
        if (isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id'];
            // Use $user_id for operations related to the logged-in user
        } else {
            // User is not logged in, take appropriate actions
        }

        if ($mysqli->connect_error) {
            die("Erreur de connexion à la base de données : " . $mysqli->connect_error);
        }

        function displayComments($imageId) {
            global $mysqli;
            $selectCommentsQuery = "SELECT * FROM Commentaires WHERE id_image = $imageId";
            $commentsResult = $mysqli->query($selectCommentsQuery);

            if ($commentsResult->num_rows > 0) {
                echo '<div class="comments">';
                echo '<h4>Commentaires :</h4>';
                echo '<ul class="list-group">'; // Use Bootstrap list-group for comments
                while ($commentRow = $commentsResult->fetch_assoc()) {
                    $comment = $commentRow["commentaire"];
                    echo '<li class="list-group-item">' . $comment . '</li>'; // Apply list-group-item class
                }
                echo '</ul>';
                echo '</div>';
            }
        }

        $selectImagesQuery = "SELECT * FROM Images";
        $result = $mysqli->query($selectImagesQuery);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $imageId = $row["id"];
                $imageName = $row["file_name"];
                $imageTitle = $row["title"];
                $imageDescription = $row["description"];

                echo '<div class="image-container">';
                echo '<a href="image_detail.php?id=' . $imageId . '" class="text-white text-decoration-none"><img src="uploads/' . $imageName . '" alt="' . $imageTitle . '"></a>';
                echo '<div class="image-details">';
                echo '<h3>' . $imageTitle . '</h3>';
           
                echo '</button>';
                echo '</div>';

                echo '</div>';
            }
        } else {
            echo "Aucune image n'a été trouvée.";
        }

        $mysqli->close();
        ?>
    </div>
</div>
</body>
</html>














