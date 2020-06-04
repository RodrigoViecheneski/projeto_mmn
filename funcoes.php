<?php
function listar($id, $limite){
	$lista = array();
	global $pdo;
	//$sql = $pdo->prepare("SELECT * FROM usuarios WHERE id_pai = :id");
	$sql = $pdo->prepare("SELECT 
		usuarios.id, usuarios.id_pai, usuarios.patente, usuarios.nome, patentes.nome as p_nome 
		FROM usuarios
		LEFT JOIN patentes ON patentes.id = usuarios.patente 
		WHERE usuarios.id_pai = :id");
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
		<li><?php echo $usuario['nome'].'('.$usuario['p_nome'].') -- ('.count($usuario['filhos']).'cadastros diretos)'; ?></li>
		<?php if(count($usuario['filhos']) > 0){
			exibir($usuario['filhos']);
		}?>
	<?php } ?>
	</ul>
<?php } ?>



<?php
function calcular_cadastros($id, $limite){
	$lista = array();
	global $pdo;
	$sql = $pdo->prepare("SELECT * FROM usuarios WHERE id_pai = :id");
	$sql->bindValue(":id", $id);
	$sql->execute();
	$filhos = 0;
	
	If($sql->rowCount() > 0){
		$lista = $sql->fetchAll(PDO::FETCH_ASSOC);
		$filhos = $sql->rowCount();

		foreach ($lista as $chave => $usuario) {
			if($limite > 0){

				$filhos += calcular_cadastros($usuario['id'], $limite-1);
			}
		}
	}
	return $filhos;
}