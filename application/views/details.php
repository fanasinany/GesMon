<?php 
    $mois_fr = ["Janvier","Février","Mars","Avril","Mai","Juin",
    "Juillet","Aout","Septembre","Octobre","Novembre","Decembre"];
    if(isset($mois_selected) && isset($annee_selected)){
        $moisnb = $mois_selected;
        $anneenb = $annee_selected;
    }
    else{
        $moisnb = (int)date("m");
        $anneenb = date("Y");
    }
?>
<div class="row">
    <div class="col-sm-6">
    <h3>Tableau de bord mois de <?= $mois_fr[$moisnb-1]?> <?= $anneenb ?></h3>
    </div>
    <div class="col-sm-6">
        <a href="<?= base_url("index.php/Details?id=$id&mois=$moisnb&annee=$anneenb") ?>" class="btn btn-warning btn-sm mt-4" style="margin-left: 300px;">Tableau de bord</a>
        <a href="<?= base_url("index.php/Entree?id=$id&mois=$moisnb&annee=$anneenb") ?>" class="btn btn-rose btn-sm mt-4">Entrée</a>
        <a href="<?= base_url("index.php/Sortie?id=$id&mois=$moisnb&annee=$anneenb") ?>" class="btn btn-info btn-sm mt-4">Sortie</a>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header-info">
                <div class="card-title">DIAGRAMME DES SORTIES PAR JOUR</div>
            </div>
            <div class="card-body">
                <canvas id="myChartSortie" height="80"></canvas>
            </div>
        </div>
        
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header-rose">
                <div class="card-title">DIAGRAMME DES ENTREES PAR JOUR</div>
            </div>
            <div class="card-body">
                <canvas id="myChartEntries" height="80"></canvas>
            </div>
        </div>
        
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        getSolde()
    })
    var label_date = [];
    var money_day_sortie = <?php echo json_encode($moneydaysortie)?>;
    var money_day_entries = <?php echo json_encode($moneydayentries)?>;

    for (let i = 1; i < 32; i++) {
        label_date[i-1] = i;    
    }

    var ctx = document.getElementById('myChartSortie').getContext('2d');
    var myChartSortie = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: label_date,
            datasets: [{
                label: 'Ariary / Jour',
                data: money_day_sortie,
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });

    var cty = document.getElementById('myChartEntries').getContext('2d');
    var myChartEntries = new Chart(cty, {
        type: 'bar',
        data: {
            labels: label_date,
            datasets: [{
                label: 'Ariary / Jour',
                data: money_day_entries,
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
</script>