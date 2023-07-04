<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des rendez-vous</title>
</head>
<body>
    <h1>Liste des rendez-vous</h1>

    <?php
    $dns = 'mysql:host=localhost;dbname=hospitale2n;charset=utf8';
    $user = 'root';
    $password = '';

    try {
        $db = new PDO($dns, $user, $password);
        $requete = "SELECT * FROM appointments";
        $resultat = $db->query($requete);

        if ($resultat->rowCount() > 0) {
            while ($rendezvous = $resultat->fetch(PDO::FETCH_ASSOC)) {
                echo "<p>Date et heure : " . $rendezvous['dateHour'] . "</p>";
                echo "<p>Patient : " . $rendezvous['idPatients'] . "</p>";
                echo "<p><a href=\"rendezvous.php?id=" . $rendezvous['id'] . "\">Voir le rendez-vous</a></p>";
                echo "<hr>";
            }
        } else {
            echo "Aucun rendez-vous trouvé.";
        }
    } catch (PDOException $e) {
        echo 'Une erreur s\'est produite : ' . $e->getMessage();
    }
    try {
        $db = new PDO($dns, $user, $password);
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['delete'])) {
                $rendezvousId = $_POST['delete'];
    

                $requete = "DELETE FROM appointments WHERE id = :rendezvousId";
                $statement = $db->prepare($requete);
                $statement->execute(array(':rendezvousId' => $rendezvousId));
                echo 'Le rendez-vous a été supprimé avec succès.';
            }
        }
    
        
        $requeteRendezvous = "SELECT * FROM appointments";
        $resultatRendezvous = $db->query($requeteRendezvous);
    
        if ($resultatRendezvous->rowCount() > 0) {
            while ($rendezvous = $resultatRendezvous->fetch(PDO::FETCH_ASSOC)) {
                echo "<p>Date du rendez-vous : " . $rendezvous['dateHour'] . "</p>";
                echo "<form action=\"liste-rendezvous.php\" method=\"post\">";
                echo "<input type=\"hidden\" name=\"delete\" value=\"" . $rendezvous['id'] . "\">";
                echo "<button type=\"submit\">Supprimer</button>";
                echo "</form>";
                echo "<hr>";
            }
        } else {
            echo "Aucun rendez-vous trouvé.";
        }
    } catch (PDOException $e) {
        echo 'Une erreur s\'est produite : ' . $e->getMessage();
    }
    ?>

    <a href="ajout-rendezvous.php">Créer un rendez-vous</a>
</body>
</html>
