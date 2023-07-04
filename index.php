
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<?php
// Paramètres de connexion à la base de données
$dns = 'mysql:host=localhost;dbname=hospitale2n;charset=utf8';
$user = 'root';
$password = '';

require_once('ajout-patient.php');
?>
<a href="liste-patients.php">liste des patients</a> 
<a href="ajout-rendezvous.php">ajouter un rendezvous</a>
<a href="liste-rendezvous.php">liste des rendezvous</a>  
</body>
</html>
