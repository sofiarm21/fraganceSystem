@extends('master')

@section('title','Fragance System')
@section('pageTitle', 'Bienvenidos')

@section('content')

    <div class='Welcome row justify-content-center align-items-center'>
        <div class='col-7 py-2'>
            <a href='/Productor' class='text-light'>
                <button type="button" class="btn btn-info w-100">
                        Productor
                </button>
            </a>
        </div>
        <div class='col-7 py-2'>
            <a href='/' class='text-light'>
                <button type="button" class="btn btn-info  w-100">
                            Comerciante
                </button>
            </a>
        </div>
    </div>

@endsection
