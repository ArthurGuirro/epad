<?php
require '../../vendor/autoload.php';
use \App\Entity\Vinculo;

use \App\Session\Login;

Login::requireLogin();
$user = Login::getUsuarioLogado();

if ($_SERVER["REQUEST_METHOD"] === "PUT") {

    $json_data = file_get_contents("php://input");

    $data = json_decode($json_data, true); 

    $to_do = $data['to_do'];
    $id_vinc = $data['id_vin'];
    $user_id = $data['id_user'];

 
    $vinc = new Vinculo();
    $vinc = Vinculo::get($id_vinc);
    

    if(!$vinc instanceof Vinculo){
        header("HTTP/1.1 500 Internal Server Error");
        echo json_encode(array("message" => "Objeto de uma instancia não esperada."));
        exit;
      }

      /*
    // Verify se usuário é coordenador 
    if($user['config'] != '1'){
        $response = array("status" => "error", "message" => "Não adm.");
        echo json_encode($response);
        exit;
    }
    
   

    // Verify se Coordenador é do curso do Vinculado
    if($user['co_id'] <> $vinc['co_id']){
        $response = array("status" => "error", "message" => "Curso diferente.");
        echo json_encode($response);
        exit;
    }
     */

    $vinc->aprov_ce_id = null;  

    if($to_do == 'a'){
        $vinc->aprov_ce_id = $user_id;
        if(!$vinc->assing_ce()){
            $response = array("status" => "error", "message" => "Erro ao assinar.");
            echo json_encode($response);
            exit;
        }
    } else {
        $response = array("status" => "error", "message" => "Tipo não reconhecido");
        echo json_encode($response);
    }
    
    

    $responseData = array( 
        "status" => "success",
        "message" => "Dados recebidos com sucesso.",
        "data" => array (
            "preenchido"       => 'assinado',
            "status"    => 'Super sucesso!'
            )
        );

    header('Content-Type: application/json');
    echo json_encode($responseData);

} else {
    
    $response = array("status" => "error", "message" => "Método de requisição inválido.");
    echo json_encode($response);
}



?>
