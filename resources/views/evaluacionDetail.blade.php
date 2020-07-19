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
        <div class='col-3'>
            <a href='/Evaluacion/creacion-formula-inicial/{{$productor->id}}' class='text-light'>
                <button type='button' class='btn btn-info mt-5'>
                    Crear fórmula inicial
                </button>
            </a>
        </div>
    </div>

@endsection
