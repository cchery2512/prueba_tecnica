@extends('layouts.app')
@section('title', 'Listado de Tipo de Eventos')

@section('content_header')
    <h1><span><i class="fas fa-users"></i></span> Listado de Tipo de Eventos</h1>
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

    <div class="row">
        <div class="col-auto">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalMin"><i
                    class="fas fa-plus"></i> Añadir
            </button>
        </div>
        <div class="col-auto">
            <a href="{{ route('tipoevento.index') }}">
                <button type="button" class="btn btn-primary"><i class="fas fa-redo"></i> Recargar</button>
            </a>
        </div>
        <div class="col-auto">
            <a href="{{route('home')}}">
                <button type="button" class="btn btn-primary"><i class="fas fa-arrow-left"></i> Volver</button>
            </a>
        </div>
    </div>

    {{-- Setup data for datatables --}}
    @php
        $heads = [
            'ID',
            'Nombre',
            'Fondo',
            'Borde',
            'Texto',
            ['label' => 'Acciones', 'no-export' => true, 'width' => 5],
        ];

        $config = [
            'columns' => [['orderable' => true], ['orderable' => true], ['orderable' => true],['orderable' => true], ['orderable' => true],['orderable' => false]],
        ];
    @endphp

    {{-- Minimal example / fill data using the component slot --}}

    <div class="card mt-2">
        <div class="card-body">

            {{-- Compressed with style options / fill data using the plugin config --}}
            <x-adminlte-datatable id="table2" :heads="$heads" head-theme="dark" :config="$config"
                                  striped hoverable bordered compressed beautify>
                @foreach($tipos as $row)
                    <tr>
                        <td>{!! $row->id !!}</td>
                        <td>{!! $row->nombre !!}</td>
                        <td>
                        <span style="background-color: {{ $row->fondo  }}; width: 20px; height: 20px"
                              class="d-inline-block"></span> {!! $row->fondo !!}
                        </td>
                        <td><span style="background-color: {{ $row->borde  }}; width: 20px; height: 20px"
                                  class="d-inline-block"></span> {!! $row->borde !!}</td>
                        <td><span style="background-color: {{ $row->texto  }}; width: 20px; height: 20px"
                                  class="d-inline-block"></span> {!! $row->texto !!}</td>
                        <td>
                            <nobr>
                                <button class="btn d-inline-block btn-xs btn-default text-primary mx-1 shadow"
                                        title="Edit"
                                        onclick="editar({{$row->toJson()}})">
                                    <i class="fa fa-lg fa-fw fa-pen"></i>
                                </button>
                                <form action="{{route('tipoevento.destroy', ['tipoevento' => $row->id])}}" method="post"
                                      class="d-inline-block">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <button class="btn btn-xs btn-default text-danger mx-1 shadow" title="Delete">
                                        <i class="fa fa-lg fa-fw fa-trash"></i>
                                    </button>
                                </form>
                            </nobr>
                        </td>
                    </tr>
                @endforeach
            </x-adminlte-datatable>

            <x-adminlte-modal id="modalMin" title="Añadir Tipo de Evento" theme="primary">
                <form method="post" action="{{route('tipoevento.store')}}" novalidate class="needs-validation">
                    @csrf
                    {{-- Name field --}}
                    <div class="mb-3">
                        <label for="validationCustom01" class="form-label">Nombre</label>
                        <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror"
                               id="validationCustom01"
                               value="{{ old('nombre') }}" placeholder="Name" required>

                        @error('nombre')
                        <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    {{-- Fondo field --}}
                    <div class="mb-3">
                        <label for="validationCustom02" class="form-label">Fondo</label>
                        <input type="text" name="fondo" class="form-control @error('fondo') is-invalid @enderror"
                               id="validationCustom02"
                               value="{{ old('fondo') }}" placeholder="Fondo" required>

                        @error('fondo')
                        <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    {{-- Texto field --}}
                    <div class="mb-3">
                        <label for="validationCustom03" class="form-label">Texto</label>
                        <input type="text" name="texto" class="form-control @error('texto') is-invalid @enderror"
                               id="validationCustom03"
                               value="{{ old('texto') }}" placeholder="Texto" required>

                        @error('texto')
                        <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    {{-- Borde Field --}}
                    <div class="mb-3">
                        <label for="validationCustom04" class="form-label">Borde</label>
                        <input type="text" name="borde" class="form-control @error('borde') is-invalid @enderror"
                               id="validationCustom04"
                               value="{{ old('borde') }}" placeholder="Borde" required>

                        @error('borde')
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
        </div>

    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="#" method="post" id="formedit" novalidate class="needs-validation">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Editar Tipo de Evento</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        {{ csrf_field() }}
                        {{ method_field('PUT') }}

                        {{-- Name field --}}
                        <div class="mb-3">
                            <label for="nombreedit" class="form-label">Nombre</label>
                            <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror"
                                   id="nombreedit"
                                   value="{{ old('nombre') }}" placeholder="Name" required>

                            @error('nombre')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        {{-- Fondo field --}}
                        <div class="mb-3">
                            <label for="fondoedit" class="form-label">Fondo</label>
                            <input type="text" name="fondo" class="form-control @error('fondo') is-invalid @enderror"
                                   id="fondoedit"
                                   value="{{ old('fondo') }}" placeholder="Fondo" required>

                            @error('fondo')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        {{-- Texto field --}}
                        <div class="mb-3">
                            <label for="textoedit" class="form-label">Texto</label>
                            <input type="text" name="texto" class="form-control @error('texto') is-invalid @enderror"
                                   id="textoedit"
                                   value="{{ old('texto') }}" placeholder="Texto" required>

                            @error('texto')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        {{-- Borde Field --}}
                        <div class="mb-3">
                            <label for="bordeedit" class="form-label">Borde</label>
                            <input type="text" name="borde" class="form-control @error('borde') is-invalid @enderror"
                                   id="bordeedit"
                                   value="{{ old('borde') }}" placeholder="Borde" required>

                            @error('borde')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                    </div>
                    <div class="modal-footer">

                        <button type="submit" class="btn btn-success bg-success">Guardar</button>
                        <button type="button" class="btn btn-danger bg-danger" onclick="cerrar()">Cerrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script>
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

        const editar = (data) => {
            console.log(data)
            $('#formedit').attr('action', '/tipoevento/' + data.id)
            $('#nombreedit').val(data.nombre)
            $('#fondoedit').val(data.fondo)
            $('#textoedit').val(data.texto)
            $('#bordeedit').val(data.borde)
            $('#exampleModal').modal('toggle')
        }

        const cerrar = () => {
            $('#exampleModal').modal('toggle')
        }
    </script>
@endsection
