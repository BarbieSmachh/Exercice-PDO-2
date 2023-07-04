<!DOCTYPE html>
<html>

<head>
    <title>Profil du patient</title>
</head>

<body>
    <h1>Profil du patient</h1>

    <?php
    $dns = 'mysql:host=localhost;dbname=hospitale2n;charset=utf8';
    $user = 'root';
    $password = '';


    if (isset($_GET['id'])) {
        $patientId = $_GET['id'];
        echo '<h2>Informations du patient</h2>';
        try {
            $db = new PDO($dns, $user, $password);
            $requete = "SELECT * FROM patients WHERE id = :id";
            $statement = $db->prepare($requete);
            $statement->bindParam(':id', $patientId);
            $statement->execute();


            if ($statement->rowCount() > 0) {
                $patient = $statement->fetch(PDO::FETCH_ASSOC);
                echo "<p>Nom : " . $patient['lastname'] . "</p>";
                echo "<p>Prénom : " . $patient['firstname'] . "</p>";
                echo "<p>Date de naissance : " . $patient['birthdate'] . "</p>";
                echo "<p>Téléphone : " . $patient['phone'] . "</p>";
                echo "<p>Email : " . $patient['mail'] . "</p>";
                echo "<p><a href=\"modifier-patient.php?id=" . $patient['id'] . "\">Modifier le profil</a></p>";
            } else {
                echo "Patient introuvable.";
            }
        } catch (PDOException $e) {
            echo 'Une erreur s\'est produite : ' . $e->getMessage();
        }
    } else {
        echo "Aucun identifiant de patient spécifié.";
    }
    if (isset($_GET['id'])) {
        $patientId = $_GET['id'];
    
        $dsn = 'mysql:host=localhost;dbname=hospitale2n;charset=utf8';
        $user = 'root';
        $password = '';
    
        try {
            $db = new PDO($dsn, $user, $password);
    

            $requetePatient = "SELECT * FROM patients WHERE id = :patientId";
            $statementPatient = $db->prepare($requetePatient);
            $statementPatient->execute(array(':patientId' => $patientId));
            $patient = $statementPatient->fetch(PDO::FETCH_ASSOC);
    
            if ($patient) {
               
                $requeteRendezvous = "SELECT * FROM appointments WHERE idPatients = :patientId";
                $statementRendezvous = $db->prepare($requeteRendezvous);
                $statementRendezvous->execute(array(':patientId' => $patientId));
                $rendezvous = $statementRendezvous->fetchAll(PDO::FETCH_ASSOC);
    
                if ($rendezvous) {
                    
                    echo "<h2>Liste des rendez-vous</h2>";
                    foreach ($rendezvous as $rdv) {
                        echo "<p>Date du rendez-vous : " . $rdv['dateHour'] . "</p>";
                    }
                } else {
                    echo "<p>Aucun rendez-vous trouvé.</p>";
                }
            } else {
                echo "<p>Patient non trouvé.</p>";
            }
        } catch (PDOException $e) {
            echo 'Une erreur s\'est produite : ' . $e->getMessage();
        }
    } else {
        echo "<p>Identifiant du patient non spécifié.</p>";
    }
    ?>

    <a href="liste-patients.php">Retour à la liste des patients</a>
</body>

</html>
