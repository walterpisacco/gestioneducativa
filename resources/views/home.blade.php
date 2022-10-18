@extends('layouts.app')

@section('content')
<style type="text/css">
table {
    display: table;
    overflow-x: auto;
}
</style>
<div class="container">
    <div class="row justify-content-start">
        @include('layouts.left-menu')
        <div class="col-md-10">
            <div class="row pt-3">
                    <h1 class="display-6 mb-3"><i class="ms-auto bi bi-grid"></i> {{ __('Dashboard') }}</h1> 
                    @can ('view stadistic')
                    <div class="row dashboard">
                      <div class="col-md-5">
                         <div class="card chart-container">
                            <div class="usr-chart-container">
                               <i class="material-icons" style="color:grey">watch_later</i> Última actualización <span id="spHora">00:00</span> 
                              <canvas id="presentismo-chart" style="border-radius: 10px;"></canvas>
                            </div>
                          </div>
                      </div>                        
                        <div class="col-md-4">
                           <div class="card chart-container">
                              <div class="usr-chart-container">
                                <canvas id="class-chart" style="border-radius: 10px;"></canvas>

                              </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                           <div class="card chart-container">
                              <div class="usr-chart-container">
                                <canvas id="usr-chart" style="border-radius: 10px;"></canvas>

                              </div>
                            </div>
                        </div>
                      </div>
                      <div class="row dashboard">
                      <div class="col-md-2 cards anchoFijo" style="display:none">
                        <div class="card">
                          <div class="card-body">
                            <div class="badge-verde info">
                             <span class="verde" id="spAlumnos">{{$AlumnosCant}}</span>
                            </div>
                            <h3 class="card-title"><i class="material-icons">school</i> @lang('Students')</h3>
                          </div>
                        </div>
                      </div>                        
                        <div class="col-md-3" style="display: none;">
                           <div class="card chart-container">
                              <div class="usr-chart-container">
                                <canvas id="admin-chart" style="border-radius: 10px;"></canvas>

                              </div>
                            </div>
                        </div>                                                         
                    </div>
                    @endcan
                    <!--div class="row align-items-md-stretch mt-4">
                        <div class="col">
                            <div class="p-3 text-white bg-dark rounded-3">
                                <h3>Bienvenido a Gestión Escolar!</h3>
                                <p><i class="bi bi-emoji-heart-eyes"></i> Gracias por tu apoyo</p>
                            </div>
                        </div>
                        <div class="col">
                            <div class="p-3 bg-white border rounded-3" style="height: 100%;">
                                <h3>@lang('Manage school better')</h3>
                                <p class="text-end">@lang('with') <i class="bi bi-lightning"></i> <a href="http://cienciayjusticia.org" target="_blank" style="text-decoration: none;">cienciayjusticia.org</a> <i class="bi bi-lightning"></i>.</p>
                            </div>
                        </div-->
                    <div class="row mt-4">
                        <div class="col-lg-6">
                            <div class="card mb-3 shadow-sm">
                                <div class="card-header bg-transparent"><i class="bi bi-calendar-event me-2"></i> @lang('Events')</div>
                                <div class="card-body text-dark">
                                    @include('components.events.event-calendar', ['editable' => 'false', 'selectable' => 'false'])
                                    {{-- <div class="overflow-auto" style="height: 250px;">
                                        <div class="list-group">
                                            <a href="#" class="list-group-item list-group-item-action">
                                                <div class="d-flex w-100 justify-content-between">
                                                <h5 class="mb-1">List group item heading</h5>
                                                <small>3 days ago</small>
                                                </div>
                                                <p class="mb-1">Some placeholder content in a paragraph.</p>
                                                <small>And some small print.</small>
                                            </a>
                                        </div>
                                    </div> --}}
                                </div>
                            </div>
                        </div>
                         @can ('view notices')
                        <div class="col-lg-6">
                            <div class="card mb-3 shadow-sm">
                                <div class="card-header bg-transparent d-flex justify-content-between"><span><i class="bi bi-megaphone me-2"></i> @lang('Notices')</span> {{ $notices->links() }}</div>
                                <div class="card-body p-0 text-dark">
                                    <div>
                                        @isset($notices)
                                        <div class="accordion accordion-flush" id="noticeAccordion">
                                            @foreach ($notices as $notice)
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="flush-heading{{$notice->id}}">
                                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse{{$notice->id}}" aria-expanded={{($loop->first)?"true":"false"}} aria-controls="flush-collapse{{$notice->id}}">
                                                        @lang('Published at'): {{$notice->created_at->format('d/m/Y')}}
                                                    </button>
                                                </h2>
                                                <div id="flush-collapse{{$notice->id}}" class="accordion-collapse collapse {{($loop->first)?"show":"hide"}}" aria-labelledby="flush-heading{{$notice->id}}" data-bs-parent="#noticeAccordion">
                                                    <div class="accordion-body overflow-auto">{!!Purify::clean($notice->notice)!!}</div>
                                                </div>
                                            </div>
                                            @endforeach
                                            @endisset
                                            @if(count($notices) < 1)
                                                <div class="p-3">@lang('No notices')</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endcan
                    </div>
                </div>
            </div>
            @include('layouts.footer')
        </div>
    </div>
