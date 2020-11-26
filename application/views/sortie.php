<?php 
    $mois_fr = ["Janvier","Février","Mars","Avril","Mai","Juin",
    "Juillet","Aout","Septembre","Octobre","Novembre","Decembre"];
    if(isset($_GET["mois"]) && isset($_GET["annee"])){
        $moisnb = $_GET["mois"];
        $anneenb = $_GET["annee"];
    }
    else{
        $moisnb = (int)date("m");
        $anneenb = date("Y");
    }
?>
<div class="row">
    <div class="col-sm-6">
    <h4>Sortie mois de <?= $mois_fr[$moisnb-1]?> <?= $anneenb ?></h4>
    </div>
    <div class="col-sm-6">
        <a href="<?= base_url("index.php/Details?id=$id&mois=$moisnb&annee=$anneenb") ?>" class="btn btn-warning btn-sm mt-4" style="margin-left: 300px;">Tableau de bord</a>
        <a href="<?= base_url("index.php/Entree?id=$id&mois=$moisnb&annee=$anneenb") ?>" class="btn btn-rose btn-sm mt-4">Entrée</a>
        <a href="<?= base_url("index.php/Sortie?id=$id&mois=$moisnb&annee=$anneenb") ?>" class="btn btn-info btn-sm mt-4">Sortie</a>
    </div>
</div>

<div class="row">
    <div class="col-sm-7">
    <h6>Solde restant : <solde></solde> Ar</h6>
        <div class="card">
        <div class="card-body">
        <div class="form-inline">
            <input id="keyword" style="width: 200px; margin-left: 480px;" class="form-control" type="text" placeholder="Recherche">
            <i class="fas fa-search"></i>
        </div>
        <table class="table" id="myTable">
            <thead class="text-primary">
                <th>Date</th>
                <th>Description</th>
                <th>Prix</th>
                <th style="width: 50px;"></th>
            </thead>
            <tbody>
    
            </tbody>
        </table>
        <button id="btnPrev" class="btn btn-round btn-outline-primary btn-sm" style="width: 100px;">Précedent</button>
        <button id="btnNext" class="btn btn-round btn-sm btn-outline-primary" style="width: 100px; margin-left: 490px;"><page hidden>1</page>Suivant</button>
        </div>
        </div>
    </div>
    <div class="col-sm-5">
        <div class="card">
            <div class="card-header-info">
                <div class="card-icon"><i class="fas fa-file-export"></i></div>
                <div class="card-title">AJOUT DES SORTIES</div>
            </div>
            <div class="card-body">
                <div class="form-inline">
                    <input id="idc" type="number" value="<?= $id ?>" hidden disabled>
                    <input id="description" class="form-control" type="text" placeholder="Description">
                    <input id="prix" style="width: 110px;" class="form-control ml-4" type="number" placeholder="Prix">
                    <input id="date" class="form-control ml-4" type="date" value="<?= date("Y-m-d") ?>">
                    <!-- <button class="btn btn-link btn-sm"><i class="fas fa-plus"></i></button> -->
                </div>
                <button id="btnValid" class="btn btn-dark btn-sm">Ajouter</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal pour Suppr -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header justify-content-center">
        <h6 class="modal-title">Supprimer un sortie</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body justify-content-center">
          Voulez-vous vraiment supprimer cette sortie?
      </div>
      <div class="modal-footer justify-content-center">
        <button id="btnCfr" class="btn btn-danger btn-sm">Confirmer</button>
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Annuler</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
    var $url_get_sortie = "index.php/Sortie/getAllSortie";
    var $id_sortie;
    $page_actif = parseInt($("page").html());

    $(document).ready(function(){
        getSolde()
        getAllSortie()
    })
    
    $("#btnValid").on("click", function () {
        $.ajax({
            type: "POST",
            url: site_url + "index.php/Sortie/addAllSortie",
            data: {
                id: $("#idc").val(),
                description: $("#description").val(),
                prix: $("#prix").val(),
                date: $("#date").val()
            },
            success: function(){
                swal("Ajout Reusi","","success")
                getSolde()
                getAllSortie()
                $("#description").val("")
                $("#prix").val("")
            },
            error: function(){
                swal("Champs requis","Veuillez remplir tous les champs","error")
            }
        })
      })

    $( "#deleteModal" ).on('shown.bs.modal', function(e){
        $id_sortie = $(e.relatedTarget).data("id");
    });

      $("#btnCfr").on("click", function () {
        $.ajax({
            type: "POST",
            url: site_url + "index.php/Sortie/delete",
            data: {
                id_sortie: $id_sortie,
                id: <?= $id ?>
            },
            success: function(){
                $("#deleteModal").modal('toggle');
                swal("Suppression réussi","","success")
                getSolde()
                getAllSortie()
            }
        })
      })

      $("#btnNext").on("click", function () {
        $.ajax({
            type: "GET",
            url: site_url + $url_get_sortie,
            data: {
                id: <?= $id ?>,
                mois: <?= $_GET["mois"] ?>,
                annee: <?= $_GET["annee"] ?>,
                page: $page_actif + 1,
                keyword: $("#keyword").val()

            },
            success: function(data){
                $("tbody").html(data)
                $page_actif++
                $("page").html($page_actif)
                $totalpage = $("#inputnbpage").val();
                testBtnPrevDisabled($page_actif)
                testBtnNextDisabled($page_actif)
            }
        })
      })

      $("#btnPrev").on("click", function () {
        $.ajax({
            type: "GET",
            url: site_url + $url_get_sortie,
            data: {
                id: <?= $id ?>,
                mois: <?= $_GET["mois"] ?>,
                annee: <?= $_GET["annee"] ?>,
                page: $page_actif - 1,
                keyword: $("#keyword").val()
            },
            success: function(data){
                $("tbody").html(data)
                $page_actif--
                $("page").html($page_actif)
                $totalpage = $("#inputnbpage").val();
                testBtnPrevDisabled($page_actif)
                testBtnNextDisabled($page_actif)
            }
        })
      })

    $("#keyword").on("keyup", function(){
        $.ajax({
            type: "GET",
            url: site_url + $url_get_sortie,
            data: {
                id: <?= $id ?>,
                mois: <?= $_GET["mois"] ?>,
                annee: <?= $_GET["annee"] ?>,
                keyword: $("#keyword").val()
            },
            success: function(data){
                $("tbody").html(data)
                $totalpage = $("#inputnbpage").val();
                testBtnPrevDisabled($page_actif)
                testBtnNextDisabled($page_actif)
            }
        })
    })

    function getAllSortie(){
        $.ajax({
            type: "GET",
            url: site_url + $url_get_sortie,
            data: {
                id: <?= $id ?>,
                mois: <?= $_GET["mois"] ?>,
                annee: <?= $_GET["annee"] ?>
            },
            success: function(data){
                $("tbody").html(data)
                $totalpage = $("#inputnbpage").val();
                testBtnPrevDisabled($page_actif)
                testBtnNextDisabled($page_actif)
            }
        })
    }

</script>