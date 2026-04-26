<?php 
 
 session_start();

if (!isset($_SESSION["logado"]) || $_SESSION["logado"] !== true) {
    header("Location: login.php");
    exit;
}

if (!isset($_SESSION["transacoes"])) {
    $_SESSION["transacoes"] = [];
}

$total_despesas = 0;
foreach ($_SESSION["transacoes"] as $transacao) {
    if ($transacao["tipo"] === "despesa") {
        $total_despesas += $transacao["valor"];
    }
}

function calcularRelevancia($valor, $total_despesas) {
    if ($total_despesas == 0) return 0; 
    return ($valor / $total_despesas) * 100;
}
 
 foreach ($_SESSION["transacoes"] as $transacao) {
    $impacto = $transacao["tipo"] === "receita" ? "+" : "-";
   
     echo "Nome: " . $transacao["nome"] . "\n";
     echo "Tipo: " . ucfirst($transacao["tipo"]) . "\n"; 
     echo "Valor: R$ " . number_format($transacao["valor"], 2, ',', '.') . "\n";
     echo "Impacto no saldo: " . $impacto . " R$ " . number_format($transacao["valor"], 2, ',', '.');
 
     if ($transacao["tipo"] === "despesa") {
        echo "Relevância: " . number_format(calcularRelevancia($transacao["valor"], $total_despesas), 1) . "% das despesas";
    }
 
    echo "\n";
}
?>