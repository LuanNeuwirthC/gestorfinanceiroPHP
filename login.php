<?php
ob_start();
session_start(); 

$email="joaozin.da.silva32@gmail.com";
$senha=password_hash("24124", PASSWORD_BCRYPT);
$nome='João da Silva'; 


  function validarSenha($senhaDigitada, $hashSalvo) {
    return password_verify($senhaDigitada, $hashSalvo);
}

$erro = "";

  if ($_SERVER["REQUEST_METHOD"] === "POST") {

     $emailDigitado = $_POST["email"];
     $senhaDigitada = $_POST["senha"];

    if ($emailDigitado === $email && validarSenha($senhaDigitada, $senha)) {
        $_SESSION["nome"]   = $nome;
        $_SESSION["logado"] = true;

        header("Location: index.php");
        exit();
    } else {
        $erro = "E-mail ou senha incorretos.";
    }
}

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyWallet - Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style> body { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; } </style>
</head>
<body class="flex items-center justify-center font-sans">

    <div class="bg-white rounded-xl shadow-2xl w-full max-w-sm overflow-hidden">
        <div class="bg-slate-900 text-white text-center py-8">
            <i class="fa-solid fa-wallet text-4xl mb-2"></i>
            <h1 class="text-2xl font-bold">MyWallet</h1>
            <p class="text-xs text-slate-400">Gestão Financeira Pessoal</p>
        </div>

        <div class="p-8">
            <?php if(!empty($erro)): ?>
                <div class="bg-red-100 text-red-600 p-3 rounded-lg text-sm mb-4 text-center">
                    <?php echo $erro; ?>
                </div>
            <?php endif; ?>

            <form action="login.php" method="post" class="flex flex-col gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">E-mail</label>
                    <div class="relative">
                        <i class="fa-regular fa-user absolute left-3 top-3 text-slate-400"></i>
                        <input type="text" name="email" value="joaozin.da.silva32@gmail.com" class="w-full bg-slate-50 border border-slate-300 rounded-lg pl-10 pr-4 py-2 focus:ring-2 focus:ring-purple-500 outline-none">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Senha</label>
                    <div class="relative">
                        <i class="fa-solid fa-lock absolute left-3 top-3 text-slate-400"></i>
                        <input type="password" name="senha" placeholder="••••••" class="w-full bg-slate-50 border border-slate-300 rounded-lg pl-10 pr-4 py-2 focus:ring-2 focus:ring-purple-500 outline-none">
                    </div>
                </div>

                <button type="submit" class="w-full bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 rounded-lg transition-all mt-2">
                    ENTRAR NO SISTEMA
                </button>
            </form>
            <p class="text-center text-xs text-slate-400 mt-6">PHP Academic Project &copy; 2024</p>
        </div>
    </div>

</body>
</html>