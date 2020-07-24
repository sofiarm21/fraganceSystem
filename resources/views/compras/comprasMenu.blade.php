@extends('master')

@section('title','Fragance System')
@section('pageTitle', 'Compras')

@section('content')

    <div class='ComprasMenu row justify-content-center'>
        <div class='col-12 my-5'>
            <h3>
                {{$productor->nombre}}
            </h3>
            <h5>
                Mis proveedores
            </h5>
        </div>
        <div class='col-12'>
            @foreach ($proveedores as $proveedor)
                <a href='/Compras/proveedor/{{$productor->id}}/{{$proveedor->id}}' class='text-light'>
                    <div class='row text-secondary'>
                        <div class='col'>
                            {{$proveedor->nombre}}
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
