@extends('master')

@section('title','Fragance System')
@section('pageTitle', 'Crear contrato')

@section('content')

    <div class='EvaluacionGeneracionContrato row mt-4'>
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

        <form action='/Evaluacion/generacion-contrato/create/{{$productor->id}}/{{$proveedor[0]->id}}' method='POST' class='row'>
            @foreach ($productos as $producto)
            <div class='col-4 p-4'>
                <input class="form-check-input" type="checkbox" name='producto_codigo[]' id='{{$producto->codigo}}' value='{{$producto->codigo}}'/>
                <div class='card bg-white p-0'>
                    <div class='productCard card-img-top'>

                    </div>
                    <div class='card-body'>
                        <div class='text-secondary'>
                            <p class='font-weight-bold'>
                                {{$producto->nombre}}
                            </p>
                            <p class='font-weight-bold'>
                                $ {{$producto->precio}} - {{$producto->volml}} ml
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
            </div>
            @endforeach
            <div class='col-6 mt-5'>
                <div class='col-12 mb-4'>
                    <h5>
                        Condiciones de pago
                    </h5>
                </div>
                <div class='col-12'>
                    <div class='row font-weight-bold my-5'>
                        <div class='col'>
                            Tipo de pago
                        </div>
                        <div class='col'>
                            Cantidad de cuotas
                        </div>
                        <div class='col'>
                            Pagos
                        </div>
                    </div>
                @for ($i = 0; $i < count($condiciones_pago); $i++)
                    <div class='row text-secondary'>
                        <div class='tipoPago col'>
                            @if ($condiciones_pago[$i]->cantidad_cuotas != null)
                                @if ($i == 0)
                                    <input class="form-check-input" type="checkbox" name='condiciones_pago[]' value='{{$condiciones_pago[$i]->codigo}}' id='{{$condiciones_pago[$i]->codigo}}'/>

                                    {{$condiciones_pago[$i]->tipo}}
                                @else
                                    @if ($condiciones_pago[$i]->cod_cond_pago != $condiciones_pago[$i - 1]->cod_cond_pago)
                                    <input class="form-check-input" type="checkbox" name='condiciones_pago[]' value='{{$condiciones_pago[$i]->codigo}}' id='{{$condiciones_pago[$i]->codigo}}'/>

                                        {{$condiciones_pago[$i]->tipo}}
                                    @endif
                                @endif
                            @else
                                <input class="form-check-input" type="checkbox" name='condiciones_pago[]' value='{{$condiciones_pago[$i]->codigo}}' id='{{$condiciones_pago[$i]->codigo}}'/>
                                {{$condiciones_pago[$i]->tipo}}
                            @endif
                        </div>
                        <div class='cantCuotas col'>
                            @if ($condiciones_pago[$i]->cantidad_cuotas != null)
                                @if ($i == 0)
                                    {{$condiciones_pago[$i]->cantidad_cuotas}}
                                @else
                                    @if ($condiciones_pago[$i]->cod_cond_pago != $condiciones_pago[$i - 1]->cod_cond_pago)
                                        {{$condiciones_pago[$i]->cantidad_cuotas}}
                                    @endif
                                @endif
                            @else
                                1
                            @endif
                        </div>
                        <div class='porcentajeCuotas col'>
                            @if ($condiciones_pago[$i]->cantidad_cuotas != null)

                                    <p class='font-weight-bold mb-0'>
                                        Pago {{$i + 1}}:
                                    </p>
                                        {{$condiciones_pago[$i]->pago_porcentajes}} %
                                    <p class='font-weight-bold mb-0'>
                                        Recargo:
                                    </p>
                                    {{$condiciones_pago[$i]->recargo}} %
                                    <p class='font-weight-bold mb-0'>
                                        Descuento:
                                    </p>
                                    {{$condiciones_pago[$i]->descuento}} %
                            @else
                            <p class='font-weight-bold mb-0'>
                                Pago:
                            </p>
                                100 %
                            @endif
                        </div>



                        <div class='col-12'>
                            <hr/>
                        </div>
                    </div>
                @endfor
                </div>
            </div>
            <div class='col-6 mt-5'>
                <div class='row'>
                    <div class='col-12 mb-4'>
                        <h5>
                            Condiciones de envio
                        </h5>
                    </div>
                    <div class='col-4 font-weight-bold mt-3 mb-4'>

                            Pais

                    </div>
                    <div class='col-4 font-weight-bold mt-3 mb-4'>

                            Tipo

                    </div>
                    <div class='col-4 font-weight-bold mt-3 mb-4'>

                            Precio

                    </div>
                </div>
                @foreach ($condiciones_envio as $condicion_envio)
                    <div class='row text-secondary'>
                        <div class='col'>

                            <input class="form-check-input" type="checkbox" name='condicion_envio[]' value='{{$condicion_envio->cod_pais}}' id='{{$condicion_envio->cod_pais}}'/>
                            {{$condicion_envio->envio_pais}}
                        </div>
                        <div class='col'>
                            {{$condicion_envio->envio_transporte}}
                        </div>
                        <div class='col'>
                            {{$condicion_envio->envio_costo}}
                        </div>
                        <div class='col-12'>
                            <hr/>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class='col-12 my-5'>
                <h5>
                    Exclusividad
                </h5>
                <input class="form-check-input" type="checkbox" name='exclusividad' vallue=true id='exclusividad'/>
                <p class='text-secondary'>
                    Quiero que la relación con este proveedor sea exclusiva
                </p>
            </div>
            <div class='col-12 mb-5'>
                <h5>
                    Información
                </h5>
                <p class='text-secondary'>
                    Este contrato tendra vigencia de un año desde el momento de su generación.
                </p>
                <p class='text-secondary font-weight-bold'>
                    Fecha finalizacion: {{ date('d-m-Y',strtotime('+1 year'))}}
                </p>
                <p class='text-secondary'>
                    Se debe evaluar esta relación dos meses antes de la culminación del contrato
                </p>
                <p class='text-secondary font-weight-bold'>
                    Fecha evaluación: {{ date('d-m-Y',strtotime('+1 year , -2 months'))}}
                </p>
            </div>
            <div class='col-6 mb-5'>
                {{ csrf_field() }}
                <button type='submit' class="btn btn-info">
                    Generar contrato
                </button>
            </div>
        </form>
    </div>

@endsection
