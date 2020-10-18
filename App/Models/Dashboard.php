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
}

$dashboard = new Dashboard();
$dashboard->__set('data_inicio','2018-08-01');
$dashboard->__set('data_fim','2018-08-31');
$bd = new Bd($dashboard,Connection::getDb());

$NDV = $bd->getNumeroVendas();
$TDV = $bd->getTotalVendas();
$dashboard->__set('numeroVendas',$NDV);
$dashboard->__set('totalVendas',$TDV);

echo json_encode($dashboard);

?>