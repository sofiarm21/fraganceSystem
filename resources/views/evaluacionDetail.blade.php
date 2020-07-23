@extends('master')

@section('title','Fragance System')
@section('pageTitle', 'Evaluación')

@section('content')

    <div class='EvaluacionDetail row mt-4'>
        <div class='col-12'>
            <h3>
                {{$productor->nombre}}
            </h3>

        </div>
        <div class='col-12 my-5'>
            <h5 class='text text-secondary'>
                Contratos
            </h5>
            @if(count($formula_inicial) >= 1)
                <a href='/Evaluacion/registro-proveedor/{{$productor->id}}' class='text-light'>
                    <button type='button' class='btn btn-info mt-5'>
                        Registrar nuevo proveedor
                    </button>
                </a>
            @else
                <button type='button' class='btn btn-info mt-5' disabled>
                    Registrar nuevo proveedor
                </button>
                <p class='text text-danger mt-2'>
                    Para registrar un nuevo proveedor debe tener una formula de evaluación inicial creada
                </p>
            @endif

            <div class='row mt-5'>

                @foreach ($contratos as $contrato)

                <div class="card col-3 mx-2 bg-white" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">{{$contrato->nombre}}</h5>
                        <h6 class="card-subtitle mb-2 text-muted">Contrato</h6>
                        <p class="card-text">Fecha de creación <br/> {{$contrato->fecha}}</p>
                        <p class="card-text">Fecha de finalización <br/> {{ date('Y-m-d',strtotime($contrato->fecha.'+1 year'))}}</p>
                        <p class="card-text">{{$contrato->codigo}}</p>
                        <a href='/Evaluacion/detalle-contrato/{{$productor->id}}/{{$contrato->id_proveedor}}/{{$contrato->codigo}}' class="card-link">Detalle</a>
                    </div>
                </div>

                @endforeach

            </div>

        </div>
        <div class='col-12 mt-5'>
            <h5 class='text text-secondary'>
                Fórmulas
            </h5>
        </div>
        <div class='col-2'>
            @if(count($escala) >= 1)
                <a href='/Evaluacion/creacion-formula-inicial/{{$productor->id}}' class='text-light'>
                    <button type='button' class='btn btn-info mt-5'>
                        Crear fórmula inicial
                    </button>
                </a>
            @else
                <button type='button' class='btn btn-info mt-5' disabled>
                    Crear fórmula inicial
                </button>
                <p class='text text-danger mt-2'>
                    Para crear una formula inicial debe haber creado una escala de evaluación
                </p>
            @endif

        </div>
        <div class='col-3'>
            <a href='/Evaluacion/creacion-escala/{{$productor->id}}' class='text-light'>
                <button type='button' class='btn btn-info mt-5'>
                    Crear nueva escala
                </button>
            </a>
        </div>
    </div>

@endsection
