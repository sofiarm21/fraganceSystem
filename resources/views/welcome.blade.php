@extends('master')

@section('title','Fragance System')
@section('pageTitle', 'Bienvenidos')

@section('content')

    <div class='row justify-content-center align-items-center'>
        <div class='col-7 py-2'>
            <button type="button" class="btn btn-primary w-100">
                <a href='/Productor' class='text-light'>
                    Productor
                </a>
            </button>
        </div>
        <div class='col-7 py-2'>
            <button type="button" class="btn btn-primary  w-100">
                <a href='/' class='text-light'>
                    Comerciante
                </a>
            </button>
        </div>
    </div>

@endsection
