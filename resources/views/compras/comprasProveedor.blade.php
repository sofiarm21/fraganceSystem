@extends('master')

@section('title','Fragance System')
@section('pageTitle', 'Compras')

@section('content')

    <div class='ComprasProveedor row '>
        <div class='col-12 my-5'>
            <h5>
                Mi proveedor
            </h5>
            <h3>
                {{$proveedor->nombre}}
            </h3>
        </div>
        <div class='col-12 mx-0'>
            <h5>
                Productos contratados
            </h5>
            <div class='row'>
                @foreach ($productos_contratados as $producto)
                <div class='col-4 p-4'>
                    <div class='card bg-white p-0'>
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
                </div>
                @endforeach
            </div>
        </div>
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
                            <div class='row'>
                                <div class='col'>
                                    Numero IPC
                                </div>
                                <div class='col'>
                                    {{$ingrediente->ipc}}
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
                                    {{$ingrediente->tsca_cas}}
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
        <div class='col-6 font-weight-bold my-5'>
            <h5>
                Métodos de pago
            </h5>
        </div>
        <div class='col-6 font-weight-bold my-5'>
            <h5>
                Métodos de envío
            </h5>
        </div>
        <div class='col-6'>
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
        <div class='col-6'>
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
        <div class='col-12 px-5 my-5'>
            <a href='/Compras/realizar-compra/{{$productor->id}}/{{$proveedor->id}}' class='text-light'>
                <button type="button" class="btn btn-info  w-100">
                    Realizar pedido
                </button>
            </a>
        </div>
    </div>

@endsection
