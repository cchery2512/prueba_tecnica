@extends('layouts.app')

@section('title', 'Listado de usuarios')

@section('content_header')
    <h1><span><i class="fas fa-users"></i></span> Listado de usuarios</h1>
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
            <a href="{{ route('usuarios.index') }}">
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
            'Email',
            'Activado',
            ['label' => 'Acciones', 'no-export' => true, 'width' => 5],
        ];

        $config = [
            'columns' => [['orderable' => true], ['orderable' => true], ['orderable' => true],['orderable' => true], ['orderable' => false]],
        ];
    @endphp

    {{-- Minimal example / fill data using the component slot --}}

    <div class="card mt-2">
        <div class="card-body">

            {{-- Compressed with style options / fill data using the plugin config --}}
            <x-adminlte-datatable id="table2" :heads="$heads" head-theme="dark" :config="$config"
                                  striped hoverable bordered compressed>
                @foreach($usuarios->items() as $row)
                    <tr>
                        <td>{!! $row->id !!}</td>
                        <td>{!! $row->name !!}</td>
                        <td>{!! $row->email !!}</td>
                        <td>{!! $row->estado? 'Si': 'No' !!}</td>
                        <td>
                            <nobr>
                                <button class="btn d-inline-block btn-xs btn-default text-primary mx-1 shadow"
                                        title="Edit"
                                        onclick="editar({{$row->toJson()}})">
                                    <i class="fa fa-lg fa-fw fa-pen"></i>
                                </button>
                                <form action="{{route('usuarios.destroy', ['usuario' => $row->id])}}" method="post"
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
        </div>
        <x-adminlte-modal id="modalMin" title="Añadir usuario" theme="primary">
            <form method="post" action="{{route('usuarios.store')}}" novalidate class="needs-validation">
                @csrf
                {{-- Name field --}}
                <div class="mb-3">
                    <label for="validationCustom01" class="form-label">Nombre</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                           id="validationCustom01"
                           value="{{ old('name') }}" placeholder="Name" required>

                    @error('name')
                    <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                    @enderror
                </div>

                {{-- Email field --}}
                <div class="mb-3">
                    <label for="validationCustom02" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                           id="validationCustom02"
                           value="{{ old('email') }}" placeholder="{{ __('adminlte::adminlte.email') }}" required>

                    @error('email')
                    <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                    @enderror
                </div>

                {{-- Password field --}}
                <div class="mb-3">
                    <label for="validationCustom03" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                           id="validationCustom03"
                           placeholder="{{ __('adminlte::adminlte.password') }}" required>


                    @error('password')
                    <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                    @enderror
                </div>

                {{-- Confirm password field --}}
                <div class="mb-3">
                    <label for="validationCustom04" class="form-label">Confirm Password</label>
                    <input type="password" name="password_confirmation"
                           class="form-control @error('password_confirmation') is-invalid @enderror"
                           id="validationCustom04"
                           placeholder="{{ __('adminlte::adminlte.retype_password') }}" required>

                    @error('password_confirmation')
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


    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="#" method="post" id="formedit" novalidate class="needs-validation">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Editar Usuario</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        {{ csrf_field() }}
                        {{ method_field('PUT') }}

                        {{-- Name field --}}
                        <div class="mb-3">
                            <label for="nameedit" class="form-label">Nombre</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                   id="nameedit"
                                   value="{{ old('name') }}" placeholder="Name" required>

                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        {{-- Email field --}}
                        <div class="mb-3">
                            <label for="emailedit" class="form-label">Email</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                   id="emailedit"
                                   value="{{ old('email') }}" placeholder="{{ __('adminlte::adminlte.email') }}"
                                   required>

                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        {{-- Estado field --}}
                        <div class="mb-3">
                            <label for="estadoedit" class="form-label">Estado</label>
                            <select class="form-select" name="estado"
                                    id="estadoedit"
                                    @error('estado') is-invalid @enderror required
                                    value="{{ old('estado') }}"
                            >
                                <option value="1">Activo</option>
                                <option value="0">Inactivo</option>
                            </select>

                            @error('estado')
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

@stop

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
            $('#formedit').attr('action', '/usuarios/' + data.id)
            $('#nameedit').val(data.name)
            $('#emailedit').val(data.email)
            $('#estadoedit').val(data.estado ? 1 : 0)
            $('#exampleModal').modal('toggle')
        }

        const cerrar = () => {
            $('#exampleModal').modal('toggle')
        }
    </script>
@endsection

