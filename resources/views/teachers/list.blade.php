@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-start">
        @include('layouts.left-menu')
        <div class="col-md-10">
            <div class="row pt-2">
                <div class="col ps-4">
                    <h1 class="display-6 mb-3">
                        <i class="bi bi-person-lines-fill"></i> @lang('Teacher List') </h1>
                    <div class="card mb-4 p-3 bg-white border shadow-sm">
                        <div class="row">
                            @can ('create users')
                            <div class="col-md-2 mb-4">
                                <a href="{{route('teacher.create.show')}}" style="width:100%" id="btnAgregar" type="button" class="btn btn-sm btn-primary">@lang('Add')</a>
                            </div> 
                            @endcan
                            @can ('import users')               
                            <div class="col-md-2 mb-4">
                                <button  style="width:100%" id="btnImportar" type="button" class="btn btn-sm btn-warning">@lang('Import')</button>
                            </div>
                            @endcan
                        </div>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th width="10%" scope="col">@lang('Photo')</th>
                                    <th width="10%" scope="col">@lang('Document')</th>
                                    <th width="20%" scope="col">@lang('Name')</th>
                                    <th width="20%" scope="col">@lang('Email')</th>
                                    <th width="10%" scope="col">@lang('Phone')</th>
                                    <th width="20%" scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($teachers as $teacher)
                                <tr>
                                    <td>
                                        @if (isset($teacher->photo))
                                            <img src="{{asset('/storage'.$teacher->photo)}}" class="rounded" alt="Profile picture" height="30" width="30">
                                        @else
                                            <i class="bi bi-person-square"></i>
                                        @endif
                                    </td>
                                     <td>{{$teacher->document}}</td>
                                    <td>{{$teacher->first_name}} {{$teacher->last_name}}</td>
                                    <td>{{$teacher->email}}</td>
                                    @if(Auth::user()->role != "student" and Auth::user()->role != "padre")
                                    <td>{{$teacher->phone}}</td>
                                    @endif
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{url('teachers/view/profile/'.$teacher->id)}}" role="button" class="btn btn-sm btn-primary"><i class="bi bi-eye"></i> @lang('Profile')</a>
                                            @can('edit users')
                                            <a href="{{route('teacher.edit.show', ['id' => $teacher->id])}}" role="button" class="btn btn-sm btn-warning"><i class="bi bi-pen"></i> @lang('Edit')</a>
                                            @endcan
                                            @can('delete users')
                                            <button onClick="btnEliminar({{$teacher->id}})" id="btnEliminar" type="button" class="btn btn-sm btn-danger btnEliminar"><i class="bi bi-trash2"></i> @lang('Delete')</button>
                                            @endcan                                            
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @include('layouts.footer')
        </div>
    </div>
</div>

<div class="modal fade" id="importarModal" role="dialog">
    <div class="modal-dialog modal-right modal-notify modal-info" role="document"  style="min-width: 40%;">
        <div class="modal-content">
            <div class="modal-header">
              <p class="heading lead">@lang('Import') @lang('Teachers')<span id="spTitulo"></span></p> 
            </div>
            <div class="modal-body" id="bodyImportar">
                <div class="row" style="margin-bottom: 20px;">
                    <div class="col-md-4">
                        <a href="{{asset('modelos/docentes.xlsx')}}" style="text-align: center;display: block;" type="button" class="btn btn-round btn-primary"></i> @lang('Download Model')</a>
                    </div> 
                </div>

                <div class="row">  
                  <div class="col-md-10 offset-md-1" style="margin-top: 20px;margin-bottom: 20px;">
                    <input class="form-control" type="file" name="archivoxls" id="archivoxls">
                  </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <a style="width: 100%;text-align: center;display: block;" type="button" id="btnCierraImportar" class="btn btn-default btn-round" data-dismiss="modal">@lang('Cancel')</a>
                    </div>
                    <div class="col-md-6">   
                          <a style="width: 100%;text-align: center;display: block;" type="button" onclick="importar()" class="btn btn-round btn-success"></i> @lang('Import')</a>
                    </div>
                </div>                  
            </div> 
        </div>
    </div>
</div>

<script>
function importar(){
        let url = "{{route('teachers.importar')}}";
        var file = $('#archivoxls')[0].files[0];

        var formData = new FormData();
        formData.append('file',file);

        toggleGifLoad();
        $.ajax({
            method: 'POST',
            dataType: 'json',
            url: url,
            data:formData,
            contentType: false,
            processData: false,
            headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val()
                }
            }).done(function(response) {
                //response = JSON.parse(response);
                if(response.success == 'true'){ 
                    Swal.fire({
                      icon: 'success',
                      title: response.texto,
                      showConfirmButton: false,
                      timer: 1500
                    });
                     $('#importarModal').modal('hide');
                }else{
                    Swal.fire({
                      icon: 'error',
                      title: response.texto,
                      showConfirmButton: false,
                      timer: 1500
                    })
                }

            })
            .always(toggleGifLoad)
            .fail((error) => {
                Swal.fire("Oops!... tuvimos un problema", "", "error");
            }).always();
}

    function btnEliminar($id){
        Swal.fire({
          title: 'Estás seguro que deseas eliminar?',
          text: "No podrás revertir esta acción!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          cancelButtonText: 'Cancelar',
          confirmButtonText: 'Si, eliminar!'
        }).then((result) => {
          if (result.isConfirmed) {
            eliminar($id);
          }
        })
    }

    function eliminar($id){
        let url = "{{route('teachers.delete')}}";
        toggleGifLoad();
        $.ajax({
            method: 'POST',
            type: 'json',
            url: url+'?id='+$id,
            headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val()
                }
            }).done(function(response) {
                response = JSON.parse(response);
                if(response.success == 'true'){ 
                    Swal.fire({
                      icon: 'success',
                      title: response.texto,
                      showConfirmButton: false,
                      timer: 1500
                    });

                   window.location.reload();
                }
            })
            .always(toggleGifLoad)
            .fail((error) => {
                Swal.fire("Oops!... tuvimos un problema", "", "error");
            }).always();
    }

$('document').ready(function(){
    $('#btnImportar').click(function(){
        $('#importarModal').modal('show');
    })

    $('#btnCierraImportar').click(function(){
        $('#importarModal').modal('hide');
    })

});

</script>

@endsection
