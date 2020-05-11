<?php
session_start();
require 'config.php';
require 'funcoes.php';

if(empty($_SESSION['mmnlogin'])){
	header("Location: login.php");
	exit;
}
//pegar o nome de quem tá logado e mostrar
$id = $_SESSION['mmnlogin'];

$sql = $pdo->prepare("SELECT nome FROM usuarios WHERE id = :id");
$sql->bindValue(":id", $id);
$sql->execute();

if($sql->rowCount() > 0){
	$sql = $sql->fetch();
	$nome = $sql['nome'];
}else{
	header("Location: login.php");
	exit;
}
$lista = listar($id, $limite);



?>

<h1>Sistema de Marketing Multinível</h1>
<h2>Usuário Logado: <?php echo $nome; ?></h2>

<a href="cadastro.php">Cadastrar novo usuário</a>
<a href="sair.php">SAIR</a>

<hr/>

<h4>Lista de cadastros</h4>
<!--<pre>
	/*<?php print_r($lista); ?>
</pre>
<ul>
<?php foreach($lista as $usuario):?>
	<li> <?php echo $usuario['nome']; ?></li>
<?php endforeach; ?>*/
</ul>-->

<?php exibir($lista); ?>