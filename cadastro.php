<?php
session_start();
require './config.php';
if(!empty($_POST['nome'])){
    $nome = addslashes($_POST['nome']);
    $email = addslashes($_POST['email']);
    $id_pai = $_SESSION['mmnLogin'];
    $senha = md5($email);
    
    $sql = $pdo->prepare("SELECT * FROM usuarios WHERE email = :email");
    $sql->bindValue(":email",$email);
    $sql->execute();
    if($sql->rowCount() == 0){
        $sql = $pdo->prepare("INSERT INTO usuarios(id_pai,nome,email,senha) VALUES(:idpai, :nome, :email, :senha)");
        $sql->bindValue(":idpai",$id_pai);
        $sql->bindValue(":nome",$nome);
        $sql->bindValue(":email",$email);
        $sql->bindValue(":senha",$senha);
        $sql->execute();
        header("Location: index.php");
    }else{
        echo "<p>Erro! E-mail da  cadastrado!</p>";
    }
}
?>
<h3>Cadastrar Novo Usuário</h3>
<form method="POST" style=" width: 200px;">
    <fieldset>
        Nome:<br/>
        <input type="text" name="nome" required /><br/><br/>
        E-mail:<br/>
        <input type="email" name="email" required /><br/><br/>
        <input type="submit" value="Cadastrar" />
    </fieldset>
</form>
