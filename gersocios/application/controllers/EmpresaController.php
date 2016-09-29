<?php

class EmpresaController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

    public function visualizarAction()
    {
        try {
            if (!empty($_POST)) {
                $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT); //filtro usado para evitar sql/php injection
                if (isset($dados['cnpj'])) {
                    $cnpj = ($dados['cnpj']);

                    $modelEmpresa = new Application_Model_Empresa();

                    $dados = $modelEmpresa->recuperarPorCNPJ($cnpj);

                    foreach ($dados as $obj) {
                        $this->view->nome = $obj->NomeEmpresa;
                        $this->view->cnpj = $obj->CNPJ;
                        $id = $obj->Id;                    
                    }

                    $empresa = $modelEmpresa->fetchRow('Id = '.$id);
                    $socios = $empresa->findManyToManyRowset('Application_Model_Socio', 'Application_Model_SocioEmpresa');
                    //var_dump($empresas);
                    //exit();
                    
                    $this->view->socios = $socios;
                }
            }
        }
        catch (Exception $e) {
            echo $e->getMessage();
            exit();
        }
    }


}



