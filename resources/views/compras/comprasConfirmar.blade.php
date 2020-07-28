@extends('master')

@section('title','Fragance System')
@section('pageTitle', 'Compras')

@section('content')

    <div class='ComprasConfirmar row justify-content-center'>
        <div class='col-12 my-5'>
            <h5 class='font-weight-bold'>
                Confirmación de pedido
            </h5>
            <h5>
                Productor:
                {{$productor->nombre}}
                <br/>
                Proveedor:
                {{$proveedor->nombre}}
            </h5>
        </div>
        <div class='col-12 font-weight-bold'>
            Ingredientes
        </div>
        <div class='col-12 mt-2'>
            <div class='row my-4 text-secondary font-weight-bold'>
                <div class='col'>
                    Nombre
                </div>
                <div class='col'>
                    Precio
                </div>
                <div class='col'>
                    Cantidad
                </div>
            </div>
            @foreach($ingredientes_pedidos as $ingrediente)
                <div class='row text-secondary'>
                    <div class='col'>
                        {{$ingrediente->nombre}}
                    </div>
                    <div class='col'>
                        $ {{$ingrediente->precio}}
                    </div>
                    <div class='col'>
                        {{$det_pedido[$loop->index]->cantidad}} unidades
                    </div>
                </div>
            @endforeach
        </div>
        <div class='col-12 mt-4'>
            <div class='row'>
                <div class='col-auto font-weight-bold'>
                    Monto total Ingredientes
                </div>
                <div class='col-auto'>
                    $ {{$monto_total}}
                </div>
            </div>
        </div>
        <div class='col-12 font-weight-bold mt-5'>
            Envio
        </div>
        <div class='col-12'>
            <div class='row text-secondary font-weight-bold mt-3'>
                <div class='col'>
                    País
                </div>
                <div class='col'>
                    Tipo de envío
                </div>
                <div class='col'>
                    Precio
                </div>
                <div class='col'>
                </div>
            </div>
            <div class='row text-secondary mt-3'>
                <div class='col'>
                    {{$envio->nombre}}
                </div>
                <div class='col'>
                    {{$envio->tipo_transporte}}
                </div>
                <div class='col'>
                    $ {{$envio->costo}}
                </div>
                <div class='col'>
                </div>
            </div>
        </div>
        <div class='col-12 mt-5 font-weight-bold mb-4'>
            Método de pago
        </div>
        <div class='col-12'>
            <div class='row text-secondary font-weight-bold mb-4'>
                <div class='col'>
                    Tipo de pago
                </div>
                <div class='col'>
                    Número de cuotas
                </div>
                <div class='col'>
                    Porcentaje
                </div>
                <div class='col'>
                    Descripción
                </div>
            </div>
            <div class='row text-secondary'>
                <div class='col'>
                    @for($i=0; $i < count($metodos_pago); $i++)

                            <div class='row text-secondary'>
                                <div class='tipoPago col'>
                                    @if ($metodos_pago[$i]->cantidad_cuotas != null)
                                        @if ($i == 0)
                                            {{$metodos_pago[$i]->tipo}}
                                        @else
                                            @if ($metodos_pago[$i]->cod_cond_pago != $metodos_pago[$i - 1]->cod_cond_pago)
                                                {{$metodos_pago[$i]->tipo}}
                                            @endif
                                        @endif
                                    @else
                                        {{$metodos_pago[$i]->tipo}}
                                    @endif
                                </div>
                                <div class='cantCuotas col'>
                                    @if ($metodos_pago[$i]->cantidad_cuotas != null)
                                        @if ($i == 0)
                                            {{$metodos_pago[$i]->cantidad_cuotas}}
                                        @else
                                            @if ($metodos_pago[$i]->cod_cond_pago != $metodos_pago[$i - 1]->cod_cond_pago)
                                                {{$metodos_pago[$i]->cantidad_cuotas}}
                                            @endif
                                        @endif
                                    @else
                                        1
                                    @endif
                                </div>
                                <div class='porcentajeCuotas col'>
                                    @if ($metodos_pago[$i]->cantidad_cuotas != null)

                                            <p class='font-weight-bold mb-0'>
                                                Pago {{$i + 1}}:
                                            </p>
                                                {{$metodos_pago[$i]->porcentaje_pago}} % ‣ $ {{$pedido->total * ($metodos_pago[$i]->porcentaje_pago / 100)}}
                                            <p class='font-weight-bold mb-0'>
                                                Recargo:
                                            </p>
                                            {{$metodos_pago[$i]->porcentaje_recargo}} % + $ {{$pedido->total * ($metodos_pago[$i]->porcentaje_recargo / 100)}}
                                            <p class='font-weight-bold mb-0'>
                                                Descuento:
                                            </p>
                                            {{$metodos_pago[$i]->porcentaje_descuento}} % - $ {{$pedido->total * ($metodos_pago[$i]->porcentaje_descuento / 100)}}
                                    @else
                                    <p class='font-weight-bold mb-0'>
                                        Pago:
                                    </p>
                                        100 % - $ $monto_total
                                    @endif
                                </div>
                                <div class='porcentajeCuotas col'>
                                    @if ($metodos_pago[$i]->cantidad_cuotas != null)
                                        @if ($i == 0)
                                            {{$metodos_pago[$i]->descripcion}}
                                        @else
                                            @if ($metodos_pago[$i]->cod_cond_pago != $metodos_pago[$i - 1]->cod_cond_pago)
                                                {{$metodos_pago[$i]->descripcion}}
                                            @endif
                                        @endif
                                    @else
                                        {{$metodos_pago[$i]->descripcion}}
                                    @endif
                                </div>
                                <div class='col-12'>
                                    <hr/>
                                </div>
                            </div>

                    @endfor
                </div>
            </div>
        </div>
        <div class='col-12 mt-5'>
            <h5>
                Pago Total
                    </br>
                $ {{$pedido->total}}
            </h5>
        </div>
        <div class='col my-5'>
            <a href='/Compras/realizar-compra/confirmar/{{$productor->id}}/{{$proveedor->id}}'>
                <button type='submit' class="btn btn-info">
                    Confirmar
                </button>
            </a>
        </div>
        <div class='col-12 mb-5'>
            <a href='/Compras/menu/{{$productor->id}}'>
                <button type='submit' class="btn btn-info">
                    Cancelar
                </button>
            </a>
        </div>

    </div>

@endsection
