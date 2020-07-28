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
        <div class='col-12 mt-5'>
            <h5>
                Productos
            </h5>
        </div>
            @foreach ($productos as $producto)
            <div class='col-4 p-4'>
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
            @if (count($ingredientes_otros) != 0)
            <div class='col-12'>
                <h5>
                    Otros productos
                </h5>
            </div>
            @endif
                @foreach ($ingredientes_otros as $ingrediente)
                <div class='col-4 p-4'>
                    <div class='card bg-white p-0'>
                        <div class='productCard card-img-top'>

                        </div>
                        <div class='card-body'>
                            <div class='text-secondary'>
                                <p class='font-weight-bold'>
                                    {{$ingrediente->nombre}}
                                </p>
                                <p class='font-weight-bold'>
                                    $ {{$ingrediente->precio}} - {{$ingrediente->volml}} ml
                                </p>

                                <div class='row'>
                                    <div class='col'>
                                        Numero IPC
                                    </div>
                                    <div class='col'>
                                        {{$ingrediente->num_ipc}}
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
                                        {{$ingrediente->num_tsca_cas}}
                                    </div>
                                    <div class='col-12'>
                                        <hr/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            <div class='col-12'>
                <div class='row'>
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
                                            {{$condiciones_pago[$i]->tipo}}
                                        @else
                                            @if ($condiciones_pago[$i]->cod_cond_pago != $condiciones_pago[$i - 1]->cod_cond_pago)
                                                {{$condiciones_pago[$i]->tipo}}
                                            @endif
                                        @endif
                                    @else
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
                                            {{$condiciones_pago[$i]->porcentaje_recargo}} %
                                            <p class='font-weight-bold mb-0'>
                                                Descuento:
                                            </p>
                                            {{$condiciones_pago[$i]->porcentaje_descuento}} %
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
                    </div>
                </div>

            </div>

            <div class='col-12 mt-5 mb-4'>
                <h5>
                    Evaluación
                </h5>
                <p class='text-secondary'>
                    Para las proximas preguntas evalue este proveedor en una escala del {{$escala->rango_inicial}} a {{$escala->rango_final}}
                </p>
            </div>
            <form action='/Evaluacion/creacion-contrato/evaluar/{{$productor->id}}/{{$id_proveedor}}' method='post'>
                <div class='col-12'>
                    @foreach ($variables as $variable)
                        <div class='row mb-3'>
                            <div class='col-4'>
                                {{$variable->descripcion}}
                            </div>
                            <div class='col-1'>
                                <input type='text' name='{{$variable->id}}' placeholder='1-10'/>
                            </div>
                        </div>
                    @endforeach
                    {{ csrf_field() }}
                </div>


                <div class='col-6 my-5'>
                    <button type='submit' class="btn btn-info">
                        Crear fórmula
                    </button>
                </div>
            </form>

    </div>

@endsection
