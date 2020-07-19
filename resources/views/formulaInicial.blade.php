@extends('master')

@section('title','Fragance System')
@section('pageTitle', 'Creación fórmula inicial')

@section('content')

    <div class='EvaluacionInicial row justify-content-center mt-4'>
        <div class='col-12'>
            <h3 class='mb-3'>
                {{$productor->nombre}}
            </h3>
            <h5 class='text text-secondary'>
                Creación fórmula inicial
            </h5>
            <p class='text text-secondary'>
                Eliga las variables que quiere evaluar y asigneles un porcentaje segun su importancia. La suma de los porcentasjes debe sumar 100%
            </p>


            <div class="form-group my-5">
                <form name="add_name" id="add_name">

                        @foreach ($variables as $variable)
                            <div class='row my-2'>
                                <div class='col-2'>
                                    {{$variable->nombre}}
                                </div>
                                <div class='col-6 text-secondary'>
                                     <input type='text' name='autor' placeholder='Porcentaje'/>
                                     %
                                </div>
                            </div>

                        @endforeach
                        {{ csrf_field() }}
                        <div class='mt-5 col-3'>
                            <button type='submit' class="btn btn-info  w-100">
                                Crear fórmula
                            </button>
                        </div>
                    </div>

                </form>

            </div>


        </div>
    </div>





@endsection
