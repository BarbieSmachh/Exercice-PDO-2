<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rendezvousId = $_POST['rendezvousId'];
    $nouvelleDateRendezvous = $_POST['nouvelleDate'];

    $dsn = 'mysql:host=localhost;dbname=hospitale2n;charset=utf8';
    $user = 'root';
    $password = '';

    try {
        $db = new PDO($dsn, $user, $password);
        
        $requete = "UPDATE appointments SET dateHour = :nouvelleDate WHERE id = :rendezvousId";
        $statement = $db->prepare($requete);
        $statement->execute(array(':nouvelleDate' => $nouvelleDateRendezvous, ':rendezvousId' => $rendezvousId));

        echo 'Le rendez-vous a été modifié avec succès.';
    } catch (PDOException $e) {
        echo 'Une erreur s\'est produite : ' . $e->getMessage();
    }
}
header('Location: liste-rendezvous.php');
?>
