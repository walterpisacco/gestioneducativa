@extends('layouts.app')

@section('content')
<style>
table{
    border:1px solid #0c2e72;
}
th{
    border:1px solid #0c2e72;
}
td{
    border:1px solid #0c2e72;
}
</style>
<div class="container">
    <div class="row justify-content-start">
        @include('layouts.left-menu')
        <div class="col-md-10">
            <div class="row pt-2">
                <div class="col ps-4">
                    <h1 class="display-6 mb-3"><i class="bi bi-calendar4-range"></i> @lang('Report Card')</h1>
                        <div class="row">
                            <h5><i class="bi bi-person"></i> @lang('Student Name'): {{$student->first_name}} {{$student->last_name}}</h5>
                            <div class="col-md-6">
                                <div class="card chart-container">
                                    <div class="usr-chart-container">
                                        <canvas id="examen-chart" style="border-radius: 10px;"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6" style="display:none">
                                        <div class="card">
                                            primera
                                        </div>
                                    </div>
                                    <div class="col-md-6 text-center">
                                        <div class="card">
                                           <h4 class="mt-2">Examenes Rendidos</h4>
                                           <div class="text-center">
                                                <div class="row mb-4">
                                                    <div class="col-md-4">
                                                        <p>Aprobados</p>
                                                        <span style="font-size: xx-large;color: green;" id="spExmanes">{{$notas[0]}}</span>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <p>Desap.</p>
                                                        <span style="font-size: xx-large;color: red;" id="spExmanes">{{$notas[1]}}</span>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <p>Ausente</p>
                                                        <span style="font-size: xx-large;color: grey;" id="spExmanes">{{$notas[2]}}</span>
                                                    </div>                                                    
                                                </div>
                                           </div>
                                           </div>
                                    </div>
                                </div>
                                <div class="row mt-4" style="display:none">
                                    <div class="col-md-6">
                                        <div class="card">
                                        segunda
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card">
                                            Promedio General
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row pt-4" style="display:none">
                            <div class="col-md-12">
                                <table>
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th colspan="3" style="text-align: center;">1 trimestre</th>
                                        </tr>                                        
                                        <tr>
                                            <th align="center">Materia</th>
                                            <th>Participación</th>
                                            <th>Observaciones</th>
                                            <th>Calificaciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td align="center"> Matemática</td>
                                            <td align="center">SI</td>
                                            <td align="center">SE RATEO</td>
                                            <td align="center">9</td>
                                        </tr>
                                        <tr>
                                            <td>Literatura</td>
                                            <td align="center">SI</td>
                                            <td>VINO MAMADO</td>
                                            <td align="center">7</td>
                                        </tr>
                                        <tr>
                                            <td>Biología</td>
                                            <td align="center">NO</td>
                                            <td>NO SE BAÑA</td>
                                            <td align="center">4</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.footer')
    </div>
</div>
</div>
@endsection

<script src="https://code.jquery.com/jquery-3.6.0.js" ></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.0.1/chart.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script type="text/javascript">

$(document).ready(function() {

    var cDataExamen = JSON.parse('<?php print_r($marks); ?>');
    const dataExamen = {
        labels: cDataExamen.label,
        datasets:cDataExamen.dataset
        /*
        datasets: [
              {
                label: 'Matemática',
                data: [4,8,8,6],
                borderColor: 'rgb(255, 99, 132)',
                backgroundColor: 'rgba(255, 99, 132, 0.5)',
              },
              {
                label: 'Lengua',
                data: [9,7,7],
                borderColor: 'rgb(53, 162, 235)',
                backgroundColor: 'rgba(53, 162, 235, 0.5)',
              },
      ]
      */,
    };

const config = {
  type: 'line',
  data: dataExamen,
  options: {
    responsive: true,
    plugins: {
      legend: {
        position: 'top',
      },
      title: {
        display: true,
        text: 'Evolución de los Examenes Realizados'
      }
    },
    scales: {
      y: {
        min: 1,
        max: 10,
      }
  }
}
}

    const myChart = new Chart(document.getElementById('examen-chart'),config);   
  
  Chart.plugins.register({
  afterDatasetsDraw: function(chartInstance, easing) {
    // To only draw at the end of animation, check for easing === 1
    var ctx = chartInstance.chart.ctx;
    chartInstance.data.datasets.forEach(function(dataset, i) {
      var meta = chartInstance.getDatasetMeta(i);
      if (!meta.hidden) {
        meta.data.forEach(function(element, index) {
          // Draw the text in black, with the specified font
          ctx.fillStyle = 'black';
          var fontSize = 16;
          var fontStyle = 'bold';
          var fontFamily = 'Helvetica Neue';
          ctx.font = Chart.helpers.fontString(fontSize, fontStyle, fontFamily);
          // Just naively convert to string for now
          var dataString = dataset.data[index].toString();
          // Make sure alignment settings are correct
          ctx.textAlign = 'center';
          ctx.textBaseline = 'middle';
          var padding = -10;
          var position = element.tooltipPosition();
          ctx.fillText(dataString + ' ', position.x, position.y - (fontSize) - padding);
        });
      }
    });
  }
});  

    $('#spHora').text(fecha.getHours() + ":" + fecha.getMinutes());    

  });

</script>

