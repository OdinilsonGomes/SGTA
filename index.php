<?php
header('Access-Control-Allow-Origin: *');
//Iniciar Seção
session_start();
// Verify session 
//require_once("cmp/session.php");

//require_once("./vendor/autoload.php");
// Geting url value 
$url= isset($_REQUEST['url'])? $_REQUEST['url'] : 'main';
// Converting url to array
$url_array=explode('/',$url);
// Getting last array position
$url_end=end($url_array);
//discorver extencion
$extensao = substr($url_end, -4);	
if($extensao==='.php'){
    //Include main file
   include 'main.php';
}else {
    // If exist url get url
    $url = (isset($_GET['url'])) ? $_GET['url']:'main';
	$url = (explode('/',$url));
    if($url[0]=="api" && isset($url[1])){
        array_shift($url);
        // Geting Service form url
        $service=$url[0].'Servico';
       // Delete API value from array
        array_shift($url);
        $parameter=isset($url[0])? $url:null;
        $method = strtolower($_SERVER['REQUEST_METHOD']);
        // Verify if service is valible
        if(is_file("_api/Services/$service.php")){
            require_once "_api/Services/$service.php";
            $service=new $service();
            if(method_exists($service, $method) && have_access($parameter,$method)){
                $operation= $service->$method($parameter);
                //echo call_user_func_array(array(new $service, $method), $url);
               
                return $operation;
            }elseif(!method_exists($service, $method)){
                echo json_encode(array ('status'=>'405', 'dados'=>'Operação não disponivel para esse serviço'));
            }else{
                echo json_encode(array ('status'=>'405', 'dados'=>'Requer sessão aberta! '));
            }
            
        }else{
            echo json_encode(array ('status'=>'404', 'dados'=>'Serviço não encontrado'));
        }
        
         
    }else{
         // Convertting url to file default	
         $file = $url[0].'.php';
         // Existe file?
         if(is_file($file)){
             // Include file
             include $file;
         }else{
            
             // Else go to default page
             include 'main.php';
         }	
    }
	
}

function have_access($parameter,$method){
   /* if(!isset($_SESSION['views']) && $parameter!="login" && $method!="post")
    {
        return false;
    }else{

        return true;
    }*/
	return true;
}

?>
