<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

    public function _initSession()
    {
        $session = new Zend_Session_Namespace('academico');
        Zend_Registry::set('session', $session);
    }
    
    public function _initDb()
    {
        $db = $this->getPluginResource('db')->getDbAdapter();
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        Zend_Db_Table::setDefaultAdapter($db);
        Zend_Registry::set('db', $db);
    }

}

