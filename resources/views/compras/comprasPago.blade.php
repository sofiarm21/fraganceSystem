@extends('master')

@section('title','Fragance System')
@section('pageTitle', 'Compras')

@section('content')

    <div class='ComprasPago row justify-content-center'>
        <div class='col-12 my-5'>
            <h5>
                Método de pago
            </h5>
            <p class='text-secondary'>
            Selecciones el método de pago a aplicar en este pedido
            </p>
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

                    @for($i=0; $i < count($metodos_pago); $i++)
                        <a href='/Compras/realizar-compra/metodo-pago/{{$productor->id}}/{{$proveedor->id}}/{{$metodos_pago[$i]->codigo}}' class='col-12'>
                            <div class='row'>
                                <div class='col'>
                                    {{$metodos_pago[$i]->tipo}}
                                </div>
                                <div class='col'>
                                    @if ($metodos_pago[$i]->cantidad_cuotas == null)
                                        1
                                    @endif
                                    {{$metodos_pago[$i]->cantidad_cuotas}}
                                </div>
                                <div class='col'>
                                    @if ($metodos_pago[$i]->pago_porcentajes == null)
                                        100 %
                                    @endif
                                    {{$metodos_pago[$i]->pago_porcentajes}}
                                    @if ($i+1 <  count($metodos_pago))
                                        @while($metodos_pago[$i+1]->codigo == $metodos_pago[$i]->codigo)
                                            {{$metodos_pago[$i]->pago_porcentajes}}
                                        @endwhile
                                    @endif
                                </div>
                                <div class='col-12'>
                                    <hr/>
                                </div>
                            </div>
                        </a>
                    @endfor

                </div>

        </div>
    </div>

@endsection
