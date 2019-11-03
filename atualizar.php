<?php
session_start();
require 'config.php';
require 'funcoes.php';

$sql = $pdo->prepare("SELECT id FROM usuarios");
$sql->execute();
$usuarios = array();
if($sql->rowCount() > 0){
    $usuarios = $sql->fetchAll();
    foreach ($usuarios as $chave => $usuario){
        $usuarios[$chave]["filhos"] = calcularCadastros($usuario['id'], $limite);
    }
}
$sql = "SELECT * FROM patentes ORDER BY min DESC";
$sql = $pdo->query($sql);
$patentes = array();
if($sql->rowCount() > 0){
    $patentes = $sql->fetchAll();
}
foreach ($usuarios as $usuario){
    foreach ($patentes as $patente){
        if(intval($usuario['filhos'])  >= intval($patente['min'])){
            $sql = $pdo->prepare("UPDATE usuarios SET patente = :patente WHERE id = :id");
            $sql->bindValue(":patente",$patente['id']);
            $sql->bindValue(":id",$usuario['id']);
            $sql->execute();
            break;
        }
        
    }
    
    
}
