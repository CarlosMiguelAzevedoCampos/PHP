<?php
require_once("class.Database.php");

/**
* 
*/
class Insert
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
		//Por exemplo, aqui, o link terá o seguinte aspeto.. http://localhost/class.Insert.php?action=insert&nome=Carlos&idade=18
		if ($_GET["action"] == "insert") {
		    $nome = $this->db->real_escape_string($_GET['nome']); 
		    $idade = $this->db->real_escape_string($_GET['idade']);
		    /* o $this->db->real_escape_string, serve para segurança, pois retira os caracters especiais. Por exemplo #999
		    aceite*/
		    $this->insert($nome, $idade);
		}
    }

    protected function Insert($nome, $idade){	
		$response["resultado_do_inserir"] = array(); //Irá me permitir por exemplo saber se algo ficou inserido
		if ($query = $this->db->prepare('INSERT INTO bd_table (nome, idade) VALUES (?,?)')) {
			$query->bind_param("si", $nome, $idade);
			if ($query->execute()) { // se executou irá colocar no resultado_do_inserir, done
               			$response["resultado_do_inserir"] = "done";
    		}
			else{
				// se não executou irá colocar no resultado_do_inserir, execute-error
				$response["resultado_do_inserir"] = "execute-error";
			}
        }
        else {// se não entrar no if por alguma razão, o resultado_do_inserir, terá false.
		$response["resultado_do_inserir"] = "false";
	}
	$response["type"] = "inserir_dados"; //aqui defino o tipo de resposta, se é de editar, ou apagar alguma coisa da bd
	echo json_encode($response);
    }
}
