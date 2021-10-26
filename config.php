<?php 
try
{
$bdd=new pdo("mysql:host=localhost;dbname=bdd_session;charset=utf8", "root", "",array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch (Exception $e)
{
die('Erreur : ' . $e->getMessage());
}


?>