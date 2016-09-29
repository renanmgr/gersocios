<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $this->_helper->layout->setLayout('layout_index');
        
        if (!empty($_POST)) {
            $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT); //filtro usado para evitar sql/php injection
            if ((isset($dados['email'])) && (isset($dados['senha']))) {
                $login = $dados['email'];
                $senha = md5($dados['senha']);
                Application_Model_Login::login($login, $senha);
                $this->_redirect('/socio/index');
            }
        }
    }

    public function sairAction()
    {
        $auth = Zend_Auth::getInstance();
        $auth->clearIdentity();
        $this->_redirect('/index');
    }

}



