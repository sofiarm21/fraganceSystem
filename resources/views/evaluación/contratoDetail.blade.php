@extends('master')

@section('title','Fragance System')
@section('pageTitle', 'Detalle de contrato')

@section('content')

    <div class='EvaluacionDetail row mt-4'>
        <div class='col-12'>
            <h3>
                Contrato
            </h3>
            <h3>
                {{$productor->nombre}} - {{$proveedor->nombre}}
            </h3>

        </div>

        <div class='col-12 my-5'>
            <h5>
                Información del proveedor
            </h5>
            <h5 class='font-weight-bold'>
                {{$proveedor->nombre}}
            </h5>
            <div class='row text-secondary mt-4'>
                <div class='col'>
                    <p class='font-weight-bold mb-0'>
                        Pagina web:
                    </p>
                    {{$proveedor->pag_web}}
                </div>
                <div class='col'>
                    <p class='font-weight-bold mb-0'>
                        Teléfono:
                    </p>
                    {{$proveedor->telefono}}
                </div>
                <div class='col'>
                    <p class='font-weight-bold mb-0'>
                        Correo:
                    </p>
                    {{$proveedor->correo}}
                </div>
                <div class='col'>
                    <p class='font-weight-bold mb-0'>
                        Ubicación:
                    </p>
                    {{$proveedor->desc_ubicacion}}
                </div>
            </div>
        </div>
        <div class='col-12 '>
            <h5>
                Materias primas contratadas
            </h5>
        </div>

        @foreach ($productos as $producto)
            <div class='col-4 p-4'>
                <div class='card bg-white p-0'>
                    <div class='productCard card-img-top'>

                    </div>
                    <div class='card-body'>
                        <div class='text-secondary'>
                            <p class='font-weight-bold'>
                                {{$producto->nombre}}
                            </p>
                            <div class='row '>
                                <div class='col'>
                                    Nombre alternativo
                                </div>
                                <div class='col'>
                                    {{$producto->nombre_alternativo}}
                                </div>
                                <div class='col-12'>
                                    <hr/>
                                </div>
                            </div>
                            <div class='row'>
                                <div class='col'>
                                    Numero IPC
                                </div>
                                <div class='col'>
                                    {{$producto->num_ipc}}
                                </div>
                                <div class='col-12'>
                                    <hr/>
                                </div>
                            </div>
                            <div class='row'>
                                <div class='col'>
                                    Numero TSCA_CAS
                                </div>
                                <div class='col'>
                                    {{$producto->num_tsca_cas}}
                                </div>
                                <div class='col-12'>
                                    <hr/>
                                </div>
                            </div>
                            <div class='row'>
                                <div class='col'>
                                    Numero EINECS
                                </div>
                                <div class='col'>
                                    {{$producto->num_einecs}}
                                </div>
                                <div class='col-12'>
                                    <hr/>
                                </div>
                            </div>
                            <div class='row'>
                                <div class='col'>
                                    Descripción visual
                                </div>
                                <div class='col'>
                                    {{$producto->descripcion_visual}}
                                </div>
                                <div class='col-12'>
                                    <hr/>
                                </div>
                            </div>
                            <div class='row'>
                                <div class='col'>
                                    Vida útil
                                </div>
                                <div class='col'>
                                    {{$producto->vida_util}}
                                </div>
                                <div class='col-12'>
                                    <hr/>
                                </div>
                            </div>
                            <div class='row'>
                                <div class='col'>
                                    Solubilidad
                                </div>
                                <div class='col'>
                                    {{$producto->solubilidad}}
                                </div>
                                <div class='col-12'>
                                    <hr/>
                                </div>
                            </div>
                            <div class='row'>
                                <div class='col'>
                                        Inflamabilidad
                                </div>
                                <div class='col'>
                                    {{$producto->inflamabilidad}}
                                </div>
                                <div class='col-12'>
                                    <hr/>
                                </div>
                            </div>
                            <div class='row'>
                                <div class='col'>
                                        Proceso
                                </div>
                                <div class='col'>
                                    {{$producto->proceso}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach


            @if (count($ingredientes_otros) != 0)
            <div class='col-12'>
                <h5>
                    Otros productos
                </h5>
            </div>
            @endif
            @foreach ($ingredientes_otros as $ingrediente)
                <div class='col-4 p-4'>

                    <div class='card bg-white p-0'>
                        <div class='productCard card-img-top'>

                        </div>
                        <div class='card-body'>
                            <div class='text-secondary'>
                                <p class='font-weight-bold'>
                                    {{$ingrediente->nombre}}
                                </p>

                                <div class='row'>
                                    <div class='col'>
                                        Numero IPC
                                    </div>
                                    <div class='col'>
                                        {{$ingrediente->ipc}}
                                    </div>
                                    <div class='col-12'>
                                        <hr/>
                                    </div>
                                </div>
                                <div class='row'>
                                    <div class='col'>
                                        Numero TSCA_CAS
                                    </div>
                                    <div class='col'>
                                        {{$ingrediente->tsca_cas}}
                                    </div>
                                    <div class='col-12'>
                                        <hr/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            <div class='col-12 mt-5'>
                <h5>
                    Condiciones de pago
                </h5>
            </div>
            <div class='col-12 my-5'>
            @for ($i = 0; $i < count($condiciones_pago); $i++)
                <div class='row text-secondary'>
                    <div class='tipoPago col'>
                        @if ($condiciones_pago[$i]->cantidad_cuotas != null)
                            @if ($i == 0)
                                {{$condiciones_pago[$i]->tipo}}
                            @else
                                @if ($condiciones_pago[$i]->cod_cond_pago != $condiciones_pago[$i - 1]->cod_cond_pago)
                                    {{$condiciones_pago[$i]->tipo}}
                                @endif
                            @endif
                        @else
                            {{$condiciones_pago[$i]->tipo}}
                        @endif
                    </div>
                    <div class='cantCuotas col'>
                        @if ($condiciones_pago[$i]->cantidad_cuotas != null)
                            @if ($i == 0)
                                {{$condiciones_pago[$i]->cantidad_cuotas}}
                            @else
                                @if ($condiciones_pago[$i]->cod_cond_pago != $condiciones_pago[$i - 1]->cod_cond_pago)
                                    {{$condiciones_pago[$i]->cantidad_cuotas}}
                                @endif
                            @endif
                        @else
                            1
                        @endif
                    </div>
                    <div class='porcentajeCuotas col'>
                        @if ($condiciones_pago[$i]->cantidad_cuotas != null)

                                <p class='font-weight-bold mb-0'>
                                    Pago {{$i + 1}}:
                                </p>
                                    {{$condiciones_pago[$i]->pago_porcentajes}} %
                                <p class='font-weight-bold mb-0'>
                                    Recargo:
                                </p>
                                {{$condiciones_pago[$i]->porcentaje_recargo}} %
                                <p class='font-weight-bold mb-0'>
                                    Descuento:
                                </p>
                                {{$condiciones_pago[$i]->porcentaje_descuento}} %
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
            @endfor
            </div>
            <div class='col-12 my-4'>
                <h5>
                    Condiciones de envio
                </h5>
            </div>
            <div class='col-12 mb-5'>
            @foreach ($condiciones_envio as $condicion_envio)
                <div class='row text-secondary'>
                    <div class='col'>
                        {{$condicion_envio->envio_pais}}
                    </div>
                    <div class='col'>
                        {{$condicion_envio->envio_transporte}}
                    </div>
                    <div class='col'>
                        {{$condicion_envio->envio_costo}}
                    </div>
                    <div class='col-12'>
                        <hr/>
                    </div>
                </div>
            @endforeach
        </div>
        <div class='col-12 mb-5'>
            <h5>
                Información
            </h5>
            <p class='text-secondary'>
                Este contrato tendra vigencia de un año desde el momento de su generación.
            </p>
            <p class='text-secondary font-weight-bold'>
                Fecha finalización: {{date('Y-m-d',strtotime($contrato->fecha.'+1 year'))}}
            </p>
            <p class='text-secondary'>
                Se debe evaluar esta relación dos meses antes de la culminación del contrato
            </p>
            <p class='text-secondary font-weight-bold'>
                Fecha evaluación: {{ date('d-m-Y',strtotime($contrato->fecha.'+1 year , -2 months'))}}
            </p>
            @if($contrato->exclusividad)
            <p class='text-secondary'>
                Exlusividad
            </p>
            <p class='text-secondary font-weight-bold'>

                    Este contrato es una relación exclusiva entre el productor - proveedor
            </p>
            @endif
        </div>
        <div class='col-12'>
            @if($data_difference = \Carbon\Carbon::now()->diffInDays($contrato->fecha.'+1 year, -2 months', false) < 0)
                <h5>
                    Evaluación Final
                </h5>
                <p class='text-secondary'>
                    Para las proximas preguntas evalue este proveedor en una escala del {{$formula_final->rango_inicial}} al {{$formula_final->rango_final}}.
                </p>
                <form action='/Evaluacion/evaluacion-final/{{$productor->id}}/{{$proveedor->id}}/{{$contrato->codigo}}' method='post' class='row'>
                    <div class='col-12'>
                        @foreach ($variables as $variable)
                            <div class='row mb-3'>
                                <div class='col-4'>
                                    {{$variable->descripcion}}
                                </div>
                                <div class='col-1'>
                                    <input type='text' name='{{$variable->id}}' placeholder='{{$formula_final->rango_inicial}} - {{$formula_final->rango_final}}'/>
                                </div>
                            </div>
                        @endforeach
                        {{ csrf_field() }}
                    </div>
                    <div class='col-6 my-5'>
                        <button type='submit' class="btn btn-info">
                            Evaluar
                        </button>
                    </div>
                </form>
            @endif
        </div>




    </div>

@endsection
