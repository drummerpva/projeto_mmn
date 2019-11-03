<?php
session_start();
require 'config.php';
require 'funcoes.php';
if(empty($_SESSION['mmnLogin'])){
    header("Location: login.php");
}
$id = $_SESSION['mmnLogin'];
$sql = $pdo->prepare("SELECT u.nome, p.nome as p_nome FROM usuarios u LEFT JOIN patentes p"
        . " ON p.id = u.patente WHERE u.id = :id");
$sql->bindValue(":id",$id);
$sql->execute();
if($sql->rowCount() > 0){
    $sql = $sql->fetch();
    $nome = $sql['nome'];
    $patente = $sql['p_nome'];
    
}else{
    $_SESSION['mmnLogin'] = NULL;
    header("Location: login.php");
}

$lista = listar($id,$limite);

?>
<h1>Sistema de Marketin Multinivel</h1>
<h2>Bem vindo <strong><?php echo $nome." (".$patente.")";?></strong></h2>
<a href="cadastro.php">Cadastrar Novo Usuário</a><br/><br/>
<a href="logout.php">Sair</a>
<br>
<hr>
<h4>Lista de Cadastros</h4>
<?php exibir($lista);?>