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
            </div>
            <div class='row text-secondary'>
                <div class='col'>
                    {{$condicion_pago->tipo}}
                </div>
                <div class='col'>
                    @if($condicion_pago->cantidad_cuotas == null)
                        1
                    @endif
                    {{$condicion_pago->cuotas}}
                </div>
                <div class='col'>
                    @if($condicion_pago->porcentaje == null)
                        100%
                    @endif
                    {{$condicion_pago->porcentaje}}
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

    </div>

@endsection
