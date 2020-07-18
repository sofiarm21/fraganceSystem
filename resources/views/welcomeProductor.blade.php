@extends('master')

@section('title','Fragance System')
@section('pageTitle', 'Bienvenidos productores')

@section('content')

    <div class='Welcomeproductor row justify-content-center align-items-center'>

        @foreach ($productores as $productor)
            <div class='col-7 py-2'>
                <a href='/ProductorCatalogo/{{$productor->id}}' class='text-light'>
                    <button type="button" class="btn btn-info  w-100">
                        {{$productor->nombre}}
                    </button>
                </a>
            </div>
        @endforeach


    </div>

@endsection
