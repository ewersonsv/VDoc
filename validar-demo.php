<?php
/*
#####################################################
#	 Veja um exemplo para validação de CPF/CNPJ:	#
#####################################################
*/
// Chamar A Classe:
   	require('class/classe-vdoc.php');
// Cria um objeto sobre a classe
   	$doc = new vdoc('13.347.016/0001-17');
// Verifica se o CPF ou CNPJ é válido
   	if($doc->valida()):
		echo 'CPF/CNPJ válido'; // Retornará este valor
   	else:
   		echo 'CPF/CNPJ Inválido';
   	endif;
?>