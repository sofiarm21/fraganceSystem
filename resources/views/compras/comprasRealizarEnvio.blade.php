@extends('master')

@section('title','Fragance System')
@section('pageTitle', 'Compras')

@section('content')

    <div class='Compras row justify-content-center'>
        <div class='col-12 mt-5'>
            <h5 class='font-weight-bold'>Tipo de envio</h5>
            <h5>Pedido a {{$proveedor->nombre}}</h5>
        </div>
        <div class='col-12 text-secondary mt-5'>
            @foreach($condiciones_envio as $cond_envio)
            <a href='/Compras/realizar-compra/create-envio/{{$productor->id}}/{{$proveedor->id}}/{{$cond_envio->cod_pais}}/{{$cond_envio->envio_transporte}}' class='text-light'>
                <div class='row'>
                    <div class='col'>
                        {{$cond_envio->envio_transporte}}
                    </div>
                    <div class='col'>
                        {{$cond_envio->envio_costo}}
                    </div>
                    <div class='col'>
                        {{$cond_envio->envio_pais}}
                    </div>
                    <div class='col-12'>
                        <hr/>
                    </div>
                </div>
            </a>
            @endforeach
        </div>



    </div>

@endsection
