<?php

//A classe Tarefa é o modelo das tarefas que adicionaremos no nosso banco de dados. Seus atributos são
//as informações que cada tarefa terá ao ser adicionada ao banco.

class Tarefa {
	private $id;
	private $id_status;
	private $tarefa;
	private $data_cadastro;

	//Com a função __get podemos recuperar e retornar um dos atributos da tarefa.
	public function __get($atributo) {
		return $this->$atributo;
	}

	//Com a função set, podemos estabelecer o valor que quisermos à cada atributo da tarefa.
	public function __set($atributo, $valor) {
		$this->$atributo = $valor;
	}
}

?>