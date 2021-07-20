<?php 

	class Conexao {

		private $host = 'localhost';
		private $dbname = 'php_com_pdo';
		private $user = 'root';
		private $pass = '';

		public function conectar() {
			try {
				//instanciando um objeto PDO, que é nativo do php.
				$conexao = new PDO(
					//1º parâmetro = DSN(Data Source Name)
					"mysql:host=$this->host;dbname=$this->dbname",
					//2º parâmetro = usuário
					"$this->user",
					//3º parâmetro = senha
					"$this->pass");

				//A variável $conexao é retornada quando o método conectar é executado. Com isso, poderemos usar métodos nátivos do PDO atraves de $conexao.


				return $conexao;

			} catch (PDOException $e) {
				echo '<p>'.$e->getMessage().'</p>';
			}
		}
	}

?>