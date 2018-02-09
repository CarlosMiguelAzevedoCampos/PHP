<?php
require_once("class.Database.php");

/**
* 
*/
class Select
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
        //Por exemplo, aqui, o link terá o seguinte aspeto.. http://localhost/class.Select.php?action=procurar-nome
		if ($_GET["action"] == "procurar-nome") {
            $this->Delete($id);
        }
    }

    protected function MostarNome(){	
		$response["resultado_do_select"] = array(); //irá me permitir saber, se ocorreu um erro ou se correu tudo bem no select
		if ($query = $this->db->query('SELECT * FROM db_table order by id')) {	
			if (empty($query->num_rows)) { //se tiver a tabela vazia, coloca empty
				$response['resultado_do_select'] = 'empty';
			} else {//se tiver dados, irá colocar estes num array
				while ($row = $query->fetch_object()) {
					$json[] = array("id" => $row->id, "usertype" => $row->user_type, "nome" => $row->nome, "telefone" => $row->telefone,
					"morada" => $row->morada, "email"=>$row->email);
				}	
				array_push($response["resultado_do_select"], $json); //fazendo depois um array push para o resultado_do_select ficar com dados
			}
		}
	 	 else { // se ocorrer um erro no primeiro if, irá retornar fail.
			$response['resultado_do_select'] = 'fail';
		}
		$response['type'] = "resultado_select"; ///aqui defino o tipo de resposta, se é de editar, ou apagar alguma coisa da bd
		echo json_encode($response);

    }
}
