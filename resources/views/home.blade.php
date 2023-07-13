@extends('layouts.app')

@section('css')
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.css'/>
@stop

@section('title', 'Inicio')

@section('content_header')
@stop



@section('content')

    @if ($errors->any())
        <div class="alert alert-danger" role="alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row mt-2">
        <div class="col-auto">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalMin"><i
                    class="fas fa-plus"></i> Añadir
            </button>
        </div>
    </div>

    <x-adminlte-modal id="modalMin" title="Añadir Evento" theme="primary">
        <form method="post" action="{{route('calendario.store')}}" novalidate class="needs-validation">
            @csrf
            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="mb-3">
                        <label for="validationCustom02" class="form-label">Fecha/Hora de Inicio</label>
                        <input type="datetime-local" name="fecha_hora_inicio"
                               class="form-control @error('fecha_hora_inicio') is-invalid @enderror"
                               id="validationCustom02"
                               value="{{ old('fecha_hora_inicio') }}" placeholder="Fecha/Hora de Inicio" required>

                        @error('fecha_hora_inicio')
                        <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="mb-3">
                        <label for="validationCustom03" class="form-label">Fecha/Hora de Fin</label>
                        <input type="datetime-local" name="fecha_hora_fin"
                               class="form-control @error('fecha_hora_fin') is-invalid @enderror"
                               id="validationCustom03"
                               value="{{ old('fecha_hora_fin') }}" placeholder="Fecha/Hora de Fin" required>

                        @error('fecha_hora_fin')
                        <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            </div>
            {{-- Titulo field --}}
            <div class="mb-3">
                <label for="validationCustom01" class="form-label">Título</label>
                <input type="text" name="titulo" class="form-control @error('titulo') is-invalid @enderror"
                       id="validationCustom01"
                       value="{{ old('titulo') }}" placeholder="Título" required>

                @error('titulo')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="validationCustom05" class="form-label">Tipo de Evento</label>
                <select class="form-select" aria-label="Default select example" name="tipo_evento_id"
                        @error('tipo_evento_id') is-invalid @enderror required
                        value="{{ old('tipo_evento_id') }}"
                >
                    @foreach ($tipos as $tipo)
                        <option value="{{$tipo->id}}">{{$tipo->nombre}}</option>
                    @endforeach
                </select>

                @error('tipo_evento_id')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="row justify-content-end">
                <div class="col-auto">
                    <x-adminlte-button label="Guardar" theme="success" type="submit" class="bg-success"/>
                </div>

            </div>
        </form>
        <x-slot name="footerSlot">
        </x-slot>
    </x-adminlte-modal>

    <div id='calendar'></div>

    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="#" method="post" id="formedit" novalidate class="needs-validation">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                    <div class="modal-body">
                        <h4>Editar Evento</h4>

                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="mb-3">
                                    <label for="inicioedit" class="form-label">Fecha/Hora de Inicio</label>
                                    <input type="datetime-local" name="fecha_hora_inicio"
                                           class="form-control @error('fecha_hora_inicio') is-invalid @enderror"
                                           id="inicioedit"
                                           value="{{ old('fecha_hora_inicio') }}" placeholder="Fecha/Hora de Inicio"
                                           required>

                                    @error('fecha_hora_inicio')
                                    <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="mb-3">
                                    <label for="finedit" class="form-label">Fecha/Hora de Fin</label>
                                    <input type="datetime-local" name="fecha_hora_fin"
                                           class="form-control @error('fecha_hora_fin') is-invalid @enderror"
                                           id="finedit"
                                           value="{{ old('fecha_hora_fin') }}" placeholder="Fecha/Hora de Fin" required>

                                    @error('fecha_hora_fin')
                                    <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        {{-- Titulo field --}}
                        <div class="mb-3">
                            <label for="tituloedit" class="form-label">Título</label>
                            <input type="text" name="titulo" class="form-control @error('titulo') is-invalid @enderror"
                                   id="tituloedit"
                                   value="{{ old('titulo') }}" placeholder="Título" required>

                            @error('titulo')
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="tipoedit" class="form-label">Tipo de Evento</label>
                            <select class="form-select" aria-label="Default select example" name="tipo_evento_id"
                                    @error('tipo_evento_id') is-invalid @enderror required
                                    id="tipoedit"
                                    value="{{ old('tipo_evento_id') }}"
                            >
                                @foreach ($tipos as $tipo)
                                    <option value="{{$tipo->id}}">{{$tipo->nombre}}</option>
                                @endforeach
                            </select>

                            @error('tipo_evento_id')
                            <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="modal-footer">
                        <input type="submit" class="btn btn-success bg-success" id="appointment_update" value="Guardar">
                        <button type="button" class="btn btn-danger bg-danger" onclick="cerrar()">Cerrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


@section('js')
    <script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/moment.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>
    <script>
        $(document).ready(function () {
            // page is now ready, initialize the calendar...
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'timeGridWeek',
                events: [
                        @foreach($eventos as $evento)
                    {
                        title: '{{$evento->titulo}}',
                        start: '{{$evento->fecha_hora_inicio}}',
                        end: '{{$evento->fecha_hora_fin}}',
                        tipo: '{{$evento->tipo_evento_id}}',
                        id: '{{$evento->id}}',
                        backgroundColor: '{{$evento->tipo_evento->fondo}}',
                        textColor: '{{$evento->tipo_evento->texto}}',
                        borderColor: '{{$evento->tipo_evento->borde}}'
                    },
                    @endforeach
                ],
                eventClick: function (calEvent, jsEvent, view) {
                    $('#formedit').attr('action', '/calendario/' + calEvent.event.id)
                    $('#inicioedit').val(moment(calEvent.event.start).format('YYYY-MM-DD HH:mm:ss'));
                    $('#finedit').val(moment(calEvent.event.end).format('YYYY-MM-DD HH:mm:ss'));
                    $('#tituloedit').val(calEvent.event.title);
                    $('#tipoedit').val(calEvent.event.extendedProps.tipo);
                    $('#editModal').modal('toggle')
                }
            });
            calendar.render();


            const forms = document.querySelectorAll('.needs-validation')

            // Loop over them and prevent submission
            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }

                    form.classList.add('was-validated')
                }, false)
            })
        });
        const cerrar = () => {
            $('#editModal').modal('toggle')
        }
    </script>
@stop
