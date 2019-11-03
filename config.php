<?php
try{
    global $pdo;
    $pdo = new PDO("mysql:dbname=projeto_mmn;host=localhost","root","");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
} catch (PDOException $ex) {
    echo "Erro na conexão: ".$ex->getMessage();
}
$limite = 3;
$patentes = array(
    
);