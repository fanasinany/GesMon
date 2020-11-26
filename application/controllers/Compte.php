<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Compte extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model("CompteModel");
    }

	public function index()
	{
        $data = array('content'=>'Comptes');
		$this->load->view('layout',$data);	
	}

	public function add()
	{
		if($_POST["nom"] != "" && $_POST["revenu"] != ""){
			$this->CompteModel->addCompteToDB($_POST["nom"], $_POST["revenu"]);
		}
		else{
			show_error("Champs requis", 500);
		}
	}

	public function getAllComptes(){
		$affichage = "";
		$data = $this->CompteModel->getAllComptesFromDB();
		foreach($data as $k){
			$id = $k["id_comptes"];
			$nomprenom = $k["nom_prenom"];
			//$revenu = $k["revenu_mensuelle"];
			$solde = $k["solde"];

			$lien = base_url("index.php/Details?id=$id");

			$affichage .= "<tr>
				<td>$id</td>
				<td>$nomprenom</td>
				<td>$solde</td>
				<td><a href=$lien class=\"btn btn-warning btn-sm\"><i class=\"fas fa-book-open\"></i></a>
				<button class=\"btn btn-danger btn-sm\" data-toggle=\"modal\" data-id=\"$id\" data-target=\"#deleteCModal\"><i class=\"fas fa-trash\"></i></button>
				</td>
			</tr>";
		}

		echo $affichage;
	}

    public function delete(){
        if(isset($_POST["id_compte"]) && $_POST["id_compte"] != ""){
            $this->CompteModel->deletefromdb((int)$_POST["id_compte"]);
        }
    }
}
