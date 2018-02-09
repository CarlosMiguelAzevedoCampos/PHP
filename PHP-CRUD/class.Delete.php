<?php
require_once("class.Database.php");

/**
* 
*/
class Delete
{
	private $db;
	use Database;
    
    //Construtor da classe.
	function __construct()
	{
        //Se não conseguir conectar ele mata a ligação
		if (!$this->db_connect()) {
			die("Falha na ligação");
		}
        
		$this->Actions(); //Se tudo correr bem, vem para aqui
	}
    //Este método irá fazer o que na "action" esta a pedir.
	protected function Actions()
	{
        //Por exemplo, aqui, o link terá o seguinte aspeto.. http://localhost/class.Delete.php?action=delete&id=1
		if ($_GET["action"] == "delete") {
            $id = $this->db->real_escape_string($_GET['id']); 
            /* o $this->db->real_escape_string, serve para segurança, pois retira os caracters especiais. Por exemplo #999
            aceite*/
            $this->Delete($id);
        }
    }

    protected function Delete($id){	
		$response["resultado_do_apagar"] = array(); //Irá me permitir por exemplo saber se algo ficou apagado
		if ($query = $this->db->prepare('DELETE FROM bd_table where id=?')) {
			$query->bind_param("i",$id);
			if ($query->execute()) { // se executou irá colocar no resultado_do_apagar, done
               $response["resultado_do_apagar"] = "done";
    		}
			else{// se não executou irá colocar no resultado_do_apagar, execute-error
		    	$response["resultado_do_apagar"] = "execute-error";
			}
        }
        else {// se não entrar no if por alguma razão, o resultado_do_apagar, terá false.
			$response["resultado_do_apagar"] = "false";
		}
		$response["type"] = "apagar_dados"; //aqui defino o tipo de resposta, se é de editar, ou apagar alguma coisa da bd
		echo json_encode($response);
    }
}
