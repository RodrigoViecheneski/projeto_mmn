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

$sql = $pdo->prepare("SELECT
 usuarios.nome,
 patentes.nome as p_nome
 FROM usuarios
 LEFT JOIN patentes ON patentes.id = usuarios.patente 
 WHERE usuarios.id = :id");
$sql->bindValue(":id", $id);
$sql->execute();

if($sql->rowCount() > 0){
	$sql = $sql->fetch();
	$nome = $sql['nome'];
	$p_nome = $sql['p_nome'];
}else{
	header("Location: login.php");
	exit;
}
$lista = listar($id, $limite);



?>

<h1>Sistema de Marketing Multinível</h1>
<h2>Usuário Logado: <?php echo $nome. ' ('.$p_nome.')'; ?></h2>

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