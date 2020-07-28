@extends('master')

@section('title','Fragance System')
@section('pageTitle', 'Resultado Evaluación Final')

@section('content')

    <div class='EvaluacionResultado row mt-4'>
        <div class='col-3'>
            <h4>
                {{$proveedor->nombre}}
            </h4>
            Resultado: {{$resultado}}
            <h5 class='font-weight-bold'>
                @if ($aprobado)
                    Aprobado
                @else
                    No se puede renovar este contrato
                @endif
            </h5>
                @if ($aprobado)
                    <p class='text-secondary mt-5'>
                        Puede renovar este contrato
                    </p>
                    <div class='row'>
                        <div class='col-12'>
                    <a href='/Evaluacion/formula-final/renovar/{{$productor->id}}/{{$proveedor->id}}/{{$cod_contrato}}' class='text-light'>
                        <button type="button" class="btn btn-info mb-4">
                            Renovar contrato
                        </button>
                    </a>
                    <a href='/Evaluacion/{{$productor->id}}' class='text-light'>
                        <button type="button" class="btn btn-info mb-4">
                            No renovar
                        </button>
                    </a>
                    

                @else
                    <p class='text-secondary mt-5'>
                        El proveedor no cuenta con los resultados de la evaluación suficientes como para renovar un contrato con él
                    </p>
                    <a href='/Evaluacion/{{$productor->id}}' class='text-light'>
                        <button type="button" class="btn btn-info">
                            Regresar a módulo evaluación
                        </button>
                    </a>
                </div>
                    </div>
                @endif

        </div>


    </div>

@endsection
