<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails du rendez-vous</title>
</head>
<body>
    <h1>Détails du rendez-vous</h1>

    <?php
    $dns = 'mysql:host=localhost;dbname=hospitale2n;charset=utf8';
    $user = 'root';
    $password = '';

    try {
        if (isset($_GET['id'])) {
            $idRendezvous = $_GET['id'];

            $db = new PDO($dns, $user, $password);
            $requete = "SELECT * FROM appointments WHERE id = :id";
            $statement = $db->prepare($requete);
            $statement->execute(array(':id' => $idRendezvous));

            if ($statement->rowCount() > 0) {
                $rendezvous = $statement->fetch(PDO::FETCH_ASSOC);
                echo "<p>Date et heure : " . $rendezvous['dateHour'] . "</p>";
                echo "<p>ID du patient : " . $rendezvous['idPatients'] . "</p>";
                // Afficher d'autres informations du rendez-vous si nécessaire
            } else {
                echo "Rendez-vous introuvable.";
            }
        } else {
            echo "ID du rendez-vous non spécifié.";
        }
    } catch (PDOException $e) {
        echo 'Une erreur s\'est produite : ' . $e->getMessage();
    }
    ?>

    <a href="liste-rendezvous.php">Retour à la liste des rendez-vous</a>

    <?php
    $dns = 'mysql:host=localhost;dbname=hospitale2n;charset=utf8';
    $user = 'root';
    $password = '';

    try {
        if (isset($_GET['id'])) {
            $idRendezvous = $_GET['id'];

            $db = new PDO($dns, $user, $password);
            $requete = "SELECT * FROM appointments WHERE id = :id";
            $statement = $db->prepare($requete);
            $statement->execute(array(':id' => $idRendezvous));

            if ($statement->rowCount() > 0) {
                $rendezvous = $statement->fetch(PDO::FETCH_ASSOC);
                ?>

                <form action="modifier-rendezvous.php" method="post">
                    <input type="hidden" name="id" value="<?php echo $rendezvous['id']; ?>">
                    <label for="dateHour">Date et heure :</label>
                    <input type="datetime-local" name="dateHour" id="dateHour" value="<?php echo $rendezvous['dateHour']; ?>" required><br>
                    <label for="idPatients">ID du patient :</label>
                    <input type="text" name="idPatients" id="idPatients" value="<?php echo $rendezvous['idPatients']; ?>" required><br>
                    <button type="submit">Modifier</button>
                </form>

                <?php
            } else {
                echo "Rendez-vous introuvable.";
            }
        } else {
            echo "ID du rendez-vous non spécifié.";
        }
    } catch (PDOException $e) {
        echo 'Une erreur s\'est produite : ' . $e->getMessage();
    }
    ?>
</body>
</html>
