<?php

namespace App\Models;

class Connection{
    //responsavel por criar conexao com o banco
    public static function getDb(){
        try{
            $conn = new \PDO(
                "mysql:host=localhost;dbname=dashboard;charset=utf8",
                "root",
                ""
            );

            return $conn;
        }catch(\PDOException $e){
            //... tratar de alguma forma ...//
        }
    }
}

class Dashboard{
    public $data_inicio;
    public $data_fim;
    public $numeroVendas;
    public $totalVendas;
    public $clientes_ativos;
    public $clientes_inativos;

    public function __get($attr){
        return $attr;
    }

    public function __set($attr, $valor){
        $this->$attr = $valor;
    }

}

class Bd{
    private $dashboard;
    private $con;
    public function __construct(Dashboard $dashboard,$con){
        $this->dashboard = $dashboard;
        $this->con = $con;
    }
    public function getNumeroVendas(){
        $query = 'SELECT COUNT(*) as numero_de_vendas FROM tb_vendas WHERE data_venda BETWEEN :data_inicio AND :data_fim';
        $stmt = $this->con->prepare($query);
        $stmt->bindValue(':data_inicio',$this->dashboard->data_inicio);
        $stmt->bindValue(':data_fim',$this->dashboard->data_fim);
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_OBJ)->numero_de_vendas;
    }
    public function getTotalVendas(){
        $query = 'SELECT SUM(total) as total_de_vendas FROM tb_vendas WHERE data_venda BETWEEN :data_inicio AND :data_fim';
        $stmt = $this->con->prepare($query);
        $stmt->bindValue(':data_inicio',$this->dashboard->data_inicio);
        $stmt->bindValue(':data_fim',$this->dashboard->data_fim);
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_OBJ)->total_de_vendas;
    }

    public function getClientesAtivos(){
        $query = 'SELECT COUNT(*) as clientes_ativos FROM tb_clientes WHERE cliente_ativo = 1 ';
        $stmt = $this->con->prepare($query);
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_OBJ)->clientes_ativos;
    }
    public function getClientesInativos(){
        $query = 'SELECT COUNT(*) as clientes_inativos FROM tb_clientes WHERE cliente_ativo = 0 ';
        $stmt = $this->con->prepare($query);
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_OBJ)->clientes_inativos;
    }

}

$dashboard = new Dashboard();

//Criando dinamicamente o mes
$competencia = explode('-',$_POST['competencia']) ;
$ano = $competencia[0];
$mes = $competencia[1];

//veriicando quantidade de dias no respectivo mês
$dias_do_mes = cal_days_in_month(CAL_GREGORIAN, $mes, $ano);
$data_inicio = "$ano-$mes-01";
$data_fim = "$ano-$mes-$dias_do_mes";

$dashboard->__set('data_inicio',$data_inicio);
$dashboard->__set('data_fim',$data_fim);
//******************** */

$bd = new Bd($dashboard,Connection::getDb());
//*Populando o objeto com os dados recuperados no bd
$NDV = $bd->getNumeroVendas();
$TDV = $bd->getTotalVendas();
$CA = $bd->getClientesAtivos();
$CI = $bd->getClientesInativos();
$dashboard->__set('numeroVendas',$NDV);
$dashboard->__set('totalVendas',$TDV);
$dashboard->__set('clientes_ativos',$CA);
$dashboard->__set('clientes_inativos',$CI);

echo json_encode($dashboard);

?>