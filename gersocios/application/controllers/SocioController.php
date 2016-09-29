<?php

class SocioController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {   
        try {
            $modelSocio = new Application_Model_Socio();
            $socios = $modelSocio->listar();
            $this->view->socios = $socios;
        }
        catch (Exception $e) {
            echo $e->getMessage();
            exit();
        }
    }

    public function pesquisarAction()
    {
        // action body
    }

    public function adicionarAction()
    {
        try {
            $modelEmpresa = new Application_Model_Empresa();
            
            //Listagem das empresas cadastradas no sistema.
            $empresas = $modelEmpresa->recuperarIdNome();
            $this->view->empresas = $empresas;
            
            //Submissão do formulário de cadastro.
            if (!empty($_POST)) {
                $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT); //filtro usado para evitar sql/php injection
                
                if (!empty($dados)) {
                    $nome = $dados['nome'];
                    $cpf = $dados['cpf'];
                    $email = $dados['email'];
                    $idEmpresa = $dados['empresa'];
                    
                    $modelSocio = new Application_Model_Socio();
                    $modelSocioEmpresa = new Application_Model_SocioEmpresa();

                    //Cadastrando sócio.
                    $modelSocio->inserir(array('CPF'=>$cpf, 
                                           'NomeSocio'=>$nome, 
                                           'Email'=>$email));
                    
                    //Recuperar Id do sócio que acabou de ser cadastrado.
                    $result = $modelSocio->recuperarIdPorCPF($cpf);
                    foreach ($result as $obj){
                        $idSocio = $obj->Id;
                    }
                    
                    //Registro na tabela "socioempresa".
                    $modelSocioEmpresa->inserir(array('IdSocio'=>$idSocio, 
                                                    'IdEmpresa'=>$idEmpresa));

                    $this->_redirect('socio/index');
                }
            }
        }
        catch (Exception $e) {
            echo $e->getMessage();
            exit();
        }
    
    }

    public function atualizarAction()
    {
        try {
            $modelSocio = new Application_Model_Socio();
            $modelEmpresa = new Application_Model_Empresa();
            $modelSocioEmpresa = new Application_Model_SocioEmpresa();
            
            $session = Zend_Registry::get('session');
            
            //Guardar o Id do sócio escolhido na sessão para o submit de atualização.
            //Recuperar os dados atuais do sócio escolhido para mostrar no formulário.
            if (!empty($_GET)) {
                $dados = filter_input_array(INPUT_GET, FILTER_DEFAULT); //filtro usado para evitar sql/php injection
                if (isset($dados['id'])) {
                    $idSocio = $dados['id'];
                    $session->idSocioAtualizar = $idSocio;
                    $dados = $modelSocio->recuperarPorId($idSocio);
                    
                    foreach ($dados as $obj) {
                        $this->view->nome = $obj->NomeSocio;
                        $this->view->cpf = $obj->CPF;
                        $this->view->email = $obj->Email;                    
                    }
                    
                    //Recuperando empresas daquele sócio (relacionamento N - N).
                    $socio = $modelSocio->fetchRow('Id = '.$idSocio);
                    $this->view->empresasAtuais = $socio->findManyToManyRowset('Application_Model_Empresa', 'Application_Model_SocioEmpresa');
                    
                    //Recuperando todas as empresas disponíveis para nova associação e que o sócio
                    //já não tenha participação.
                    $this->view->empresasCadastradas = $modelEmpresa->recuperarParaNovaAssociacao($idSocio);
                }
            }
            
            //Submit de atualização.
            if (!empty($_POST)) {
                $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT); //filtro usado para evitar sql/php injection
                $idSocioAtualizar = $session->idSocioAtualizar;
                
                $operacaoEscolhida = $dados["oper"];           
                
                //Operação adicionar uma nova associação.
                if ($operacaoEscolhida == "B") {
                    
                    $idEmpresaNova = $dados["empresa-nova"];
                    
                    $modelSocioEmpresa->inserir(array('IdSocio'=>$idSocioAtualizar, 
                                                    'IdEmpresa'=>$idEmpresaNova));
                    
                }
                
                //Operação apagar uma associação.
                else if($operacaoEscolhida == "C") {
                    
                    $idEmpresaParaApagar = $dados["empresa-atual"];
                    
                    $empresa = $modelSocioEmpresa->recuperarRegistro($idSocioAtualizar, 
                                                                     $idEmpresaParaApagar);
                    foreach ($empresa as $obj) {
                        $modelSocioEmpresa->delete($obj->Id);
                    }
                    
                }
                
                //Atualizando dados do sócio.
                $modelSocio->atualizar(array('NomeSocio'=>$dados["nome"], 
                                            'CPF'=>$dados["cpf"],
                                            'Email'=>$dados["email"]), $idSocioAtualizar);
                
                //Liberando o registro na sessão.
                unset($session->idSocioAtualizar);
                
                $this->_redirect('socio/index');
            }
        }
        catch (Exception $e) {
            echo $e->getMessage();
            exit();
        }
    }

    public function deletarAction()
    {
        try {
            if (!empty($_GET)) {
                $dados = filter_input_array(INPUT_GET, FILTER_DEFAULT); //filtro usado para evitar sql/php injection
                if (isset($dados['id'])) {
                    $modelSocio = new Application_Model_Socio();
                    $modelSocioEmpresa = new Application_Model_SocioEmpresa();
                    
                    $idSocio = $dados['id'];
                    
                    //Primeiro recuperando e apagando as relações/restrições do sócio com a
                    //tabela "empresa", para depois excluir o sócio.
                    $participacoes = $modelSocioEmpresa->recuperarIdPorIdSocio($idSocio);
                    foreach ($participacoes as $obj){
                        $modelSocioEmpresa->delete($obj->Id);
                    }
                    
                    $modelSocio->delete($idSocio);
                    
                    $this->_redirect('socio/index');
                }
            }
        }
        catch (Exception $e) {
            echo $e->getMessage();
            exit();
        }
    }

    public function visualizarAction()
    {
        try {
            if (!empty($_POST)) {
                $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT); //filtro usado para evitar sql/php injection
                if (isset($dados['cpf'])) {
                    $cpf = ($dados['cpf']);

                    $modelSocio = new Application_Model_Socio();

                    $dados = $modelSocio->recuperarPorCPF($cpf);

                    foreach ($dados as $obj) {
                        $this->view->nome = $obj->NomeSocio;
                        $this->view->cpf = $obj->CPF;
                        $this->view->email = $obj->Email;
                        $id = $obj->Id;                    
                    }

                    //Recuperando empresas daquele sócio (relacionamento N - N).
                    $socio = $modelSocio->fetchRow('Id = '.$id);
                    $empresas = $socio->findManyToManyRowset('Application_Model_Empresa', 'Application_Model_SocioEmpresa');
                    //var_dump($empresas);
                    //exit();
                    
                    $this->view->empresas = $empresas;
                }
            }
        }
        catch (Exception $e) {
            echo $e->getMessage();
            exit();
        }
    }


}











