<?php

class Application_Model_SocioEmpresa extends Zend_Db_Table_Abstract
{

    protected $_name = 'socioempresa';
    protected $_primary = 'Id';
	protected $_referenceMap = array(
 		"Usuario" => array(
			"columns" => array("IdSocio"),
			"refTableClass" => "Application_Model_Socio",
			"refColumns" => array("Id"),
		),
		"Artigo" => array(
			"columns" => array("IdEmpresa"),
			"refTableClass" => "Application_Model_Empresa",
			"refColumns" => array("Id"),
 		),

	);
        
    public function inserir(Array $dados) {
        try {
            parent::insert($dados);
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
    
    public function recuperarIdPorIdSocio($id) {       
        $db = Zend_Registry::get('db');
        
        $sql = "select Id from socioempresa where IdSocio = '$id'";
        
        return $db->fetchAll($sql);
    }
    
    public function recuperarRegistro($idSocio, $idEmpresa) {       
        $db = Zend_Registry::get('db');
        
        $sql = "select Id from socioempresa
                where IdSocio = '$idSocio' and IdEmpresa = '$idEmpresa'";
        
        return $db->fetchAll($sql);
    }

}

