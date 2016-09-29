<?php

class Application_Model_Empresa extends Zend_Db_Table_Abstract
{

    protected $_name = 'empresa';
    protected $_primary = 'Id';
    protected $_dependentTables = array('Application_Model_SocioEmpresa');
    
    public function recuperarPorCNPJ($cnpj) {       
        $db = Zend_Registry::get('db');
        
        $sql = "select * from empresa where cnpj = '$cnpj'";
        //$sql = "select * from empresa where cnpj = ".$cnpj;
        
        return $db->fetchAll($sql);
    }
    
    public function recuperarIdNome() {       
        $db = Zend_Registry::get('db');
        
        $sql = "select Id, NomeEmpresa from empresa";
        
        return $db->fetchAll($sql);
    }

    public function recuperarParaNovaAssociacao($idSocio) {       
        $db = Zend_Registry::get('db');
        
        $sql = "SELECT DISTINCT c.Id, c.NomeEmpresa
                FROM socio a JOIN socioempresa b 
                ON a.Id = b.IdSocio
                JOIN empresa c
                ON c.Id = b.IdEmpresa
                WHERE c.Id NOT IN
                        (SELECT DISTINCT c.Id
                        FROM socio a JOIN socioempresa b 
                        ON a.Id = b.IdSocio
                        JOIN empresa c
                        ON c.Id = b.IdEmpresa
                        WHERE a.Id = '$idSocio');";
        
        return $db->fetchAll($sql);
    }
    
}

