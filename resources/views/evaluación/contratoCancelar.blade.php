@extends('master')

@section('title','Fragance System')
@section('pageTitle', 'Cancelar contrato')

@section('content')

    <div class='contratoCancelar row mt-4'>
        <div class='col-12'>
            <h4>
                Cancelar contrato
            </h4>
            <h5>
                Productor: {{$productor->nombre}}
                <br/>
                Proveedor: {{$proveedor->nombre}}
            </h5>
            <p class='text-secondary'>
                Por favor especifique por que quiere cancelar este contrato
            </p>
            <form action='/Evaluacion/contrato/cancelar-contrato/{{$productor->id}}/{{$proveedor->id}}/{{$contrato->codigo}}' method='post'>
            <textarea class="form-control" name='motivo' rows="5"></textarea>
                    {{ csrf_field() }}
                    <button  type='submit' class='btn btn-info mt-5'>
                        Cancelar contrato
                    </button>
            </form>
        </div>

    </div>

@endsection
