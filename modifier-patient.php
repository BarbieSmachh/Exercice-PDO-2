<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un patient</title>
</head>
<body>
    <?php
    $dns = 'mysql:host=localhost;dbname=hospitale2n;charset=utf8';
    $user = 'root';
    $password = '';

    try {
        $db = new PDO($dns, $user, $password);

        // Vérifier si le formulaire est soumis
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $nom = $_POST['lastName'];
            $prenom = $_POST['firstName'];
            $date_naissance = $_POST['birthDate'];
            $telephone = $_POST['phone'];
            $mail = $_POST['mail'];

            // Effectuer la requête UPDATE
            $requete = "UPDATE patients SET lastName = :lastName, firstName = :firstName, birthDate = :birthDate, phone = :phone, mail = :mail WHERE id = :id";
            $statement = $db->prepare($requete);
            $statement->execute(array(':lastName' => $nom, ':firstName' => $prenom, ':birthDate' => $date_naissance, ':phone' => $telephone, ':mail' => $mail, ':id' => $id));

            echo 'Le patient a été modifié avec succès.';
        } else {
            // Récupérer l'identifiant du patient à modifier
            $id = $_GET['id'];

            // Effectuer une requête SELECT pour récupérer les informations du patient
            $requete = "SELECT * FROM patients WHERE id = :id";
            $statement = $db->prepare($requete);
            $statement->execute(array(':id' => $id));

            if ($statement->rowCount() > 0) {
                $patient = $statement->fetch(PDO::FETCH_ASSOC);
                ?>
                <h1>Modifier un patient</h1>
                <form action="modifier-patient.php" method="post">
                    <input type="hidden" name="id" value="<?php echo $patient['id']; ?>">
                    <label for="lastName">Nom :</label>
                    <input type="text" name="lastName" id="lastName" value="<?php echo $patient['lastname']; ?>" required><br>

                    <label for="firstName">Prénom :</label>
                    <input type="text" name="firstName" id="firstName" value="<?php echo $patient['firstname'];?>" required><br>
                    <label for="birthDate">Date de naissance :</label>
                    <input type="date" name="birthDate" id="birthDate" value="<?php echo $patient['birthdate']; ?>" required><br>

                    <label for="phone">Téléphone :</label>
                    <input type="text" name="phone" id="phone" value="<?php echo $patient['phone']; ?>" required><br>

                    <label for="mail">Email :</label>
                    <input type="email" name="mail" id="mail" value="<?php echo $patient['mail']; ?>" required><br>

                    <button type="submit">Modifier</button>
                </form>
                <?php
            } else {
                echo 'Patient non trouvé.';
            }
        }
    } catch (PDOException $e) {
        echo 'Une erreur s\'est produite : ' . $e->getMessage();
    }
    ?>
</body>
</html>
