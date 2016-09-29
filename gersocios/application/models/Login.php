<?php

class Application_Model_Login
{

    public static function login($login, $senha){	
        try {
            $model = new self;
            
            $db = Zend_Db_Table::getDefaultAdapter();
            $adpter = new Zend_Auth_Adapter_DbTable($db, 'usuario', 'Login', 'Senha');
            
            $adpter->setIdentity($login);
            $adpter->setCredential($senha);

            $auth = Zend_Auth::getInstance();
            $result = $auth->authenticate($adpter);
            
            if($result->isValid()){
                $data = $adpter->getResultRowObject(null, 'Senha'); //sessão
                $auth->getStorage()->write($data);
                return true;
            }   
            else {
                return $model->getMessages($result);
            }
        }
        catch(Exception $e){
            return $e->getMessage();
        }
    }

}

