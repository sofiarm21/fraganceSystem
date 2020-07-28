@extends('master')

@section('title','Fragance System')
@section('pageTitle', 'Creación fórmula final')

@section('content')

    <div class='EvaluacionFinal row justify-content-center mt-4'>
        <div class='col-12'>
            <h3 class='mb-3'>
                {{$productor->nombre}}
            </h3>
            <h5 class='text text-secondary'>
                Creación fórmula final
            </h5>
            <p class='text text-secondary'>
                Eliga las variables que quiere evaluar y asigneles un porcentaje segun su importancia.
            </p>


            <div class="form-group my-5">
                <form action='/Evaluacion/creacion-formula-final/create/{{$productor->id}}' method='post'>

                    @foreach ($variables as $variable)
                        <div class='row my-2'>
                            <div class='col-2'>
                                {{$variable->nombre}}
                            </div>
                            <div class='col-6 text-secondary'>
                                 <input type='text' name='{{$variable->id}}' placeholder='Porcentaje'/>
                                 Peso
                            </div>
                        </div>
                    @endforeach
                    {{ csrf_field() }}
                    <div class='mt-5 col-3'>


                        <button type='submit' class="btn btn-info  w-100">
                            Crear fórmula
                        </button>
                        @if ($errorMessage != null)
                            <p class='text text-warning mt-3'>
                                {{$errorMessage}}
                            </p>
                        @endif
                    </div>

                </form>

            </div>


        </div>
    </div>





@endsection
