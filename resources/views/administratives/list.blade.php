@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-start">
        @include('layouts.left-menu')
        <div class="col-md-10">
            <div class="row pt-2">
                <div class="col ps-4">
                    <h1 class="display-6 mb-3">
                        <i class="bi bi-person-lines-fill"></i> @lang('Administratives List') </h1>
                    <div class="card mb-4 p-3 bg-white border shadow-sm">
                        <div class="row">
                            @can ('create users')
                            <div class="col-md-2">
                                <a href="{{route('administrative.create.show')}}" style="width:100%" id="btnAgregar" type="button" class="btn btn-sm btn-primary">@lang('Add')</a>
                            </div> 
                            @endcan                      
                        </div>                 
                        <table class="table">
                            <thead>
                                <tr>
                                    <th width="10%" scope="col">@lang('Photo')</th>
                                    <th width="10%" scope="col">@lang('Document')</th>
                                    <th width="10%" scope="col">@lang('Rol')</th>
                                    <th width="20%" scope="col">@lang('Name')</th>
                                    <th width="20%" scope="col">@lang('Email')</th>
                                    <th width="10%" scope="col">@lang('Phone')</th>
                                    <th width="20%" scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($administratives as $administrative)
                                <tr>
                                    <td>
                                        @if (isset($administrative->photo))
                                            <img src="{{asset('/storage'.$administrative->photo)}}" class="rounded" alt="Profile picture" height="30" width="30">
                                        @else
                                            <i class="bi bi-person-square"></i>
                                        @endif
                                    </td>
                                    <td>{{$administrative->document}}</td>
                                    <td>{{$administrative->role}}</td>
                                    <td>{{$administrative->first_name}} {{$administrative->last_name}}</td>
                                    <td>{{$administrative->email}}</td>
                                    <td>{{$administrative->phone}}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{url('administratives/view/profile/'.$administrative->id)}}" role="button" class="btn btn-sm btn-primary"><i class="bi bi-eye"></i> @lang('Profile')</a>
                                            @can('edit users')
                                            <a href="{{route('administrative.edit.show', ['id' => $administrative->id])}}" role="button" class="btn btn-sm btn-warning"><i class="bi bi-pen"></i> @lang('Edit')</a>
                                            @endcan
                                            @can('delete users')
                                            <button onClick="btnEliminar({{$administrative->id}})" id="btnEliminar" type="button" class="btn btn-sm btn-danger btnEliminar"><i class="bi bi-trash2"></i> @lang('Delete')</button>
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

<script>

$('document').ready(function(){
});

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
        let url = "{{route('administrative.delete')}}";
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

</script>

@endsection
