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
        <div class='col-12 my-5'>
            <h5>
                Mis pedidos
            </h5>
            <p class='text-warning'>
                Pendientes a aprobación
            </p>
            <div class='row mt-3'>
                @foreach($pedidos as $pedido)
                    @if($pedido->estado == 0)
                        <div class="card col-3 px-2 bg-white" style="width: 18rem;">
                            <div class="card-body">
                                <h5 class="card-title">{{$pedido->nombre}}</h5>
                                <h6 class="card-subtitle mb-2 text-muted">Pedido</h6>
                                <p class="card-text font-weight-bold">Codigo pedido</p>
                                <p class="card-text">{{$pedido->codigo}}</p>
                                <p class="card-text">Fecha de creación <br/> {{$pedido->fecha_creacion}}</p>
                                <a href='/' class="card-link">
                                    Detalle
                                </a>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
            <p class='text-warning mt-5'>
                En camino
            </p>
            <div class='row mt-3'>
                @foreach($pedidos as $pedido)
                    @if($pedido->estado != 0 && $pedido->fecha_recibido == null)
                        <div class="card col-3 px-2 bg-white" style="width: 18rem;">
                            <div class="card-body">
                                <h5 class="card-title">{{$pedido->nombre}}</h5>
                                <h6 class="card-subtitle mb-2 text-muted">Pedido</h6>
                                <p class="card-text font-weight-bold">Codigo pedido</p>
                                <p class="card-text">{{$pedido->codigo}}</p>
                                <p class="card-text">Fecha de creación <br/> {{$pedido->fecha_creacion}}</p>
                                <a href='/' class="card-link">
                                    Detalle
                                </a>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
            <p class='text-warning mt-5'>
                Recibidos
            </p>
            <div class='row mt-3'>
                @foreach($pedidos as $pedido)
                    @if($pedido->estado != 0 && $pedido->fecha_recibido != null)
                        <div class="card col-3 px-2 bg-white" style="width: 18rem;">
                            <div class="card-body">
                                <h5 class="card-title">{{$pedido->nombre}}</h5>
                                <h6 class="card-subtitle mb-2 text-muted">Pedido</h6>
                                <p class="card-text font-weight-bold">Codigo pedido</p>
                                <p class="card-text">{{$pedido->codigo}}</p>
                                <p class="card-text">Fecha de creación <br/> {{$pedido->fecha_creacion}}</p>
                                <a href='/' class="card-link">
                                    Detalle
                                </a>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>


@endsection
