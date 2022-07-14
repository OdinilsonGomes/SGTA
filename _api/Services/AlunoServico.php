<?php 
header('Content-type: application/json; charset:utf-8');
require_once("Model/Aluno.php");
   
   /*************************/
		/******** Inicio Aluno *********/
    
    class AlunoServico 
    {
  
         // Get data object
        public function get($parameter=null){
            // Default return data
            $data= json_encode(array ('status'=>'400', 'dados'=>'Serviço Inexistente'));  
            // Count url parameter if exit
            $numberservico= isset($parameter) ? count($parameter): 0;
            $AlunoModel = new Aluno();
            // define 0 or no parameters 
            if($numberservico==0){
               // if no parameter select all 
               $data = $AlunoModel->fetchAllAluno();
                
            }
            elseif($numberservico==1){
                // onle one parameter then it is by ID default
                $data = $AlunoModel->fetchAllAlunoById($parameter[0]);
            }
            elseif($numberservico==2){
                // if tow parameter then get atribute 
                if($parameter[0]=="nome"){
                    // attribute name then get name
                    $data = $AlunoModel->fetchAllAlunoByAttribute('nome',$parameter[1]);
                }elseif($parameter[0]=="email"){
                    // attribute name then get name
                    $data = $AlunoModel->fetchAllAlunoByAttribute('email',$parameter[1]);
                }
                /** it is posible to send parameter dirctly on the function but it is not recomendede **/
            }elseif($numberservico==3){
                // 
            }
            echo ($data);
        }
        // Insert object
        public function post(){
            
            $AlunoModel = new Aluno();
            $data=json_decode(file_get_contents('php://input'),true);

            $result = $AlunoModel->insertAluno($data);
                
            echo ($result);
        }
        // Updtate data object
        public function patch(){
            $AlunoModel = new Aluno();
            $data=json_decode(file_get_contents('php://input'),true);

            $result = $AlunoModel->updateAluno($data);
                
            echo ($result);
        }
        // Delete data object
        public function delete(){
            $AlunoModel = new Aluno();
            $data=json_decode(file_get_contents('php://input'),true);

            $result = $AlunoModel->removeAluno($data);
                
            echo ($result);
        }
        
          /* Fim Aluno  */

          
}
?>