<?php 
header('Content-type: application/json; charset:utf-8');
require_once("Model/Utilizador.php");
 // Inicia seção
 //session_start();

   /*************************/
		/******** Inicio Turma *********/
         
    class UtilizadorServico 
    {
       


         // Get data object
        public function get($parameter=null){
         
          
          
        }
        // Insert object
        public function post($parameter=null){
            
            $UtilizadorModel = new Utilizador();
            
            if($parameter[0]=="login"){
                $result = $UtilizadorModel->logIn();
            }elseif($parameter[0]=="logout"){
                $result = $UtilizadorModel->logout();
            }else{
                $result = json_encode(array ('status'=>'400', 'dados'=>'Serviço Inexistente'));
            }

            echo ($result);
        }
        // Updtate data object
        public function put(){
           
        }
        // Delete data object
        public function delete(){
          
        }
        
          /* Fim Turma  */

          
}
?>