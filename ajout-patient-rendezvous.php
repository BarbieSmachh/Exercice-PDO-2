<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un patient et un rendezvous</title>
</head>
<body>
    <h1>Ajouter un patient et un rendezvous</h1>

    <?php
    $dns = 'mysql:host=localhost;dbname=hospitale2n;charset=utf8';
    $user = 'root';
    $password = '';

    try {
        $db = new PDO($dns, $user, $password);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $lastName = $_POST['lastName'];
            $firstName = $_POST['firstName'];
            $birthdate = $_POST['birthdate'];
            $phone = $_POST['phone'];
            $mail = $_POST['mail'];

        
            $requetePatient = "INSERT INTO patients (id, lastName, firstName, birthdate, phone, mail) VALUES (NULL, :lastName, :firstName, :birthdate, :phone, :mail)";
            $statementPatient = $db->prepare($requetePatient);
            $statementPatient->execute(array(
                ':lastName' => $lastName,
                ':firstName' => $firstName,
                ':birthdate' => $birthdate,
                ':phone' => $phone,
                ':mail' => $mail
            ));

            $patientId = $db->lastInsertId();

            $dateRendezvous = $_POST['dateHour'];

            $requeteRendezvous = "INSERT INTO appointments (id, dateHour, idPatients) VALUES (NULL, :dateHour, :idPatients)";
            $statementRendezvous = $db->prepare($requeteRendezvous);
            $statementRendezvous->execute(array(
                ':dateHour' => $dateRendezvous,
                ':idPatients' => $patientId
            ));

            echo 'Le patient et le rendezvous ont été ajoutés avec succès.';
        }
    } catch (PDOException $e) {
        echo 'Une erreur s\'est produite : ' . $e->getMessage();
    }
    ?>

    <form action="ajout-patient-rendezvous.php" method="post">
        <label for="lastName">Nom :</label>
        <input type="text" name="lastName" id="lastName" required><br>

        <label for="firstName">Prénom :</label>
        <input type="text" name="firstName" id="firstName" required><br>

        <label for="birthdate">Date de naissance :</label>
        <input type="date" name="birthdate" id="birthdate" required><br>

        <label for="phone">Téléphone :</label>
        <input type="text" name="phone" id="phone"><br>

        <label for="mail">Email :</label>
        <input type="email" name="mail" id="mail"><br>

        <label for="dateHour">Date du rendezvous :</label>
        <input type="datetime-local" name="dateHour" id="dateHour" required><br>

        <button type="submit">Ajouter</button>
    </form>
</body>
</html>
