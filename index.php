<?php 
ob_start();
include 'funcoes.php';
verificarAcesso();
//session_start();

$totalReceitas = 0;
$totalDespesas = 0;

foreach ($_SESSION['transacoes'] as $t) {
    if ($t['tipo'] === 'receita') {
        $totalReceitas += $t['valor'];
    } else {
        $totalDespesas += $t['valor'];
    }
}

$saldoDisponivel = $totalReceitas - $totalDespesas;
$quantidadeTransacoes = count($_SESSION['transacoes']);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyWallet - Dashboard</title>
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
                <span class="text-sm">Olá, <?php echo $_SESSION['nome']; ?></span>
                <a href="logout.php" class="bg-red-500 hover:bg-red-600 px-4 py-1.5 rounded-md text-sm font-bold transition-all">Sair</a>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-6 py-10">
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            <div class="bg-white rounded-xl shadow-sm p-6 border border-slate-200">
                <p class="text-slate-500 text-xs font-bold uppercase tracking-wider mb-1">Total Receitas</p>
                <h3 class="text-3xl font-extrabold text-emerald-600">
                    <?php echo formatarMoeda($totalReceitas); ?>
                </h3>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-6 border border-slate-200">
                <p class="text-slate-500 text-xs font-bold uppercase tracking-wider mb-1">Total Despesas</p>
                <h3 class="text-3xl font-extrabold text-rose-600">
                    <?php echo formatarMoeda($totalDespesas); ?>
                </h3>
            </div>

            <div class="bg-blue-600 rounded-xl shadow-lg p-6 text-white">
                <p class="text-blue-100 text-xs font-bold uppercase tracking-wider mb-1">Saldo em Conta</p>
                <h3 class="text-3xl font-extrabold">
                    <?php echo formatarMoeda($saldoDisponivel); ?>
                </h3>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="bg-slate-50 px-6 py-4 border-b border-slate-200">
                <h2 class="font-bold text-slate-700">Registrar Nova Movimentação</h2>
            </div>
            
            <form action="salvar_transacao.php" method="POST" class="p-6 grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Descrição</label>
                    <input type="text" name="descricao" required placeholder="Ex: Mercado" 
                        class="w-full bg-slate-50 border border-slate-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Valor (R$)</label>
                    <input type="number" step="0.01" name="valor" required placeholder="0.00"
                        class="w-full bg-slate-50 border border-slate-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Categoria/Tipo</label>
                    <select name="tipo" class="w-full bg-slate-50 border border-slate-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
                        <option value="receita">Receita (Entrada)</option>
                        <option value="despesa">Despesa (Saída)</option>
                    </select>
                </div>
                <button type="submit" class="bg-slate-900 hover:bg-black text-white font-bold py-2 rounded-lg transition-all shadow-md">
                    <i class="fa-solid fa-check mr-2"></i>Salvar
                </button>
            </form>
        </div>

        <div class="mt-10 flex justify-center">
            <a href="historico.php" class="inline-flex items-center gap-2 text-slate-500 hover:text-blue-600 font-semibold transition-colors">
                <i class="fa-solid fa-list-ul"></i>
                Ver Detalhes do Histórico (<?php echo $quantidadeTransacoes; ?> registros)
            </a>
        </div>

    </main>
</body>
</html>