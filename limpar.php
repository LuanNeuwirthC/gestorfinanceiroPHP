<?php 

session_start();

 $_SESSION['transacoes'] = [];
  header("Location: historico.php");
exit();

?>