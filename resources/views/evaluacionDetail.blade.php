@extends('master')

@section('title','Fragance System')
@section('pageTitle', 'Evaluacion')

@section('content')

    <div class='EvaluacionDetail row mt-4'>
        <div class='col-12'>
            <h3>
                {{$productor->nombre}}
            </h3>
            <h5 class='text text-secondary'>
                Fórmulas
            </h5>
        </div>
        <div class='col-2'>
            @if($escala != null)
                <a href='/Evaluacion/creacion-formula-inicial/{{$productor->id}}' class='text-light'>
                    <button type='button' class='btn btn-info mt-5'>
                        Crear fórmula inicial
                    </button>
                </a>
            @else
                <button type='button' class='btn btn-info mt-5' disabled>
                    Crear fórmula inicial
                </button>
                <p class='text text-warning mt-2'>
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
