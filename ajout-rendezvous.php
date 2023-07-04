<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un rendez-vous</title>
</head>
<body>
    <h1>Ajouter un rendez-vous</h1>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $patientId = $_POST['idPatients'];
        $dateRendezvous = $_POST['dateHour'];


        $dns = 'mysql:host=localhost;dbname=hospitale2n;charset=utf8';
        $user = 'root';
        $password = '';

        try {
            $db = new PDO($dns, $user, $password);


            $requete = "INSERT INTO appointments (id, dateHour, idPatients) VALUES (:id, :dateHour, :idPatients)";
            $statement = $db->prepare($requete);

            $statement->execute(array(':idPatients' => $patientId, ':dateHour' => $dateRendezvous, ':id' => null));

            echo 'Le rendez-vous a été ajouté avec succès.';
        } catch (PDOException $e) {
            echo 'Une erreur s\'est produite : ' . $e->getMessage();
        }
    }
    ?>

    <form action="ajout-rendezvous.php" method="post">
        <label for="idPatients">Patient :</label>
        <select name="idPatients" id="idPatients" required>
            
            <?php
            $dns = 'mysql:host=localhost;dbname=hospitale2n;charset=utf8';
            $user = 'root';
            $password = '';

            try {
                $db = new PDO($dns, $user, $password);

                
                $requete = "SELECT id, lastName, firstName FROM patients";
                $resultat = $db->query($requete);

                while ($patient = $resultat->fetch(PDO::FETCH_ASSOC)) {
                    echo "<option value=\"" . $patient['id'] . "\">" . $patient['lastName'] . " " . $patient['firstName'] . "</option>";
                }
            } catch (PDOException $e) {
                echo 'Une erreur s\'est produite : ' . $e->getMessage();
            }
            ?>
        </select><br>

        <label for="dateHour">Date du rendez-vous :</label>
        <input type="dateTime-local" name="dateHour" id="dateHour" required><br>

        <input type="hidden" name="id" id="id">

        <button type="submit">Ajouter</button>
    </form>
</body>
</html>