</div>
@endsection

<script src="https://code.jquery.com/jquery-3.6.0.js" ></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script type="text/javascript">

$(document).ready(function() {

var cDataAdmin = JSON.parse('<?php print_r($dataAdmin); ?>');
var cDataUsr = JSON.parse('<?php print_r( $dataAlumnos); ?>');
var cDataClass = JSON.parse('<?php print_r( $dataClases); ?>');
var cDataPresentismo = JSON.parse('<?php print_r( $dataPresentismo); ?>');


    backgroundColor =   ['rgba(255,  99, 132, 0.2)',
                         'rgba(255, 159,  64, 0.2)',
                         'rgba(255, 205,  86, 0.2)',
                         'rgba( 75, 192, 192, 0.2)',
                         'rgba( 54, 162, 235, 0.2)',
                         'rgba(153, 102, 255, 0.2)',
                         'rgba(201, 203, 207, 0.2)',
                        ];
    borderColor =       ['rgb(255,  99, 132)',
                         'rgb(255, 159,  64)',
                         'rgb(255, 205,  86)',
                         'rgb( 75, 192, 192)',
                         'rgb( 54, 162, 235)',
                         'rgb(153, 102, 255)',
                         'rgb(201, 203, 207)'
                        ];  

      const dataUsr = {
        labels: cDataUsr.label,
        datasets: [{
          label: 'Alumnos',
            backgroundColor: [backgroundColor[0],backgroundColor[1]],
            borderColor: [borderColor[0],borderColor[1]],
            borderWidth: [1, 1, 1, 1, 1,1,1],
          data: cDataUsr.data,
        }],
      };

      const dataAdmin = {
        labels: cDataAdmin.label,
        datasets: [{
          label: 'Administracion',
            backgroundColor: [backgroundColor[2],backgroundColor[3],backgroundColor[4],backgroundColor[5]],
            borderColor: [borderColor[2],borderColor[3],borderColor[4],borderColor[5]],
            borderWidth: [1, 1, 1, 1, 1,1,1],
          data: cDataAdmin.data,
        }],
      };

      const dataClass = {
        labels: cDataClass.label,
        datasets: [{
          label: 'Clases',
            backgroundColor: backgroundColor,
            borderColor: borderColor,
            borderWidth: [1, 1, 1, 1, 1,1,1],
          data: cDataClass.data,
        }],
      };

      const dataPresentismo = {
        labels: cDataPresentismo.label,
        datasets: [{
          label: 'Clases',
            backgroundColor: [backgroundColor[3],backgroundColor[2],backgroundColor[0]],
            borderColor: [borderColor[3],borderColor[2],borderColor[0]],
            borderWidth: [1, 1, 1, 1, 1,1,1],
          data: cDataPresentismo.data,
        }],
      };                    

    var optionsUsr = {
        responsive: true,
        title: {
          display: true,
          position: "bottom",
          text: "Alumnos por Género",
          fontSize: 16,
          fontColor: "#111"
        },
        legend: {
          display: true,
          position: "left",
          labels: {
            fontColor: "#333",
            fontSize: 16
          }
        },
        scales: {
        yAxes: [{
          display: 1,
          gridLines: 1,
          ticks: {
            display: false,
            beginAtZero: true,
          },
          gridLines: {
            drawTicks: true,
            display: false,
            drawBorder: false
          }
        }],
        xAxes: [{
          display: 1,
          gridLines: 1,
          ticks: {
            display: false
          },
          gridLines: {
            drawTicks: true,
            display: false,
            drawBorder: false
          }
        }]
      },
        layout: {
            padding: {
                top: 20
            }
        }        
      };

        var optionsAdmin = {
        responsive: true,
        title: {
          display: true,
          position: "bottom",
          text: "Personal por Rol",
          fontSize: 16,
          fontColor: "#111"
        },
        legend: {
          display: false,
          position: "left",
          labels: {
            fontColor: "#333",
            fontSize: 16
          }
        },
        scales: {
        yAxes: [{
          display: 1,
          gridLines: 1,
          ticks: {
            display: false,
            beginAtZero: true,
          },
          gridLines: {
            drawTicks: true,
            display: false,
            drawBorder: false
          }
        }],
        xAxes: [{
          display: 1,
          gridLines: 1,
          ticks: {
            display: true
          },
          gridLines: {
            drawTicks: true,
            display: false,
            drawBorder: false
          }
        }]
      },
        layout: {
            padding: {
                top: 20
            }
        }        
      };

        var optionsClass = {
        responsive: true,
        title: {
          display: true,
          position: "bottom",
          text: "Alumnos por Año",
          fontSize: 16,
          fontColor: "#111"
        },
        legend: {
          display: false,
          position: "left",
          labels: {
            fontColor: "#333",
            fontSize: 16
          }
        },
        scales: {
        yAxes: [{
          display: 1,
          gridLines: 1,
          ticks: {
            display: false,
            beginAtZero: true,
          },
          gridLines: {
            drawTicks: true,
            display: false,
            drawBorder: false
          }
        }],
        xAxes: [{
          display: 1,
          gridLines: 1,
          ticks: {
            display: true
          },
          gridLines: {
            drawTicks: true,
            display: false,
            drawBorder: false
          }
        }]
      },
        layout: {
            padding: {
                top: 20
            }
        }        
      };  

    const fecha = new Date();
      var titulo = "Asistencia de Alumnos "+fecha.toLocaleDateString();
        var optionsPresentismo = {
        responsive: true,
        title: {
          display: true,
          position: "bottom",
          text: titulo,
          fontSize: 16,
          fontColor: "#111"
        },
        legend: {
          display: false,
          position: "left",
          labels: {
            fontColor: "#333",
            fontSize: 16
          }
        },
        scales: {
        yAxes: [{
          display: 1,
          gridLines: 1,
          ticks: {
            display: false,
            beginAtZero: true,
          },
          gridLines: {
            drawTicks: true,
            display: false,
            drawBorder: false
          }
        }],
        xAxes: [{
          display: 1,
          gridLines: 1,
          ticks: {
            display: true
          },
          gridLines: {
            drawTicks: true,
            display: false,
            drawBorder: false
          }
        }]
      },
        layout: {
            padding: {
                top: 20
            }
        }        
      };            

    const configUsr = {type: 'pie',data: dataUsr,options: optionsUsr};
    const myUsr = new Chart(document.getElementById('usr-chart'),configUsr);   

    const configAdmin = {type: 'bar',data: dataAdmin,options: optionsAdmin};
    const myAdmin = new Chart(document.getElementById('admin-chart'),configAdmin);  

    const configClass = {type: 'bar',data: dataClass,options: optionsClass};
    const myClass = new Chart(document.getElementById('class-chart'),configClass);  

    const configPresentismo = {type: 'bar',data: dataPresentismo,options: optionsPresentismo};
    const myPresentismo = new Chart(document.getElementById('presentismo-chart'),configPresentismo);          

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

