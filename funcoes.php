<?php
function listar($id, $limite){
	$lista = array();
	global $pdo;
	$sql = $pdo->prepare("SELECT * FROM usuarios WHERE id_pai = :id");
	$sql->bindValue(":id", $id);
	$sql->execute();

	If($sql->rowCount() > 0){
		$lista = $sql->fetchAll(PDO::FETCH_ASSOC);
		foreach ($lista as $chave => $usuario) {
			$lista[$chave]['filhos'] = array();
			if($limite > 0){
				$lista[$chave]['filhos'] = listar($usuario['id'], $limite - 1);
			}
		}
	}
	return $lista;
}

function exibir($array){
	?>
	<ul>
	<?php foreach ($array as $usuario) { ?>
		<li><?php echo $usuario['nome'].' ('.count($usuario['filhos']).'cadastros diretos)'; ?></li>
		<?php if(count($usuario['filhos']) > 0){
			exibir($usuario['filhos']);
		}?>
	<?php } ?>
	</ul>
<?php } ?>