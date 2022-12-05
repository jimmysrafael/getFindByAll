<?php

require_once '../../../conexao_bd/db/ConMysqlPdo.php'; //Importando conexão do banco de dados
require_once '../../../classe/classe/model/classe.php'; //Importando classe

class Classe {

    public static function getFindByAll(array $inputs = null) {
        //Filtro
        $param = [];
        $param_where = '1=1';

        if (isset($inputs['id'])) {
            $param[':id'] = $inputs['id'];
            $param_where .= ' and id = :id';
        }
        if (isset($inputs['descricao'])) {
            $param[':descricao'] = $inputs['descricao'];
            $param_where .= ' and descricao = :descricao';
        }
        //Fim do filtro
        try {
            $PDO = ConMysqlPdo::getInstance();
            $sql = " select id,
                            descricao
                            from classe
                            where $param_where";
            $stm = $PDO->prepare($sql);
            $stm->execute($param);

            $results = array();

            while ($row = $stm->fetch(PDO::FETCH_OBJ)) {

                $objeto = new Linha();

                $objeto->set_id($row->id);
                $objeto->set_descricao($row->descricao);

                $results[] = $objeto;
            }
            return $results;
        } catch (Exception $e) {
            throw new Exception("Mensagem: Erro de Banco" . $e->getMessage());
        }
    }
}