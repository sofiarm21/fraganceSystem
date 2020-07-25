@extends('master')

@section('title','Fragance System')
@section('pageTitle', 'Compras')

@section('content')

    <div class='ComprasResumen row'>
        <div class='col-12'>
            <h5>
                Detalle de pedido
            </h5>
        </div>
        <div class='col-auto font-weight-bold mt-5'>
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
        <div class='col-12 font-weight-bold mt-5 text-warning'>
            Total de pedido
            <br/>
            $ {{$monto_total + $envio->costo}}
        </div>
        <div class='col my-5'>
            <a href=''>
                <button type='submit' class="btn btn-info">
                    Continuar
                </button>
            </a>
        </div>


    </div>

@endsection
