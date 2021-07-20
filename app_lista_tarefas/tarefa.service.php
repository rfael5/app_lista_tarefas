<?php 

class TarefaService {

	private $conexao;
	private $tarefa;

	/*Os parâmetros $conexao e $tarefa são criados com base nas classes Conexao e Tarefa, respectivamente. Logo, terão os mesmos atributos
	e métodos que essas classes.*/
	public function __construct(Conexao $conexao, Tarefa $tarefa) {
		/*Atribuímos aos atributos $conexao e $tarefa da classe TarefaService, os parâmetros baseados nas classes Conexao e Tarefa. Com isso
		podemos usar os métodos dessas classes através deles.*/
		
		/*Atribuindo a execução do método conectar() à $this->conexao. Esse método instancia um objeto PDO. Com isso poderemos usar os métodos nativos do PDO através desse atributo.*/
		$this->conexao = $conexao->conectar(); 
		$this->tarefa = $tarefa;

	}

	//Inserir valores no banco de dados
	public function inserir(){
		/*variável que conterá o comando para inserir valores na tabela. No value colocamos :tarefa, que é um parâmetro que ira receber
		um valor quando formos tratar o atributo para protegê-lo de SQL Injections.*/
		$query = 'insert into tb_tarefas(tarefa)values(:tarefa)';

		/*Através de $this->conexao, que é um objeto PDO, executamos o método prepare na query, e atribuimos essa query preparada
		à variável $stmt.*/
		$stmt = $this->conexao->prepare($query);
		
		//Através de $stmt, que contem a $query preparada para tratamento, usaremos o bindValue para tratá-la. 
		//No segundo parâmetro, nós usamos o método __get; da classe Tarefa; para recuperar o valor de 'tarefa', que é o valor digitado no //formulário no front-end.
		//O __get atribui esse valor ao atributo $this->tarefa de TarefaService.
		//Atribuímos $this->tarefa ao parâmetro :tarefa, que foi definido como o value à ser inserido na tabela na linha 23. 
		$stmt->bindValue(':tarefa', $this->tarefa->__get('tarefa'));

		//Tendo tratado a query, nós a executamos.
		$stmt->execute();

	}

	//recuperar os valores do banco de dados para mostrá-los na página html
	public function recuperar() {

		//seleciona a tarefa, seu id e seu status
		$query = 'select 
					t.id, s.status, t.tarefa 
				from 
					tb_tarefas as t
					left join tb_status as s on (t.id_status = s.id)';
		$stmt = $this->conexao->prepare($query);
		$stmt->execute();

		//retorna a lista de tarefas em forma de um array de objetos.
		return $stmt->fetchAll(PDO::FETCH_OBJ);

	}

	//Atualizar tarefas
	public function atualizar() {


		$query = "update tb_tarefas set tarefa = :tarefa where id = :id";
		$stmt = $this->conexao->prepare($query);
		$stmt->bindValue(':tarefa',$this->tarefa->__get('tarefa'));
		$stmt->bindValue(':id',$this->tarefa->__get('id'));
		return $stmt->execute();

	}

	//Excluir tarefas
	public function remover() {

		$query = 'delete from tb_tarefas where id = :id';
		$stmt = $this->conexao->prepare($query);
		$stmt->bindValue(':id',$this->tarefa->__get('id'));
		$stmt->execute();

	}

	//Muda o status da tarefa de pendente para realizada.
	public function marcarRealizada() {


		$query = "update tb_tarefas set id_status = ? where id = ?";
		$stmt = $this->conexao->prepare($query);
		$stmt->bindValue(1,$this->tarefa->__get('id_status'));
		$stmt->bindValue(2,$this->tarefa->__get('id'));
		return $stmt->execute();

	}

	//Mostra somente as tarefas pendentes na página index.html
	public function recuperarTarefasPendentes() {
		$query = 'select 
					t.id, s.status, t.tarefa 
				from 
					tb_tarefas as t
					left join tb_status as s on (t.id_status = s.id)
				where 
					t.id_status = :id_status';
		$stmt = $this->conexao->prepare($query);
		$stmt->bindValue(':id_status',$this->tarefa->__get('id_status'));
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_OBJ);
	}

	
}

?>