@extends('layouts.app')
@section('content')
    <div class="container">
        Calendario.
        <div id="calendar"></div>
        <div class="modal fade" id="modal-event" tabindex="-1" role="dialog" aria-labelledby="modal-eventLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="event-title"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div id="event-description"></div>
                        <div id="event-start"></div>
                        <div id="event-end"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelada</button>
                        <button type="button" class="btn btn-primary">Realizada</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="evento" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
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
                            <div class="form-group col-auto">
                                <label for="start">Fecha:</label>
                                <input type="datetime-local" class="form-control col-md-8" name="start" id="start"
                                    placeholder="Fecha">
                            </div>
                            <div class="form-group col-auto">
                                <label for="horainicial">Hora:</label>
                                <input type="text" class="form-control col-md-6" name="hora" id="hora"
                                    placeholder="Hora">
                            </div>
                            <div class="form-group col-auto">
                                <label for="end">Fecha-end:</label>
                                <input type="datetime-local" class="form-control col-md-8" name="end" id="end"
                                    placeholder="Fecha">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="title" class="col-form-label">Doctor:</label>
                            <input type="text" class="form-control col-sm-8" name="title" id="title" required=""
                                placeholder="Doctor">
                        </div>
                        <div class="form-group">
                            <label for="description" class="col-form-label">Especialidad:</label>
                            <input type="text" class="form-control col-sm-8" name="description" id="description"
                                required="" placeholder="Especialidad">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" id="btnDelete">Eliminar</button>
                    <button type="button" class="btn btn-primary" id="btnEditar">Editar</button>
                    <button type="button" class="btn btn-success" id="btnGuardar">Guardar</button>
                </div>
            </div>
        </div>
    </div>
@endsection
