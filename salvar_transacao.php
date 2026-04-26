<?php
include 'funcoes.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $nova_transacao = [
        'descricao' => $_POST['descricao'],
        'valor' => (float)$_POST['valor'],
        'tipo' => $_POST['tipo'],
    ];
$_SESSION['transacoes'][] = $nova_transacao;
header("Location: index.php");
exit();
}


?>