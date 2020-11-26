<div class="card">
    <div class="card-header card-header-success">
        <h4 class="card-title">Les comptes</h4>
        <div class="card-description">Liste des comptes disponibles</div>
    </div>
    <div class="card-body">
        <div style="margin-left: 1150px;">
            <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#ModalAjout"><span><i class="fas fa-user"></i> Ajouter</span></button>
        </div>
        <div class="table-responsive">
        <table class="table">
            <thead class="text-primary">
                <th>#ID</th>
                <th>Nom et Prenoms</th>
                <th>Solde Restant</th>
                <th style="width: 150px;">Actions</th>
            </thead>
            <tbody id="bodycontent">

            </tbody>
        </table>
        </div>
    </div>
</div>

<!-- Modal Ajout -->
<div class="modal fade" id="ModalAjout" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h6 class="modal-title">Ajout d'un compte</h6></strong>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
            <label>Nom et Prenoms</label>
            <input id="nom" type="text" class="form-control">
        </div>
        <div class="form-group">
            <label>Solde de depart(en Ariary)</label>
            <input id="revenu" type="number" class="form-control">
        </div>
      </div>
      <div class="modal-footer">
        <button id="btnAdd" class="btn btn-primary">Valider</button>
        <button class="btn btn-secondary" data-dismiss="modal">Annuler</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal pour Suppr -->
<div class="modal fade" id="deleteCModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header justify-content-center">
        <h6 class="modal-title">Supprimer un compte</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body justify-content-center">
          Voulez-vous vraiment supprimer ce compte?
      </div>
      <div class="modal-footer justify-content-center">
        <button id="btnDel" class="btn btn-danger btn-sm">Effacer</button>
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Annuler</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">

    $(document).ready(function(){
        getAllComptes();
    })

    $("#btnAdd").on("click", function(){
        $.ajax({
            type: "post",
            url: site_url + "index.php/Compte/Add",
            data: {
                nom: $("#nom").val(),
                revenu: $("#revenu").val()
            },
            success: function(){
                $("#ModalAjout").modal("toggle");
                swal("Ajout Reussi", "", "success");
                getAllComptes();
            },
            error: function(){
                swal("Champs requis","Veuiller remplir tous les champs","error")
            }
        })
    })

    $( "#deleteCModal" ).on('shown.bs.modal', function(e){
        $id_compte = $(e.relatedTarget).data("id");
    });

    $("#btnDel").on("click", function () {
        $.ajax({
            type: "POST",
            url: site_url + "index.php/Compte/delete",
            data: {
                id_compte: $id_compte
            },
            success: function(){
                $("#deleteCModal").modal('toggle');
                swal("Suppression réussi","","success")
                getSolde()
                getAllComptes()
            }
        })
    })

    function getAllComptes(){
        $.ajax({
            type: "get",
            url: site_url + "index.php/Compte/getAllComptes",
            success: function(data){
                $("tbody#bodycontent").html(data);
            }
        })
    }

</script>