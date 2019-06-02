<?php
include '../../../config/autoload.php';

$postgres = new connexion();
$conn = $postgres->connect();

//récuperation des données entrée
$debut = $_POST['debut'];
$fin = $_POST['fin'];


//requete sql
$sql ="
        SELECT COUNT(reference),(SELECT COUNT(reference) FROM sead.etude 
        WHERE (statut <= 2 or statut >= 8) AND date_demande BETWEEN '$debut' AND '$fin')AS encours,
        (
                SELECT COUNT(reference) FROM sead.etude 
            WHERE (statut>=3 or statut <= 7) 
            AND date_demande BETWEEN '$debut' AND '$fin'
        ) AS terminee  
        FROM sead.etude WHERE date_demande between '$debut' AND '$fin'";


 $dataOut = $postgres->getSQL($conn, $sql);


 foreach ($dataOut as $key => $row) {
   
    $dataPoints = [
        array("y" => $row['encours'],"name" => "Etudes en cours"),
        array("y" => $row['terminee'],"name" => "Etudes terminée")]
    ;
    
    //array_push($dataPoints, $dataPoi);
}

echo json_encode($dataPoints);

?>