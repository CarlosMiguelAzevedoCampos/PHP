<?php
require_once("class.Database.php");

/**
* 
*/
class Edit
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
        //Por exemplo, aqui, o link terá o seguinte aspeto.. http://localhost/class.Edit.php?action=edit&id=1&nome=Carlos&idade=18
	if ($_GET["action"] == "edit") {
		    $id = $this->db->real_escape_string($_GET['id']); 
		    $nome = $this->db->real_escape_string($_GET['nome']); 
		    $idade = $this->db->real_escape_string($_GET['idade']);
		    /* o $this->db->real_escape_string, serve para segurança, pois retira os caracters especiais. Por exemplo #999
		    aceite*/
		    $this->Edit($id,$nome, $idade);
        }
    }

    protected function Edit($id, $nome, $idade){	
		$response["resultado_do_editar"] = array(); //Irá me permitir por exemplo saber se algo ficou editado
		if ($query = $this->db->prepare('UPDATE bd_table set nome=?, idade=? where id=?')) {
			$query->bind_param("sii", $nome, $idade, $id);
			if ($query->execute()) { // se executou irá colocar no resultado_do_editar, done
               			$response["resultado_do_editar"] = "done";
    			}
			else{// se não executou irá colocar no resultado_do_editar, execute-error
		    		$response["resultado_do_editar"] = "execute-error";
			}
        }
        else {// se não entrar no if por alguma razão, o resultado_do_editar, terá false.
		$response["resultado_do_editar"] = "false";
	}
	$response["type"] = "editar_dados"; //aqui defino o tipo de resposta, se é de editar, ou apagar alguma coisa da bd
	echo json_encode($response);
    }
}
