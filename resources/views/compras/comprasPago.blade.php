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
                                                {{$metodos_pago[$i]->porcentaje_pago}} % - $ {{$pedido->total * ($metodos_pago[$i]->porcentaje_pago / 100)}}
                                            <p class='font-weight-bold mb-0'>
                                                Recargo:
                                            </p>
                                            {{$metodos_pago[$i]->porcentaje_recargo}} % - $ {{$pedido->total * ($metodos_pago[$i]->porcentaje_recargo / 100)}}
                                            <p class='font-weight-bold mb-0'>
                                                Descuento:
                                            </p>
                                            {{$metodos_pago[$i]->porcentaje_descuento}} % - $ {{$pedido->total * ($metodos_pago[$i]->porcentaje_descuento / 100)}}
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
                        </a>
                    @endfor

                </div>

        </div>
    </div>

@endsection
