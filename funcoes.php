<?php
function calcularCadastros($id, $limite) {
    $lista = array();
    global $pdo;
    $sql = $pdo->prepare("SELECT * FROM usuarios WHERE id_pai = :id");
    $sql->bindValue(":id", $id);
    $sql->execute();
    $filhos = 0;
    if ($sql->rowCount() > 0) {
        $lista = $sql->fetchAll(PDO::FETCH_ASSOC);
        $filhos = $sql->rowCount();
        foreach ($lista as $chave => $usuario) {
            if ($limite > 0) {
                $filhos += calcularCadastros($usuario['id'], $limite-1);
            }
        }
    }
    return $filhos;
}


function listar($id, $limite) {
    $lista = array();
    global $pdo;
    $sql = $pdo->prepare("SELECT u.id, u.id_pai, u.patente, u.nome, p.nome as p_nome FROM usuarios u "
            . " LEFT JOIN patentes p ON  p.id = u.patente WHERE u.id_pai = :id");
    $sql->bindValue(":id", $id);
    $sql->execute();
    if ($sql->rowCount() > 0) {
        $lista = $sql->fetchAll(PDO::FETCH_ASSOC);
        foreach ($lista as $chave => $usuario) {
            $lista[$chave]['filhos'] = array();
            if ($limite > 0) {
                $lista[$chave]['filhos'] = listar($usuario['id'],$limite-1);
            }
        }
    }
    return $lista;
}
function exibir($array){
    echo "<ul>";
    foreach ($array as $usuario){
        echo "<li>(".
                $usuario['p_nome'].") ".$usuario['nome']." - (".count($usuario['filhos'])." cadastros diretos)"
                ."</li>";
        if(count($usuario['filhos']) > 0){
            exibir($usuario['filhos']);
        }
    }
    echo "</ul>";
}

