@extends('layouts.app')

@section('content')
<script src="{{ asset('js/masonry.pkgd.min.js') }}"></script>
<div class="container">
    <div class="row justify-content-start">
        @include('layouts.left-menu')
        <div class="col-md-10">
            <div class="row pt-2">
                <div class="col ps-4">
                    <h1 class="display-6 mb-3">
                        <i class="bi bi-tools"></i> @lang('Schools')
                    </h1>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <div class="row"> 
                            <div class="col-md-12 mb-12">
                                <div class="p-3 border bg-light shadow-sm card">
                                <h6>@lang('Create School')</h6>
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>@lang('Name')</label>
                                                <input class="form-control form-control-sm" id="name" name="name" type="text" placeholder="ej: Escuela Normal 1, CABA" required>
                                            </div>
                                            <div class="col-md-5">
                                                 <label>@lang('Address')</label>
                                                <input class="form-control form-control-sm" id="direccion" name="direccion" type="text" placeholder="ej: Moreno 200, CABA">
                                            </div>
                                            <div class="col-md-3">
                                                 <label>@lang('Phone')</label>
                                                <input class="form-control form-control-sm" id="contacto" name="contacto" type="text" placeholder="">
                                            </div>                                            
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <button type="button" id="btnGrabaEscuela" class="mt-3 btn btn-sm btn-success"><i class="bi bi-check2"></i> @lang('Create')</button>
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table mt-4">
                                    <thead>
                                        <tr>
                                            <th scope="col" width="30%"> @lang('Name')</th>
                                            <th scope="col" width="30%"> @lang('Address')</th>
                                            <th scope="col" width="20%"> @lang('Phone')</th>
                                            <th scope="col" width="20%"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="bodyEscuela">
                                        @isset($schools)
                                            @foreach ($schools as $school)
                                            <tr>
                                                <td>{{$school->name}}</td>
                                                <td>{{$school->direccion}}</td>
                                                <td>{{$school->contacto}}</td>
                                                <td>
                                                    <button onClick="javascript:agregarAdmin({{$school->id}});" type="button" class="btn btn-sm btn-warning btnEliminar"> @lang('Add Admins')</button>                                                    
                                                    <button onClick="javascript:Eliminar({{$school->id}});" type="button" class="btn btn-sm btn-danger btnEliminar"> @lang('Delete')</button>
                                                </td>
                                            </tr>
                                            @endforeach
                                        @endisset                                                
                                    </tbody>
                                </table>
                            </div>
                        </div>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="AdminModal" role="dialog">
    <div class="modal-dialog modal-right modal-notify modal-info" role="document"  style="min-width: 30%;">
        <div class="modal-content">
            <div class="modal-header">
              <p class="heading lead">@lang('Administrator')<span id="spTitulo"></span></p> 
            </div>
            <div class="modal-body" id="bodyAdmin">
                <div class="row">
                    <input type="hidden" name="school_id" id="school_id">  
                  <div class="col-md-12">
                    <label>@lang('Email')</label>
                    <input type="mail"class="form-control" name="email" id="email" required>
                  </div>
                  <div class="col-md-12">
                    <label>@lang('Password') (8 caracteres mínimo)</label>
                    <input type="password"class="form-control" name="password" id="password" required>
                  </div>
                  <div class="col-md-12">
                    <label>@lang('Confirm Password')</label>
                    <input type="password"class="form-control" name="confirm_password" id="confirm_password" required>
                  </div>                                    
                </div>
                <div class="row" style="margin-top:20px">
                    <div class="col-md-6">
                        <a style="width: 100%;text-align: center;display: block;" type="button" id="btnCierraAdmin" class="btn btn-default btn-round" data-dismiss="modal">@lang('Cancel')</a>
                    </div>
                    <div class="col-md-6">   
                          <a style="width: 100%;text-align: center;display: block;" id="btnAdmin" type="button" onclick="crearAdmin()" class="btn btn-round btn-success"></i> @lang('Create')</a>
                    </div>
                </div>                  
            </div> 
        </div>
    </div>
</div>

  @include('layouts.footer')
<script>
    $('#btnGrabaEscuela').on('click',function(){
        let url = "{{route('school.create')}}";
        name = $('#name').val();
        direccion = $('#direccion').val();
        contacto = $('#contacto').val();

        toggleGifLoad();
        $.ajax({
            method: 'POST',
            type: 'json',
            url: url+'?name='+name+'&direccion='+direccion+'&contacto='+contacto,
            headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val()
                }
            }).done(function(response) {
                response = JSON.parse(response);
                if(response.success == 'true'){ 
                    $('#name').val('');
                    $('#direccion').val('');
                    $('#contacto').val('');
                    Swal.fire({
                      icon: 'success',
                      title: response.texto,
                      showConfirmButton: false,
                      timer: 1500
                    });
                    $("#bodyEscuela").append('<tr><td>'+name+'</td><td>'+direccion+'</td><td>'+contacto+'</td><td><button onClick="javascript:agregarAdmin('+response.id+');" type="button" class="btn btn-sm btn-warning btnEliminar"> @lang("Add Admins")</button><button onClick="javascript:Eliminar('+response.id+');" type="button" class="btn btn-sm btn-danger btnEliminar"> @lang("Delete")</button></td></tr>');
                }

            })
            .always(toggleGifLoad)
            .fail((error) => {
                Swal.fire("Oops!... tuvimos un problema", "", "error");
            }).always();
    })

    function Eliminar(me){
        Swal.fire("Oops!... opción no disponible para este usuario DEMO", "", "error");
    }

    function agregarAdmin($id){
        $('#school_id').val('');
        $('#email').val('');
        $('#password').val('');
        $('#confirm_password').val('');        
        $('#school_id').val($id);
        $('#AdminModal').modal('show');
    }

    $('#btnCierraAdmin').click(function(){
        $('#AdminModal').modal('hide');
    }) 

    function crearAdmin(){
        let url = "{{route('school.admin.create')}}";
        school_id = $('#school_id').val();
        email = $('#email').val();
        password = $('#password').val();
        confirm_password = $('#confirm_password').val();

        if(confirm_password != password){
            Swal.fire("Oops!... las contraseñas no coinciden", "", "error");
            return;
        }

        toggleGifLoad();
        $.ajax({
            method: 'POST',
            type: 'json',
            url: url,
            data:{school_id:school_id,email:email,password:password},
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
                    $('#school_id').val('');
                    $('#email').val('');
                    $('#password').val('');
                    $('#confirm_password').val('');
                    $('#AdminModal').modal('hide');
                }else{
                    Swal.fire("Oops!..."+response.texto, "", "error");
                    return;
                }

            })
            .always(toggleGifLoad)
            .fail((error) => {
                Swal.fire("Oops!... tuvimos un problema", "", "error");
            }).always();        

    }   

</script>
@endsection