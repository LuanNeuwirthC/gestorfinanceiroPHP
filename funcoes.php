<?php
session_start();

if (!isset($_SESSION['transacoes'])) {
    $_SESSION['transacoes'] = [];
}

function verificarAcesso() {
    if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
        header("Location: login.php");
        exit();
    }
}

function calcularRelevancia($valorDespesa, $totalDespesas) {
    if ($totalDespesas <= 0) return 0;
    return ($valorDespesa / $totalDespesas) * 100;
}

function formatarMoeda($valor) {
    return 'R$ ' . number_format($valor, 2, ',', '.');
}
?>