<!DOCTYPE html>
<html>

<head>
    <title>Ajouter un patient</title>
</head>

<body>
    <h1>Ajouter un patient</h1>

    <?php
    'mysql:host=localhost;dbname=hospitale2n';
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nom = $_POST['lastName'];
        $prenom = $_POST['firstName'];
        $date_naissance = $_POST['birthDate'];
        $telephone = $_POST['phone'];
        $mail = $_POST['mail'];
        echo "Yolo";
        try {
            $dns = 'mysql:host=localhost;dbname=hospitale2n;charset=utf8';
            $user = 'root';
            $password = '';
            $db = new PDO($dns, $user, $password);
            $requete = "INSERT INTO patients (lastName, firstName, birthDate, phone, mail, id) VALUES (:lastName, :firstName, :birthDate, :phone, :mail, :id)";
            $statement = $db->prepare($requete);

            $statement->execute(array(':lastName' => $nom, ':firstName' => $prenom, ':birthDate' => $date_naissance, ':phone' => $telephone, ':mail' => $mail, ':id' => null));
            echo 'Le patient a été ajouté avec succès.';
        } catch (PDOException $e) {
            echo 'Une erreur s\'est produite : ' . $e->getMessage();
        }
    }
    ?>

    <form action="ajout-patient.php" method="post">
        <label for="lastName">Lastname :</label>
        <input type="text" name="lastName" id="lastName" required><br>

        <label for="firstName">Firstname :</label>
        <input type="text" name="firstName" id="firstName" required><br>

        <label for="birthDate">Birthdate :</label>
        <input type="date" name="birthDate" id="birthDate" required><br>

        <label for="phone">Phone :</label>
        <input type="text" name="phone" id="phone" required><br>
        
        <label for="mail">Mail :</label>
        <input type="email" name="mail" id="mail" required><br>
        
        

        <input type="hidden" name="id" id="id">


        <button type="submit">Ajouter</button>
    </form>
</body>

</html>