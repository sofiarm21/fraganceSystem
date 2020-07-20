@extends('master')

@section('title','Fragance System')
@section('pageTitle', 'Crear contrato')

@section('content')

    <div class='EvaluacionContrato row mt-4'>
        <div class='col-12'>
            <h5>
                Información del proveedor
            </h5>
            <h5 class='font-weight-bold'>
                {{$proveedor[0]->proveedor_nombre}}
            </h5>
            <div class='row text-secondary mt-4'>
                <div class='col'>
                    <p class='font-weight-bold mb-0'>
                        Pagina web:
                    </p>
                    {{$proveedor[0]->proveedor_pag_web}}
                </div>
                <div class='col'>
                    <p class='font-weight-bold mb-0'>
                        Teléfono:
                    </p>
                    {{$proveedor[0]->proveedor_telefono}}
                </div>
                <div class='col'>
                    <p class='font-weight-bold mb-0'>
                        Correo:
                    </p>
                    {{$proveedor[0]->proveedor_correo}}
                </div>
                <div class='col'>
                    <p class='font-weight-bold mb-0'>
                        Ubicación:
                    </p>
                    {{$proveedor[0]->pais_nombre}}
                </div>
                <div class='col'>
                    <p class='font-weight-bold mb-0'>
                        Ubicación:
                    </p>
                    {{$proveedor[0]->proveedor_desc_ubicacion}}
                </div>
            </div>
        </div>
        <div class='col-12'>
            <h5>
                Productos
            </h5>
        </div>
            @foreach ($productos as $producto)

                <div class='card col-3 m-4 bg-white p-0'>
                    <div class='productCard card-img-top'>

                    </div>
                    <div class='card-body'>
                        <div class='text-secondary'>
                            <p class='font-weight-bold'>
                                {{$producto->nombre}}
                            </p>
                            <div class='row '>
                                <div class='col'>
                                    Nombre alternativo
                                </div>
                                <div class='col'>
                                    {{$producto->nombre_alternativo}}
                                </div>
                                <div class='col-12'>
                                    <hr/>
                                </div>
                            </div>
                            <div class='row'>
                                <div class='col'>
                                    Numero IPC
                                </div>
                                <div class='col'>
                                    {{$producto->num_ipc}}
                                </div>
                                <div class='col-12'>
                                    <hr/>
                                </div>
                            </div>
                            <div class='row'>
                                <div class='col'>
                                    Numero TSCA_CAS
                                </div>
                                <div class='col'>
                                    {{$producto->num_tsca_cas}}
                                </div>
                                <div class='col-12'>
                                    <hr/>
                                </div>
                            </div>
                            <div class='row'>
                                <div class='col'>
                                    Numero EINECS
                                </div>
                                <div class='col'>
                                    {{$producto->num_einecs}}
                                </div>
                                <div class='col-12'>
                                    <hr/>
                                </div>
                            </div>
                            <div class='row'>
                                <div class='col'>
                                    Descripción visual
                                </div>
                                <div class='col'>
                                    {{$producto->descripcion_visual}}
                                </div>
                                <div class='col-12'>
                                    <hr/>
                                </div>
                            </div>
                            <div class='row'>
                                <div class='col'>
                                    Vida útil
                                </div>
                                <div class='col'>
                                    {{$producto->vida_util}}
                                </div>
                                <div class='col-12'>
                                    <hr/>
                                </div>
                            </div>
                            <div class='row'>
                                <div class='col'>
                                    Solubilidad
                                </div>
                                <div class='col'>
                                    {{$producto->solubilidad}}
                                </div>
                                <div class='col-12'>
                                    <hr/>
                                </div>
                            </div>
                            <div class='row'>
                                <div class='col'>
                                        Inflamabilidad
                                </div>
                                <div class='col'>
                                    {{$producto->inflamabilidad}}
                                </div>
                                <div class='col-12'>
                                    <hr/>
                                </div>
                            </div>
                            <div class='row'>
                                <div class='col'>
                                        Proceso
                                </div>
                                <div class='col'>
                                    {{$producto->proceso}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            @endforeach
    </div>

@endsection
