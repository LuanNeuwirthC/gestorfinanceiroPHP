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
$total_receitas = 0;
foreach ($_SESSION["transacoes"] as $transacao) {
    if ($transacao["tipo"] === "despesa") {
        $total_despesas += $transacao["valor"];
    } else {
        $total_receitas += $transacao["valor"];
    }
}

$saldo = $total_receitas - $total_despesas;
$quantidade = count($_SESSION["transacoes"]);

function calcularRelevancia($valor, $total_despesas) {
    if ($total_despesas == 0) return 0; 
    return ($valor / $total_despesas) * 100;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyWallet - Histórico</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style> body { font-family: 'Inter', sans-serif; background-color: #f1f5f9; } </style>
</head>
<body class="text-slate-800">

    <header class="bg-slate-900 text-white shadow-md">
        <div class="max-w-7xl mx-auto px-6 h-16 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <i class="fa-solid fa-wallet text-blue-400 text-2xl"></i>
                <span class="text-xl font-bold uppercase tracking-tighter">MyWallet</span>
            </div>
            <div class="flex items-center gap-6">
                <span class="text-sm">Olá, <?php echo htmlspecialchars($_SESSION['nome']); ?></span>
                <a href="logout.php" class="bg-red-500 hover:bg-red-600 px-4 py-1.5 rounded-md text-sm font-bold transition-all">Sair</a>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-6 py-10">

        <div class="flex items-center justify-between mb-8">
            <div>
                <div class="flex items-center gap-2 text-slate-400 text-sm mb-1">
                    <a href="index.php" class="hover:text-blue-600 transition-colors">Dashboard</a>
                    <i class="fa-solid fa-chevron-right text-xs"></i>
                    <span class="text-slate-600 font-medium">Histórico</span>
                </div>
                <h1 class="text-2xl font-extrabold text-slate-800">Histórico de Movimentações</h1>
            </div>
            <div class="flex items-center gap-3">
                <form action="limpar.php" method="POST">
                    <input type="submit" value="Zerar Mês"
                        class="bg-rose-500 hover:bg-rose-600 text-white px-4 py-2 rounded-lg text-sm font-bold transition-all shadow-md cursor-pointer">
                </form>
                <a href="index.php" class="inline-flex items-center gap-2 bg-slate-900 hover:bg-black text-white px-4 py-2 rounded-lg text-sm font-bold transition-all shadow-md">
                    <i class="fa-solid fa-plus"></i>
                    Nova Movimentação
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-white rounded-xl shadow-sm p-5 border border-slate-200">
                <p class="text-slate-500 text-xs font-bold uppercase tracking-wider mb-1">Registros</p>
                <h3 class="text-3xl font-extrabold text-slate-800"><?php echo $quantidade; ?></h3>
            </div>
            <div class="bg-white rounded-xl shadow-sm p-5 border border-slate-200">
                <p class="text-slate-500 text-xs font-bold uppercase tracking-wider mb-1">Total Receitas</p>
                <h3 class="text-3xl font-extrabold text-emerald-600">R$ <?php echo number_format($total_receitas, 2, ',', '.'); ?></h3>
            </div>
            <div class="bg-white rounded-xl shadow-sm p-5 border border-slate-200">
                <p class="text-slate-500 text-xs font-bold uppercase tracking-wider mb-1">Total Despesas</p>
                <h3 class="text-3xl font-extrabold text-rose-600">R$ <?php echo number_format($total_despesas, 2, ',', '.'); ?></h3>
            </div>
            <div class="bg-blue-600 rounded-xl shadow-lg p-5 text-white">
                <p class="text-blue-100 text-xs font-bold uppercase tracking-wider mb-1">Saldo em Conta</p>
                <h3 class="text-3xl font-extrabold">R$ <?php echo number_format($saldo, 2, ',', '.'); ?></h3>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">

            <div class="bg-slate-50 px-6 py-4 border-b border-slate-200 flex items-center justify-between">
                <h2 class="font-bold text-slate-700 flex items-center gap-2">
                    <i class="fa-solid fa-list-ul text-slate-400"></i>
                    Todas as Movimentações
                </h2>
                <span class="text-xs text-slate-400 font-medium"><?php echo $quantidade; ?> registro<?php echo $quantidade !== 1 ? 's' : ''; ?></span>
            </div>

            <?php if ($quantidade === 0): ?>
                <div class="flex flex-col items-center justify-center py-20 text-center">
                    <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mb-4">
                        <i class="fa-solid fa-inbox text-slate-300 text-2xl"></i>
                    </div>
                    <p class="text-slate-500 font-semibold mb-1">Nenhuma movimentação ainda</p>
                    <p class="text-slate-400 text-sm mb-6">Adicione sua primeira receita ou despesa no dashboard.</p>
                    <a href="index.php" class="inline-flex items-center gap-2 bg-slate-900 text-white px-5 py-2.5 rounded-lg text-sm font-bold hover:bg-black transition-all">
                        <i class="fa-solid fa-plus"></i> Registrar Movimentação
                    </a>
                </div>

            <?php else: ?>

                <div class="hidden md:grid grid-cols-12 gap-4 px-6 py-3 border-b border-slate-100 text-xs font-bold text-slate-400 uppercase tracking-wider">
                    <div class="col-span-1">#</div>
                    <div class="col-span-4">Descrição</div>
                    <div class="col-span-2">Tipo</div>
                    <div class="col-span-2">Valor</div>
                    <div class="col-span-2">Impacto no Saldo</div>
                    <div class="col-span-1">Rel. %</div>
                </div>

                <?php foreach ($_SESSION["transacoes"] as $index => $transacao):
                    $impacto = $transacao["tipo"] === "receita" ? "+" : "-";
                    $isReceita = $transacao["tipo"] === "receita";
                ?>
                <div class="border-b border-slate-100 last:border-b-0 hover:bg-slate-50 transition-colors">
                    <div class="grid grid-cols-12 gap-4 px-6 py-4 items-center">

                        <div class="col-span-1 text-slate-300 text-sm font-mono">
                            <?php echo str_pad($index + 1, 2, '0', STR_PAD_LEFT); ?>
                        </div>

                        <div class="col-span-4 flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0 <?php echo $isReceita ? 'bg-emerald-100' : 'bg-rose-100'; ?>">
                                <i class="fa-solid <?php echo $isReceita ? 'fa-arrow-down text-emerald-600' : 'fa-arrow-up text-rose-600'; ?> text-xs"></i>
                            </div>
                            <span class="font-semibold text-slate-700 text-sm">
                                <?php echo htmlspecialchars($transacao["descricao"]); ?>
                            </span>
                        </div>

                        <div class="col-span-2">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold <?php echo $isReceita ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700'; ?>">
                                <?php echo ucfirst($transacao["tipo"]); ?>
                            </span>
                        </div>

                        <div class="col-span-2">
                            <span class="font-bold text-sm <?php echo $isReceita ? 'text-emerald-600' : 'text-rose-600'; ?>">
                                R$ <?php echo number_format($transacao["valor"], 2, ',', '.'); ?>
                            </span>
                        </div>

                        <div class="col-span-2">
                            <span class="font-mono text-sm font-semibold <?php echo $isReceita ? 'text-emerald-600' : 'text-rose-600'; ?>">
                                <?php echo $impacto; ?> R$ <?php echo number_format($transacao["valor"], 2, ',', '.'); ?>
                            </span>
                        </div>

                        <div class="col-span-1">
                            <?php if ($transacao["tipo"] === "despesa"): 
                                $relevancia = calcularRelevancia($transacao["valor"], $total_despesas);
                            ?>
                                <div class="flex flex-col gap-1">
                                    <span class="text-xs font-bold text-slate-600">
                                        <?php echo number_format($relevancia, 1); ?>%
                                    </span>
                                    <div class="w-full bg-slate-100 rounded-full h-1.5 overflow-hidden">
                                        <div class="h-1.5 rounded-full bg-rose-400" style="width: <?php echo min($relevancia, 100); ?>%"></div>
                                    </div>
                                </div>
                            <?php else: ?>
                                <span class="text-slate-300 text-xs">—</span>
                            <?php endif; ?>
                        </div>

                    </div>
                </div>
                <?php endforeach; ?>

                <div class="bg-slate-50 px-6 py-4 border-t border-slate-200 flex justify-end items-center gap-6">
                    <div class="text-sm">
                        <span class="text-slate-400">Receitas: </span>
                        <span class="font-bold text-emerald-600">R$ <?php echo number_format($total_receitas, 2, ',', '.'); ?></span>
                    </div>
                    <div class="text-sm">
                        <span class="text-slate-400">Despesas: </span>
                        <span class="font-bold text-rose-600">R$ <?php echo number_format($total_despesas, 2, ',', '.'); ?></span>
                    </div>
                    <div class="bg-blue-600 text-white px-4 py-1.5 rounded-lg text-sm font-bold">
                        Saldo: R$ <?php echo number_format($saldo, 2, ',', '.'); ?>
                    </div>
                </div>

            <?php endif; ?>
        </div>

    </main>
</body>
</html>