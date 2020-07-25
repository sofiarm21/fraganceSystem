@extends('master')

@section('title','Fragance System')
@section('pageTitle', 'Compras')

@section('content')

    <div class='ComprasRealizar row justify-content-center'>
        <div class='col-12 mt-4'>
            <h5>
                Ingredientes
            </h5>
        </div>
        <div class='col-12 mt-5'>
            <div class='row font-weight-bold text-secondary'>
                <div class='col'>
                     Cantidad
                </div>
                <div class='col'>
                    Nombre
                </div>
                <div class='col'>
                    Precio/Volumen
                </div>
                <div class='col'>
                    Descripción
                </div>
                <div class='col'>
                    Número IPC
                </div>
            </div>
        </div>
        <div class='col-12'>
            <hr/>
        </div>
        <div class='col-12'>
    <form  action='/Compras/realizar-compra/create-productos/{{$productor->id}}/{{$proveedor->id}}' method='POST' class='row'>
            @foreach ($productos as $producto)

                    <div class='col-12'>
                        <div class='row text-secondary'>
                            <div class='col'>
                                 <input type="number" name='producto[]' class="form-control" id="producto"/>
                                 <input type="hidden" name="producto[]" value="{{ $producto->cod_presentacion}}">
                            </div>
                            <div class='col'>
                                {{$producto->nombre}}
                            </div>
                            <div class='col'>
                                $ {{$producto->precio}} - {{$producto->volml}} ml
                            </div>
                            <div class='col'>
                                {{$producto->otro}}
                            </div>
                            <div class='col'>
                                {{$producto->num_ipc}}
                            </div>
                        </div>
                    </div>
                    <div class='col-12'>
                        <hr/>
                    </div>
            @endforeach
            @if(count($ingredientes_otros) > 0)
            <div class='col-12 my-4'>
                <h5>
                    Otros
                </h5>
            </div>
            <div class='col-12 text-secondary font-weight-bold'>
                <div class='row'>
                    <div class='col'>
                        Cantidad
                    </div>
                    <div class='col'>
                        Nombre
                    </div>
                    <div class='col'>
                        Precio/Vol
                    </div>
                    <div class='col'>
                        Descripción
                    </div>
                    <div class='col'>
                        Número IPC
                    </div>
                </div>
            </div>
            <div class='col-12  mb-2'>
                <hr/>
            </div>
            @endif
            @foreach ($ingredientes_otros as $producto)
                    <div class='col-12'>
                        <div class='row text-secondary'>
                            <div class='col'>
                                 <input type="number" name='producto_otro[]' class="form-control" id="producto"/>
                                 <input type="hidden" name="producto_otro[]" value="{{ $producto->cod_presentacion}}">
                            </div>
                            <div class='col'>
                                {{$producto->nombre}}
                            </div>
                            <div class='col'>
                                $ {{$producto->precio}} - {{$producto->volml}} ml
                            </div>
                            <div class='col'>
                                {{$producto->otro}}
                            </div>
                            <div class='col'>
                                {{$producto->num_ipc}}
                            </div>
                        </div>
                    </div>
                    <div class='col-12'>
                        <hr/>
                    </div>
            @endforeach

                <div class='col-12 my-5'>
                    <div class='row'>
                        <div class='col-7'>
                            {{ csrf_field() }}
                            <button type='submit' class="btn btn-info">
                                Continuar
                            </button>
                        </div>
                    </div>
                </div>

        </form>
    </div>
    </div>

@endsection
