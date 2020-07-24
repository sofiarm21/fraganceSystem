@extends('master')

@section('title','Fragance System')
@section('pageTitle', 'Resultado')

@section('content')

    <div class='EvaluacionResultado row mt-4'>
        <div class='col-3'>
            <h4>
                {{$proveedor->nombre}}
            </h4>
            <h5 class='font-weight-bold'>
                @if ($aprobado)
                    Aprobado
                @else

                    Relación negada
                @endif
            </h5>
                @if ($aprobado)
                    <p class='text-secondary mt-5'>
                        Puede proceder a crear un cotrato con este proveedor
                    </p>
                    <a href='/Evaluacion/generacion-contrato/{{$productor->id}}/{{$proveedor->id}}' class='text-light'>
                        <button type="button" class="btn btn-info mb-4">
                            Proceder a crear un contrato
                        </button>
                    </a>
                    <a href='/Evaluacion/{{$productor->id}}' class='text-light'>
                        <button type="button" class="btn btn-info">
                            Regresar a módulo evaluación
                        </button>
                    </a>
                @else
                    <p class='text-secondary mt-5'>
                        El proveedor no cuenta con los resultados de la evaluación suficientes como para crear un contrato con él
                    </p>
                    <a href='/Evaluacion/{{$productor->id}}' class='text-light'>
                        <button type="button" class="btn btn-info">
                            Regresar a módulo evaluación
                        </button>
                    </a>
                @endif

        </div>


    </div>

@endsection
