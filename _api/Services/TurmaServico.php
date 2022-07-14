<?php 
header('Content-type: application/json; charset:utf-8');
require_once("Model/Turma.php");
require_once("Model/Aluno.php");
 
   /*************************/
		/******** Inicio Turma *********/
         
    class TurmaServico 
    {
     
         // Get data object
        public function get($parameter=null){
            // Default return data
            $data= json_encode(array ('status'=>'400', 'dados'=>'Serviço Inexistente'));
            // Count url parameter if exit
            $numberservico= isset($parameter) ? count($parameter): 0;
            $TurmaModel = new Turma();
            // Define 0 or no parameters 
            if($numberservico==0){
            // If no parameter select all 
               $data = $TurmaModel->fetchAllTurma();
                
            }
            elseif($numberservico==1){
            // Onle one parameter then it is by ID default
                $data = $TurmaModel->fetchAllTurmaById($parameter[0]);
            }
            elseif($numberservico==2){
                // if tow parameter then get atribute 
                if($parameter[0]=="nome"){
                    // attribute name then get name
                    $data = $TurmaModel->fetchAllTurmaByAttribute('nome',$parameter[1]);
                    
                }elseif($parameter[0]=="serie"){
                    // attribute name then get name
                    $data = $TurmaModel->fetchAllTurmaByAttribute('serie',$parameter[1]);
                }elseif($parameter[1]=="aluno"){
                    
                    $AlunoModel = new Aluno();
                    // attribute name then get name
                    $data = $AlunoModel->fetchAllAlunoByTurma($parameter[0]);
                }
            }elseif($numberservico==3){
                // 0 -> id | 1 ->  aluno | 2 -> attribute | 3 -> value 
                // Create object Aluno
                $AlunoModel = new Aluno();
                
                // for this exemplo, 2 -> will be default value to select by name
                $data = $AlunoModel->fetchAllAlunoByAttribute('nome',$parameter[2],$parameter[0]);
            }else{
               $data= json_encode(array ('status'=>'400', 'dados'=>'Serviço Inexistente')); 
            }
            echo ($data);
        }
        // Insert object
        public function post(){
            
            $TurmaModel = new Turma();
            $data=json_decode(file_get_contents('php://input'),true);

            $result = $TurmaModel->insertTurma($data);
                
            echo ($result);
        }
        // Updtate data object
        public function patch(){
            $TurmaModel = new Turma();
            $data=json_decode(file_get_contents('php://input'),true);

            $result = $TurmaModel->updateTurma($data);
                
            echo ($result);
        }
        // Delete data object
        public function delete(){
            $TurmaModel = new Turma();
            $data=json_decode(file_get_contents('php://input'),true);
            $result = $TurmaModel->removeTurma($data);
                
            echo ($result);
        }
        
          /* Fim Turma  */

          
}
?>