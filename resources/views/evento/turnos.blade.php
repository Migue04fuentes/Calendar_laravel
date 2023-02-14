@extends('layouts.app')
<style>
    body{
        background: #efefef;
    }
</style>
@section('content')
    <div class="container">
        <div id="calendar"></div>
    </div>
    <div class="modal fade" id="modal_turnos" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Apartar Cita</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="/newcita" method="post">
                        {!! csrf_field() !!}
                        <div class="row g-3">
                            <div class="form-group col-md-6">
                                <label for="start">Hora Inicio:</label>
                                <input type="datetime-local" class="form-control col-md-10" name="start" id="start_turnos"
                                    placeholder="Fecha">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="end">Hora Final:</label>
                                <input type="datetime-local" class="form-control col-md-10" name="end" id="end_turnos"
                                    placeholder="Fecha">
                            </div>
                        </div>
                        <div class="form-group" hidden>
                            <label for="id_doctor" class="col-form-label">Cupos:</label>
                            <input type="text" class="form-control col-sm-8" name="id_doctor" id="id_doctor"
                                value="1" placeholder="Doctor">
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="title" class="col-form-label">Cupos:</label>
                                <input type="text" class="form-control col-sm-8" name="cupos" id="cupos_turnos" required=""
                                    placeholder="Cupos">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="description" class="col-form-label">Intervalos:</label>
                                <input type="text" class="form-control col-sm-8" name="intervalos" id="intv_turnos"
                                    required="" placeholder="Cupos">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" id="btnDelete">Eliminar</button>
                    <button type="button" class="btn btn-primary" id="btnEditar">Actualizar</button>
                    <button type="button" class="btn btn-success" id="btnGuardar">Guardar</button>
                </div>
            </div>
        </div>
    </div>
@endsection
<script src="https://code.jquery.com/jquery-3.2.1.js"></script>
<script src="{{ asset('js/turnos.js') }}" ></script>
