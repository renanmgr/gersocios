<?php

class Application_Model_Socio extends Zend_Db_Table_Abstract
{

    protected $_name = 'socio';
    protected $_primary = 'Id';
    protected $_dependentTables = array('Application_Model_SocioEmpresa');

    public function inserir(Array $dados) {
        try {
            parent::insert($dados);
        }
        catch (Zend_Db_Exception $e) {
            echo $e->getMessage();
        }
    }
    
    public function listar() {       
        $db = Zend_Registry::get('db');
        
        $sql = "select * from socio";
        
        return $db->fetchAll($sql);
    }
    
    public function atualizar(Array $dados, $id) {
        try {
            $where = $this->getAdapter()->quoteInto("Id=?", $id);
            return parent::update($dados, $where);
        }
        catch (Zend_Db_Exception $e) {
            echo $e->getMessage();
        }
    }
    
    public function delete($id) {
        try {
            $where = $this->getAdapter()->quoteInto("Id=?", $id);
            return parent::delete($where);
        }
        catch (Zend_Db_Exception $e) {
            echo $e->getMessage();
        }
    }
    
    public function recuperarPorCPF($cpf) {       
        $db = Zend_Registry::get('db');
        
        $sql = "select * from socio where cpf = '$cpf'";
        //$sql = "select * from socio where cpf = ".$cpf;
        
        return $db->fetchAll($sql);
    }
    
    public function recuperarIdPorCPF($cpf) {       
        $db = Zend_Registry::get('db');
        
        $sql = "select Id from socio where cpf = '$cpf'";
        
        return $db->fetchAll($sql);
    }
    
    public function recuperarPorId($id) {       
        $db = Zend_Registry::get('db');
        
        $sql = "select * from socio where Id = '$id'";
        //$sql = "select * from socio where Id = ".$id;
        
        return $db->fetchAll($sql);
    }

}

