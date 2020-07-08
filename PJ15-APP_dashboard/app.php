<?php  


//classe dashboard

class Dashboard{
	public $data_inicio;
	public $data_fim;
	public $numeroVendas;
	public $totalVendas;
	public $clientesAtivos;
	public $clientesInativos;
	public $totalCriticas;
	public $totalElogios;
	public $totalSugestao;
	public $total_despesas;


	public function __get($atributo){
		return $this->$atributo;
	}

	public function __set($atributo,$valor){
		$this->$atributo = $valor;
		return $this; //retorna o proprio objeto
	}

}

//classe conexão bd

	class Conexao{
		private $host ='localhost';
		private $dbname = 'dashboard';
		private $user ='root';
		private $pass ='';

	public function conectar(){
		try{
			
			$conexao = new PDO(
				"mysql:host=$this->host;dbname=$this->dbname",
				"$this->user",
				"$this->pass"	
			);

			//fazendo com q nossa instancia com banco de dados esteja na msm linguagem que o frontend e backend da nossa aplicacao utf8
			$conexao->exec('set charset set utf8');

			return $conexao;

		}catch(PDOExcepetion $e){
			echo '<p>' . $e->getMessage() . '</p>';
		}

	}	

}

//classe (model)	

 class Bd{
 	private $conexao;
 	private $dashboard;


 	public function __construct (Conexao $conexao, Dashboard $dashboard){
 
 	$this->conexao = $conexao->conectar();
 	$this->dashboard = $dashboard ;
	}

	public function getNumeroVendas(){
		$query = '
				select 
					count(*) as numero_vendas
				  from
				    tb_vendas 
				  where 
				    data_venda between :data_inicio and :data_fim';

		$stmt = $this->conexao->prepare($query);
		$stmt->bindValue(':data_inicio', $this->dashboard->__get('data_inicio'));
		$stmt->bindValue(':data_fim', $this->dashboard->__get('data_fim'));
		$stmt->execute();

		return $stmt->fetch(PDO::FETCH_OBJ)->numero_vendas;


	}

	public function getTotalVendas(){
		$query = '
				select 
					SUM(total) as total_vendas
				  from
				    tb_vendas 
				  where 
				    data_venda between :data_inicio and :data_fim';

		$stmt = $this->conexao->prepare($query);
		$stmt->bindValue(':data_inicio', $this->dashboard->__get('data_inicio'));
		$stmt->bindValue(':data_fim', $this->dashboard->__get('data_fim'));
		$stmt->execute();

		return $stmt->fetch(PDO::FETCH_OBJ)->total_vendas;


	}

	public function getClientesAtivos(){
		$query = 'select count(*) as qtd_clientes_ativos from `tb_clientes` where cliente_ativo = 1 ';
		$stmt = $this->conexao->query($query);

		return $stmt->fetch(PDO::FETCH_OBJ)->qtd_clientes_ativos;	
	}

	public function getClientesInativos(){
		$query = 'select count(*) as qtd_clientes_inativos from `tb_clientes` where cliente_ativo = 0 ';
		$stmt = $this->conexao->query($query);

		return $stmt->fetch(PDO::FETCH_OBJ)->qtd_clientes_inativos;	
	}

	public function totalCriticas(){
		$query = 'select count(*) as qtd_criticas from `tb_contatos` where tipo_contato = 1';
		$stmt = $this->conexao->query($query);

		return $stmt->fetch(PDO::FETCH_OBJ)->qtd_criticas;
	}

	public function totalElogios(){
		$query = 'select count(*) as qtd_elogios from `tb_contatos` where tipo_contato = 3';
		$stmt = $this->conexao->query($query);

		return $stmt->fetch(PDO::FETCH_OBJ)->qtd_elogios;
	}

	public function totalSugestao(){
		$query = 'select count(*) as qtd_sugestao from `tb_contatos` where tipo_contato = 2';
		$stmt = $this->conexao->query($query);

		return $stmt->fetch(PDO::FETCH_OBJ)->qtd_sugestao;
	}

	public function totalDespesas(){
		$query = 'select sum(total) as total_despesas from `tb_despesas` where data_despesa between :data_inicio AND :data_fim';
		$stmt = $this->conexao->prepare($query);
		$stmt->bindValue(':data_inicio', $this->dashboard->__get('data_inicio'));
		$stmt->bindValue(':data_fim', $this->dashboard->__get('data_fim'));
		$stmt->execute();

		return $stmt->fetch(PDO::FETCH_OBJ)->total_despesas;
	}

 }

//logica script
 $dashboard = new Dashboard();
 $conexao = new Conexao();

 $competencia = explode('-' ,$_GET['competencia']);
 $ano = $competencia[0];
 $mes = $competencia[1];

 //calcular quantos meses existe em um respectivo ano
 //primeiro parametro tipo de calendario no caso americado, segundo mes, terceiro ano, o resultado é a quantidade de dias deste mes no respectivo ano
 $dias_do_mes = cal_days_in_month(CAL_GREGORIAN, $mes,$ano);

 $dashboard->__set('data_inicio', $ano.'-'.$mes.'-01');
 $dashboard->__set('data_fim', $ano.'-'.$mes.'-'.$dias_do_mes);

 $bd = new Bd($conexao, $dashboard);

 $dashboard->__set('numeroVendas', $bd->getNumeroVendas());	
 $dashboard->__set('totalVendas', $bd->getTotalVendas());
 $dashboard->__set('clientesAtivos', $bd->getClientesAtivos());
 $dashboard->__set('clientesInativos', $bd->getClientesInativos());
 $dashboard->__set('totalCriticas',$bd->totalCriticas());
 $dashboard->__set('totalElogios',$bd->totalElogios());
 $dashboard->__set('totalSugestao',$bd->totalSugestao());
 $dashboard->__set('totalDespesas',$bd->totalDespesas());

 echo json_encode($dashboard);
 
 



?>