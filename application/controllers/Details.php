<?php
class Details extends CI_Controller{

    function __construct()
    {
        parent::__construct();
        $this->load->model("DetailsModel");
    }

    public function index(){
        $data = array('content'=>'Details');
        //ID Compte
        $data["id"] = $_GET["id"];
        $data["name"] = $this->DetailsModel->getName($_GET["id"]);
        if(isset($_GET["mois"]) && isset($_GET["annee"])){
            $mois_s = (int)$_GET["mois"];
            $annee_s = $_GET["annee"];
            $data["mois_selected"] = $mois_s;
            $data["annee_selected"] = $annee_s;
        }
        //Données pour le diagramme sortie
        $moneyperdaysortie = [];
        for ($i=1; $i < 32; $i++) {
            if(isset($mois_s) && isset($annee_s)){
                $datejour = date("$annee_s-$mois_s-$i");
            }
            else{
                $datejour = date("Y-m-$i");
            }
            
            //var_dump($datejour);
            $moneyperdaysortie[$i-1] = $this->DetailsModel->getSommeSortie($_GET["id"],$datejour);
        }
        //Donnees pour le diagramme entree
        $moneyperdayentries = [];
        for ($i=1; $i < 32; $i++) {
            if(isset($mois_s) && isset($annee_s)){
                $datejour = date("$annee_s-$mois_s-$i");
            }
            else{
                $datejour = date("Y-m-$i");
            }
            
            //var_dump($datejour);
            $moneyperdayentries[$i-1] = $this->DetailsModel->getSommeEntries($_GET["id"],$datejour);
        }
        //var_dump($moneyperday);

        $data["moneydaysortie"] = $moneyperdaysortie;
        $data["moneydayentries"] = $moneyperdayentries;
        //View

        $this->load->view('layout',$data);
    }

    public function getSolde(){   
        $solde = $this->DetailsModel->getSolde($_GET["id"]);
        
        if($solde > 0){
            //$affichage_solde = "<button class=\"btn btn-success btn-sm\">$solde</button>";
            echo $solde;
        }else{
            //$affichage_solde = "<button class=\"btn btn-danger btn-sm\">$solde</button>";
            echo $solde;
        }
        
    }

}