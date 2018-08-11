<?php
/*
#################################################################
#	Veja um exemplo para validação & formatação de CPF/CNPJ:	#
#################################################################
*/
   // Chamar A Classe:
   require('class/classe-vdoc.php');
   // Cria um objeto sobre a classe:
   $doc = new vdoc('13347016000117');
   // Opção de CPF ou CNPJ formatado no padrão:
   $docformat = $doc->formata();
   // Verifica se o CPF/CNPJ é válido
   if($docformat):
   	echo $docformat; // 13.347.016/0001-17
   else:
   	echo 'CPF/CNPJ Inválido';
   endif;
?>