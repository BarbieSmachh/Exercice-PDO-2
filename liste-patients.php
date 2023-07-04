<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des patients</title>
</head>
<body>
    <form action="liste-patients.php" method="get">
        <label for="search">Rechercher :</label>
        <input type="text" name="search" id="search" placeholder="Nom du patient">
        <button type="submit">Rechercher</button>
    </form>
    <?php
    $dns = 'mysql:host=localhost;dbname=hospitale2n;charset=utf8';
    $user = 'root';
    $password = '';

    $perPage = 5; 
    $currentPage = isset($_GET['page']) ? $_GET['page'] : 1; 

    try {
        $db = new PDO($dns, $user, $password);

        $query = "SELECT COUNT(*) as total FROM patients";

        if (isset($_GET['search'])) {
            $search = $_GET['search'];
            $query .= " WHERE lastName LIKE '%$search%'";
        }

        $result = $db->query($query);
        $totalPatients = $result->fetch(PDO::FETCH_ASSOC)['total'];

        $totalPages = ceil($totalPatients / $perPage);

        
        if ($currentPage < 1) {
            $currentPage = 1;
        } elseif ($currentPage > $totalPages) {
            $currentPage = $totalPages;
        }

        $offset = ($currentPage - 1) * $perPage; 

        $requete = "SELECT * FROM patients";

        if (isset($_GET['search'])) {
            $search = $_GET['search'];
            $requete .= " WHERE lastName LIKE '%$search%'";
        }

        $requete .= " LIMIT $offset, $perPage";

        $resultat = $db->query($requete);

        if ($resultat->rowCount() > 0) {
            while ($patient = $resultat->fetch(PDO::FETCH_ASSOC)) {
                echo "<p>Nom : " . $patient['lastname'] . "</p>";
                echo "<p>Prénom : " . $patient['firstname'] . "</p>";
                echo "<p>Date de naissance : " . $patient['birthdate'] . "</p>";
                echo "<p><a href=\"profil-patients.php?id=" . $patient['id'] . "\">Voir le profil</a></p>";
                echo "<form action=\"liste-patients.php\" method=\"post\">";
                echo "<input type=\"hidden\" name=\"delete\" value=\"" . $patient['id'] . "\">";
                echo "<button type=\"submit\">Supprimer</button>";
                echo "</form>";

                echo "<hr>";
            }
        } else {
            echo "Aucun patient trouvé.";
        }

        
        echo "<div>";
        if ($currentPage > 1) {
            echo "<a href=\"liste-patients.php?page=" . ($currentPage - 1) . "\">Page précédente</a>";
        }
        if ($currentPage < $totalPages) {
            echo "<a href=\"liste-patients.php?page=" . ($currentPage + 1) . "\">Page suivante</a>";
        }
        echo "</div>";
    } catch (PDOException $e) {
        echo 'Une erreur s\'est produite : ' . $e->getMessage();
    }
    
    try {
        $db = new PDO($dns, $user, $password);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['delete'])) {
                $patientId = $_POST['delete'];

                $requeteRendezvous = "DELETE FROM appointments WHERE idPatients = :patientId";
                $statementRendezvous = $db->prepare($requeteRendezvous);
                $statementRendezvous->execute(array(':patientId' => $patientId));

                $requetePatient = "DELETE FROM patients WHERE id = :patientId";
                $statementPatient = $db->prepare($requetePatient);
                $statementPatient->execute(array(':patientId' => $patientId));

                echo 'Le patient et ses rendez-vous ont été supprimés avec succès.';
            }
        }
    } catch (PDOException $e) {
        echo 'Une erreur s\'est produite : ' . $e->getMessage();
    }
    ?>

    <a href="ajout-patient.php">Ajouter un patient</a>
</body>
</html>
