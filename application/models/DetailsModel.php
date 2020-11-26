<?php

class DetailsModel extends CI_Model{

    public function getName($id){
        $query = $this->db->query("SELECT nom_prenom FROM comptes WHERE id_comptes = $id ");
        foreach($query->result() as $row){
            $name = $row->nom_prenom;
        }
        return $name;
    }

    public function getSolde($id){
        $query = $this->db->query("SELECT solde FROM comptes WHERE id_comptes = $id ");
        foreach($query->result() as $row){
            (int)$solde = $row->solde;
        }
        return $solde;
    }

    public function getSommeSortie($id,$datejour){
        $sql = "SELECT SUM(prix) as sommeprix FROM sortie WHERE id_comptes = $id AND date = '$datejour' ";
        $query = $this->db->query($sql);
        foreach($query->result() as $row){
            (int)$somme = $row->sommeprix;
        }
        if($somme != null){
            return $somme;
        }else{
            return 0;
        }
    }

    public function getSommeEntries($id,$datejour){
        $sql = "SELECT SUM(prix) as sommeprix FROM entree WHERE id_comptes = $id AND date = '$datejour' ";
        $query = $this->db->query($sql);
        foreach($query->result() as $row){
            (int)$somme = $row->sommeprix;
        }
        if($somme != null){
            return $somme;
        }else{
            return 0;
        }
    }
}