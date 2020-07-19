@extends('master')

@section('title','Fragance System')
@section('pageTitle', 'Evaluación')

@section('content')

    <div class='Evaluacion row justify-content-center align-items-center'>

        @foreach ($productores as $productor)
            <div class='col-7 py-2'>
                <a href='/Evaluacion/{{$productor->id}}' class='text-light'>
                    <button type="button" class="btn btn-info  w-100">
                        {{$productor->nombre}}
                    </button>
                </a>
            </div>
        @endforeach


    </div>

@endsection
