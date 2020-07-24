@extends('master')

@section('title','Fragance System')
@section('pageTitle', 'Compras')

@section('content')

    <div class='Compras row justify-content-center'>

            @foreach ($productores as $productor)
                <div class='col-7 py-2'>
                    <a href='/Compras/menu/{{$productor->id}}' class='text-light'>
                        <button type="button" class="btn btn-info  w-100">
                            {{$productor->nombre}}
                        </button>
                    </a>
                </div>
            @endforeach

    </div>

@endsection
