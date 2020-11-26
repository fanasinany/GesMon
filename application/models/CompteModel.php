<?php

class CompteModel extends CI_Model{

    private $table = "comptes";

    public function addCompteToDB($nom_prenom, $solde){
        $data = [
            "nom_prenom" => $nom_prenom,
            "solde" => $solde
        ];
        $this->db->insert($this->table, $data);
        //Inserer revenu dans la table Entree
        $last_row = $this->db->select("id_comptes")->order_by("id_comptes","DESC")->limit(1)->get($this->table)->row();
        $entree = [
            "id_comptes" => $last_row->id_comptes,
            "description" => "Solde de depart",
            "prix" => $solde,
            "date" => date("Y-m-d")
        ];
        $this->db->insert("entree", $entree);
    }

    public function getAllComptesFromDB(){
        $sql = "SELECT * FROM $this->table";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function deletefromdb($id_compte){

        //Delete entrée $id_compte
        $this->db->where('id_comptes', $id_compte);
        $this->db->delete("entree");
        //Delete sortie $id_compte
        $this->db->where('id_comptes', $id_compte);
        $this->db->delete("sortie");
        //Delete
        $this->db->where('id_comptes', $id_compte);
        $this->db->delete($this->table);
    }
}