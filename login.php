<?php
session_start(); 

$email="joaozin.da.silva32@gmail.com";
$senha=password_hash("24124", PASSWORD_BCRYPT);
$nome='João da Silva'; 


  function validarSenha($senhaDigitada, $hashSalvo) {
    return password_verify($senhaDigitada, $hashSalvo);
}

  if ($_SERVER["REQUEST_METHOD"] === "POST") {

     $emailDigitado = $_POST["email"];
     $senhaDigitada = $_POST["senha"];

    if ($emailDigitado === $email && validarSenha($senhaDigitada, $senha)) {
        $_SESSION["nome"]   = $nome;
        $_SESSION["logado"] = true;

        echo "Login feito com sucesso! Bem-vindo, " . $nome;
    } else {
        echo "E-mail ou senha incorretos.";
    }
}

?>

<form action="login.php" method="post">
    Email: <input type="text" name="email">
    Senha: <input type="passaword" name="senha">
    <input type="submit" value="Entrar">
</form>