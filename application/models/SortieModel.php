<?php

class SortieModel extends CI_Model{

    private $table = "sortie";

    public function nombreTotalSortie(){
        return $this->db->count_all_results($this->table);
    }

    public function getSortieByIDandMY($id, $keyword, $mois, $year, int $page){
        $offset = ($page-1) * 5;
        if($keyword == ""){
            $sql = "SELECT * FROM $this->table WHERE id_comptes = $id AND MONTH(date) = $mois AND YEAR(date) = $year ORDER BY date DESC";
        }
        else{
            $keyword = dbd($keyword);
            $sql = "SELECT * FROM $this->table WHERE MONTH(date) = $mois AND YEAR(date) = $year AND (description LIKE '%$keyword%' OR prix LIKE '%$keyword%' OR date LIKE '%$keyword%') AND id_comptes = $id ORDER BY date DESC";    
        }
        $total_sortie = $this->db->query($sql)->num_rows();
        $sql .= " LIMIT 5 OFFSET $offset";
        $query = $this->db->query($sql);
        $data = $query->result_array();
        array_push($data, ceil($total_sortie/5));
        return $data;
        
    }

    public function addAllSortietoDB($id, $desc, $prix, $date){
        $entree = [
            "id_comptes" => $id,
            "description" => $desc,
            "prix" => $prix,
            "date" => $date
        ];
        $this->db->insert($this->table, $entree);

        $query = $this->db->query("SELECT solde FROM comptes WHERE id_comptes = $id ");
        foreach($query->result() as $row){
            (int)$solde = $row->solde;
        }
        $solde_now = $solde - $prix;
        if($solde_now < 0){
            $solde_now = 0;
        }
        $this->db->where('id_comptes', $id);
        $this->db->update("comptes", array("solde" => $solde_now));
    }

    public function deletefromdb($id_sortie, $id){

        //Take sortie suppr
        $query = $this->db->query("SELECT prix FROM $this->table WHERE id_sortie = $id_sortie ");
        foreach($query->result() as $row){
            (int)$soldesuppr = $row->prix;
        }
        //Take Solde
        $query = $this->db->query("SELECT solde FROM comptes WHERE id_comptes = $id ");
        foreach($query->result() as $row){
            (int)$solde = $row->solde;
        }

        $solde_now = $solde + $soldesuppr;

        //Delete
        $this->db->where('id_sortie', $id_sortie);
        $this->db->delete($this->table);
        //Maj
        $this->db->where('id_comptes', $id);
        $this->db->update("comptes", array("solde" => $solde_now));
    }
}