<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.3/dist/Chart.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.3/dist/Chart.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/chart.js@2.9.3/dist/Chart.min.css">
<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
$client = \Yii::$app->clickhouse;
$sql = 'select * from data';
$data = [];//$client->createCommand($sql)->queryAll();
$url = \yii\helpers\Url::to(['site/api']);



$script = <<< JS
var dataa;
   function the_func(response) {
     dataa =  JSON.parse(response);
       window.myLine.update();
     return dataa;
  }
   worker(the_func);
  var ctx = document.getElementById('myChart').getContext('2d');

 
  // console.log(dataa);
function worker(the_func) {
       
    $.ajax({
        type: "POST",
        // dataType: 'json',
         async: false,

        url: "$url",
        contentType: "application/json",
        success:  the_func,
        error: function (data) {
            console.log(data);
        },
    });
  
   setTimeout(worker, 1000);
    
   
    }
   
    
   window.myLine  =  new Chart(ctx, {
        type: 'line',
        data: {
           // labels: [1500,1600,1700,1750,1800,1850,1900,1950,1999,2050],
             datasets: [
                 {
                data: dataa['Pressure'],
                label: "Pressure",
                borderColor: "#3e95cd",
                fill: false
            }, 
            {
                data: dataa['Humidity'],
                label: "Humidity",
                borderColor: "#8e5ea2",
                fill: false
            },
             {
                data: dataa['TemperatureR'],
                label: "TemperatureR",
                borderColor: "#3cba9f",
                fill: false
            },
             {
                data: dataa['TemperatureA'],
                label: "TemperatureA",
                borderColor: "#e8c3b9",
                fill: false
            }, {
                data: dataa['pH'],
                label: "pH",
                borderColor: "#c45850",
                fill: false
            }
            ]
        },
        options: {
            title: {
                display: true,
                text: 'World population per region (in millions)'
            }
        }
    });
 
    
    
JS;
$this->registerJs($script);


?>

<div class="site-index">
    <div class="row">
        <div class="col-md-6">
            <canvas id="myChart" width="400" height="400"></canvas>
        </div>
        <div class="col-md-6">
            <table border="1">
                <tr>
                    <td> CounterID</td>
                    <td> Pressure</td>
                    <td> Humidity</td>
                    <td> TemperatureR</td>
                </tr>
                <? foreach ($data as $item) : ?>
                    <tr>
                        <td><?= $item['CounterID'] ?></td>
                        <td><?= $item['Pressure'] ?></td>
                        <td><?= $item['Humidity'] ?></td>
                        <td><?= $item['TemperatureR'] ?></td>
                    </tr>
                <? endforeach; ?>
            </table>
        </div>
    </div>
</div>
<script>


</script>