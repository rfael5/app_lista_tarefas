<?php 

	/*Você precisa usar o require no contexto do arquivo no qual ele será usado. Nesse caso, este
	arquivo será usado por um arquivo dentro de htdocs, por isso, apesar dos arquivos requeridos estarem nessa mesma pasta, você precisa escrever o caminho como se estivesse fazendo a requisição de dentro de htdocs*/

	require '../../../app_lista_tarefas/tarefa.model.php';
	require '../../../app_lista_tarefas/tarefa.service.php';
	require '../../../app_lista_tarefas/conexao.php';

	//Se o parâmetro acao estivar estabelecido, você retorna seu valor à variável $acao. 
	//Caso contrário, você o recupera com o método $_GET.
	$acao = isset($_GET['acao']) ? $_GET['acao'] : $acao;


	//Dependendo do valor que o parâmetro $acao receber, um dos blocos abaixo será executado.

	//Insere um valor na tabela de tarefas
	if($acao == 'inserir'){
		
		//Instanciando um objeto Tarefa, que contém o modelo das tarefas a serem cadastradas.
		$tarefa = new Tarefa();

		//Estabelece o valor do atributo tarefa como sendo o valor recuperado pelo $_POST no formulário.
		$tarefa->__set('tarefa', $_POST['tarefa']);
	
		//Instancianto um objeto Conexao, que é um objeto PDO e vai nos permitir usar métodos nativos do PDO.
		$conexao = new Conexao();

		//Instanciando TarefaService, que contém os métodos para inserir, atualizar, recuperar e remover tarefas
		//do banco de dados.	
		$tarefaService = new TarefaService($conexao, $tarefa);
	
		//Inserindo os dados na tabela através do método inserir do objeto TarefaService.
		$tarefaService->inserir();
	
		//Direciona essa pagina para nova_tarefa.php
		header('Location: nova_tarefa.php?inclusao=1');

	//'recuperar' vai mostrar as tarefas na página.
	}else if($acao == 'recuperar'){
		
		$tarefa = new Tarefa();
		$conexao = new Conexao();

		$tarefaService = new TarefaService($conexao,$tarefa);

		$tarefas = $tarefaService->recuperar();

	//Vai mudar as tarefas
	}else if($acao == 'atualizar'){
		
		$tarefa = new Tarefa();

		//setando os valores no banco de dados com o valor recuperado no formulário.
		$tarefa->__set('id',$_POST['id']);
		$tarefa->__set('tarefa',$_POST['tarefa']);

		$conexao = new Conexao();
		$tarefaService = new TarefaService($conexao,$tarefa);

		//caso o metodo atualizar seja executado, o usuário será direcionado para uma das páginas abaixo.
		if($tarefaService->atualizar()) {
			if(isset($_GET['pag']) && $_GET['pag'] == 'index'){
				header('Location: index.php');
			} else {
				header('Location: todas_tarefas.php');}
			}
	
	//Exclui uma tarefa	
	}else if($acao == 'remover'){
		$tarefa = new Tarefa;
		//setando os valores que serão excluidos
		$tarefa->__set('id',$_GET['id']);

		$conexao = new Conexao;
		$tarefaService = new TarefaService($conexao,$tarefa);

		//remove os valores setados em $tarefa
		$tarefaService->remover();

		if(isset($_GET['pag']) && $_GET['pag'] == 'index'){
			header('Location: index.php');
		}else{
			header('Location: todas_tarefas.php');}

	//Muda o status de uma tarefa de pendente para realizada
	}else if ($acao == 'marcarRealizada') {
		$tarefa = new Tarefa();
		$tarefa->__set('id',$_GET['id']);

		//seta id_status como 2, que corresponde à tarefa realizada.
		$tarefa->__set('id_status',2);

		$conexao = new Conexao();

		$tarefaService = new TarefaService($conexao,$tarefa);
		$tarefaService->marcarRealizada();


		if(isset($_GET['pag']) && $_GET['pag'] == 'index'){
			header('Location: index.php');
		}else{
			header('Location: todas_tarefas.php');}

	//Recupera somente as tarefas pendentes na página index.php.	
	}else if ($acao == 'recuperarTarefasPendentes') {
		$tarefa = new Tarefa();
		$tarefa->__set('id_status',1);
		$conexao = new Conexao();

		$tarefaService = new TarefaService($conexao,$tarefa);

		$tarefas = $tarefaService->recuperarTarefasPendentes();
	}
		

?>
