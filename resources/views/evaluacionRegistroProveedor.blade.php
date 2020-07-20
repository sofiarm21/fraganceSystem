@extends('master')

@section('title','Fragance System')
@section('pageTitle', 'Registrar proveedor')

@section('content')

    <div class='EvaluacionRegistroProveedor row mt-4'>
        <div class='col-12'>
            <h3>
                Proveedores
            </h3>
            <p class='text text-secondary mb-5'>
                Los siguientes proveedores estan disponibles y tienen envíos a su país
            </p>
            <div class='row my-2 py-3 text text-info border border-dark font-weight-bold'>
                <div class='col-3'>
                    Proveedor
                </div>
                <div class='col-3'>
                    Envios a
                </div>
                <div class='col-3'>
                    Modo de envio
                </div>
                <div class='col-3'>
                    Costo
                </div>
            </div>
            @foreach ($proveedores as $proveedor)
                <div class='row my-2'>
                    <div class='col-3'>
                        {{$proveedor->proveedor_nombre}}
                    </div>
                    <div class='col-3'>
                        {{$proveedor->pais_nombre}}
                    </div>
                    <div class='col-3'>
                        {{$proveedor->tipo_envio}}
                    </div>
                    <div class='col-3'>
                        $ {{$proveedor->costo_envio}}
                    </div>
                    <div class='col-12'>
                        <hr/>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

@endsection
