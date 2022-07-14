<?php 
header('Content-type: application/json; charset:utf-8');
require_once("Model/Transferencia.php");

   /*************************/
		/******** Inicio Transferencia *********/
         
    class TransferenciaServico 
    {
     
         // Get data object
        public function get($parameter=null){
            // Default return data
            $data= json_encode(array ('status'=>'400', 'dados'=>'Serviço Inexistente'));
            // Count url parameter if exit
            $numberservico= isset($parameter) ? count($parameter): 0;
            $TransferenciaModel = new Transferencia();
            // Define 0 or no parameters 
            if($numberservico==0){
            // If no parameter select all 
               $data = $TransferenciaModel->fetchAllTransferencia();
                
            }
            elseif($numberservico==1){
            // Onle one parameter then it is by ID default
                $data = $TransferenciaModel->fetchAllTransferenciaById($parameter[0]);
            }
            elseif($numberservico==2){
                // if tow parameter then get atribute 
                if($parameter[0]=="nome"){
                    // attribute name then get name
                    $data = $TransferenciaModel->fetchAllTransferenciaByAttribute('nome',$parameter[1]);
                }elseif($parameter[0]=="serie"){
                    // attribute name then get name
                    $data = $TransferenciaModel->fetchAllTransferenciaByAttribute('serie',$parameter[1]);
                }
                /** it is posible to send parameter dirctly on the function but it is not recomendede **/
            }elseif($numberservico==3){
                // 
            }else{
               $data= json_encode(array ('status'=>'400', 'dados'=>'Serviço Inexistente')); 
            }
            echo ($data);
        }
        // Insert object
        public function post() {
            
            $TransferenciaModel = new Transferencia();
            $data=json_decode(file_get_contents('php://input'),true);
            $result = $TransferenciaModel->insertTransferencia($data);
                
            echo ($result);
        }
        /*************** INICIO DO CODIGO COM POUCA PRIOLIDADE DADOS AOS REQUISITOS (AINDA POR ACABAR)  *************************/
        // Updtate data object
        public function patch(){
            $TransferenciaModel = new Transferencia();
            $data=json_decode(file_get_contents('php://input'),true);
            $result = $TransferenciaModel->updateTransferencia($data);
                
            echo ($result);
        }
        // Delete data object
        public function delete(){
            $TransferenciaModel = new Transferencia();
            $data=json_decode(file_get_contents('php://input'),true);

            $result = $TransferenciaModel->removeTransferencia($data);
                
            echo ($result);
        }
        
          /* Fim Transferencia  */

          
}
?>