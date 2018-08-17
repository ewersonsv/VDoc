<?php 
	require './class/classe-vdoc.php';
	$doc = filter_input(INPUT_GET, 'doc');
	$doc = preg_replace( '/[^0-9]/', '', $doc );
	if(isset($doc)){
		if(strlen($doc) > 10){
			$cpf_cnpj = new ValidaCPFCNPJ($doc);
			// Verifica se o CPF ou CNPJ é válido
			if ( $cpf_cnpj->valida() ) {
				if(strlen($doc) > 13){ //CNPJ 14 Caracteres
					$msgErro = 'Já Existe Conta Usando Este '.'<u>'.'CNPJ'.'</u>'.' Em Nosso Sistema...';
					echo '<label id="cdoc-error" class="error" for="cdoc">'.$msgErro.'</label>';
				}else{ //CPF 11 Caracteres
					$msgErro = 'Já Existe Conta Usando Este '.'<u>'.'CPF'.'</u>'.' Em Nosso Sistema...';
					echo '<label id="cdoc-error" class="error" for="cdoc">'.$msgErro.'</label>';
				}
			} else {
				if(strlen($doc) > 13){ //CNPJ 14 Caracteres
					$msgErro = '<u>'.'CNPJ'.'</u>'.' Inválido!';
					echo '<label id="cdoc-error" class="error" for="cdoc">'.$msgErro.'</label>';
				}else{ //CPF 11 Caracteres
					$msgErro = '<u>'.'CPF'.'</u>'.' Inválido!';
					echo '<label id="cdoc-error" class="error" for="cdoc">'.$msgErro.'</label>';
				}
			}
		}else{
			$msgErro = 'O campo <u>CPF/CNPJ</u> deve conter no mínimo 11 caracteres.';
			echo '<label id="cdoc-error" class="error" for="cdoc">'.$msgErro.'</label>';
		}
	}
?>
