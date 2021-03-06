<?php
/**
 * vDoc valida e formata CPF/CNPJ
 *
 * Exemplo de uso:
 * $doc  = new vdoc('71569042000196');
 * $docformat = $doc->formata(); // 13.347.016/0001-17
 * $validar    = $doc->valida(); // True -> Válido
 *
 * @package  vDoc
 * @author   Ewerson S. <sem@email.com>
 * @version  v1.2F
 * @access   public
 * @see      https://github.com/ewersonsv
 */
class vdoc{
	/** 
	 * Configura o valor (Construtor)
	 * Remove caracteres inválidos do CPF/CNPJ
	 * @param string $valor - O CPF/CNPJ
	 **/
	function __construct($valor = null){
		// Deixa apenas números no valor
		$this->valor = preg_replace('/[^0-9]/', '', $valor);
		// Garante que o valor é uma string
		$this->valor = (string)$this->valor;
	}
	/**
	 * Verifica se é CPF/CNPJ
	 * Se for CPF tem 11 caracteres, CNPJ tem 14
	 * @access protected
	 * @return string CPF, CNPJ ou false
	 */
	protected function validardoc () {
		// Verifica CPF
		if(strlen( $this->valor) === 11){
			return 'CPF';
		} 
		// Verifica CNPJ
		elseif ( strlen( $this->valor ) === 14 ) {
			return 'CNPJ';
		} 
		// Não retorna nada
		else {
			return false;
		}
	}
	/**
	 * Multiplica dígitos vezes posições:
	 * @access protected
	 * @param  string    $digitos      Os digitos desejados
	 * @param  int       $posicoes     A posição que vai iniciar a regressão
	 * @param  int       $soma_digitos A soma das multiplicações entre posições e dígitos
	 * @return int                     Os dígitos enviados concatenados com o último dígito
	 */
	protected function calcdigtposition ( $digitos, $posicoes = 10, $soma_digitos = 0 ) {
		// Faz a soma dos dígitos com a posição
		// Ex. para 10 posições:
		//   0    2    5    4    6    2    8    8   4
		// x10   x9   x8   x7   x6   x5   x4   x3  x2
		//   0 + 18 + 40 + 28 + 36 + 10 + 32 + 24 + 8 = 196
		for ( $i = 0; $i < strlen( $digitos ); $i++ ) {
			// Preenche a soma com o dígito vezes a posição
			$soma_digitos = $soma_digitos + ( $digitos[$i] * $posicoes );

			// Subtrai 1 da posição
			$posicoes--;

			// Parte específica para CNPJ
			// Ex.: 5-4-3-2-9-8-7-6-5-4-3-2
			if ( $posicoes < 2 ) {
				// Retorno a posição para 9
				$posicoes = 9;
			}
		}

		// Captura o resto da divisão entre $soma_digitos dividido por 11
		// Ex.: 196 % 11 = 9
		$soma_digitos = $soma_digitos % 11;

		// Verifica se $soma_digitos é menor que 2
		if ( $soma_digitos < 2 ) {
			// $soma_digitos agora será zero
			$soma_digitos = 0;
		} else {
			// Se for maior que 2, o resultado é 11 menos $soma_digitos
			// Ex.: 11 - 9 = 2
			// Nosso dígito procurado é 2
			$soma_digitos = 11 - $soma_digitos;
		}

		// Concatena mais um dígito aos primeiro nove dígitos
		// Ex.: 025462884 + 2 = 0254628842
		$cpf = $digitos . $soma_digitos;

		// Retorna
		return $cpf;
	}
	/**
	 * Valida CPF
	 * @author   Ewerson S. <sem@email.com>
	 * @access protected
	 * @param  string    $cpf O CPF com ou sem pontos e traço
	 * @return bool           True para CPF correto - False para CPF incorreto
	 */
	protected function validarCPF() {
		// Captura os 9 primeiros dígitos do CPF
		// Ex.: 02546288423 = 025462884
		$digitos = substr($this->valor, 0, 9);
		// Faz o cálculo dos 9 primeiros dígitos do CPF para obter o primeiro dígito
		$novo_cpf = $this->calcdigtposition( $digitos );
		// Faz o cálculo dos 10 dígitos do CPF para obter o último dígito
		$novo_cpf = $this->calcdigtposition( $novo_cpf, 11 );
		// Verifica se o novo CPF gerado é idêntico ao CPF enviado
		if ( $novo_cpf === $this->valor ) {
			// CPF válido
			return true;
		} else {
			// CPF inválido
			return false;
		}
	}
	/**
	 * Valida CNPJ
	 *
	 * @author   Ewerson S. <sem@email.com>
	 * @access protected
	 * @param  string     $cnpj
	 * @return bool             true para CNPJ correto
	 */
	protected function validarCNPJ () {
		// O valor original
		$cnpj_original = $this->valor;
		// Captura os primeiros 12 números do CNPJ
		$primeiros_numeros_cnpj = substr( $this->valor, 0, 12 );
		// Faz o primeiro cálculo
		$primeiro_calculo = $this->calcdigtposition( $primeiros_numeros_cnpj, 5 );
		// O segundo cálculo é a mesma coisa do primeiro, porém, começa na posição 6
		$segundo_calculo = $this->calcdigtposition( $primeiro_calculo, 6 );
		// Concatena o segundo dígito ao CNPJ
		$cnpj = $segundo_calculo;
		// Verifica se o CNPJ gerado é idêntico ao enviado
		if ( $cnpj === $cnpj_original ) {
			return true;
		}
	}

	/**
	 * Valida
	 * Valida o CPF/CNPJ
	 * @access public
	 * @return bool      True para válido, false para inválido
	 */
	public function valida () {
		// Valida CPF
		if ( $this->validardoc() === 'CPF' ) {
			// Retorna true para cpf válido
			return $this->validarCPF();
		} 
		// Valida CNPJ
		elseif ( $this->validardoc() === 'CNPJ' ) {
			// Retorna true para CNPJ válido
			return $this->validarCNPJ();
		} 
		// Não retorna nada
		else {
			return false;
		}
	}
	/**
	 * Formata CPF/CNPJ
	 *
	 * @access public
	 * @return string  CPF/CNPJ docformat
	 */
	public function formata() {
		// O valor docformat
		$docformat = false;

		// Valida CPF
		if ( $this->validardoc() === 'CPF' ) {
			// Verifica se o CPF é válido
			if ( $this->validarCPF() ) {
				// Formata o CPF ###.###.###-##
				$docformat  = substr( $this->valor, 0, 3 ) . '.';
				$docformat .= substr( $this->valor, 3, 3 ) . '.';
				$docformat .= substr( $this->valor, 6, 3 ) . '-';
				$docformat .= substr( $this->valor, 9, 2 ) . '';
			}
		} 
		// Valida CNPJ
		elseif ( $this->validardoc() === 'CNPJ' ) {
			// Verifica se o CPF é válido
			if ( $this->validarCNPJ() ) {
				// Formata o CNPJ ##.###.###/####-##
				$docformat  = substr( $this->valor,  0,  2 ) . '.';
				$docformat .= substr( $this->valor,  2,  3 ) . '.';
				$docformat .= substr( $this->valor,  5,  3 ) . '/';
				$docformat .= substr( $this->valor,  8,  4 ) . '-';
				$docformat .= substr( $this->valor, 12, 14 ) . '';
			}
		} 

		// Retorna o valor 
		return $docformat;
	}
}
?>
