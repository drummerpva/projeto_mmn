<?php
    session_start();
    require './config.php';

    if(!empty($_POST['email'])){
        $email = addslashes($_POST['email']);
        $senha = md5($_POST['senha']);
        $sql = $pdo->prepare("SELECT * FROM usuarios WHERE email = :email AND senha = :senha");
        $sql->bindValue(":email",$email);
        $sql->bindValue(":senha",$senha);
        $sql->execute();
        if($sql->rowCount() > 0){
            $sql = $sql->fetch();
            $_SESSION['mmnLogin'] = $sql['id'];
            header("Location: ./");
        }else{
            echo "Usuário e/ou senha errados!";
        }
    }
    if(!empty($_SESSION['mmnLogin'])){
        header("Location: ./");
    }
    
    ?>
<form style="width: 100px;margin:auto;" method="POST">
    <fieldset>
        E-mail:<br>
        <input type="email" name="email" required><br><br>
        Senha:<br>
        <input type="password" name="senha" required><br><br>
        <input type="submit" value="Entrar">
    </fieldset>
    
</form>