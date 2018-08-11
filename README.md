Sobre O vDOC [1.2F]
===============

 O **vDOC** é uma simples classe que valida (e agora deixa no formato padrão) que facilita muitos desenvolvedores que ultilizar em cadastro a opção de preenchimento de documentos (In Especial CPF/CNPJ). 
 
 Como Usar?
===============

 Veja um exemplo para validação de CPF/CNPJ:
 
 ```php
<?php
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
```

A função acima apenas valida o CPF/CNPJ automaticamente.
 
Se o CPF/CNPJ for falso, retorna false, caso contrário, retorna valor true(verdadeiro).
 
 Veja um exemplo para validação & formatação de CPF/CNPJ:
 
 ```php
<?php
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
```

 UPDATES:
===============

 V1.2 = [UPDATE] -> Formatação De CPF/CNPJ;
 
 V1.0 = [Inicio] -> Validação de CPF/CNPJ;
