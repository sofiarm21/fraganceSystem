@extends('master')

@section('title','Fragance System')
@section('pageTitle', 'Perfume')

@section('content')
<div class='productCard my-5 row justify-content-center'>
<span class="col 12 border border primary">
  <div class='col-12 text-center font-weight-light text-monospace'>
      <h1 class='my-5'>
          {{$perfume->nombre}}
      </h1>
      <hr/>
      <p class='text text-secondary font-weight-bold'>
          Perfume creado por el productor:
      </p>
      <h4>
          {{$productor->nombre}}
      </h4>
      <hr/>
      <div class='text text-secondary'>

          Perfumista/s:

          @if(count($perfumistas)!=0)
            @foreach ($perfumistas as $perfumista)
              <div class='col-12 font-weight-bold'>
                <p>{{$perfumista->nombre}} {{$perfumista->apellido}}</p>
              </div>
              @endforeach
          @else
          <div class='col-12 font-weight-bold'>
            <p>No se le atribuye este perfume a ningún perfumista</p>
          </div>
          @endif
      </div>
  </div>
    <hr/>
  <div class='my-2 col-2 row ml-2 font-weight-bold'>
    Género:
  <div class='col-2 text-secondary text-capitalize'>
          {{$perfume->genero}}
  </div>
</div>

<div class='my-2 col-2 row ml-2 font-weight-bold'>
  Edad:
<div class='col-2 text-secondary'>
        {{$perfume->edad}}
</div>
</div>

<div class='my-2 col-2 row ml-2 font-weight-bold'>
  Tipo:
<div class='col-2 text-secondary text-capitalize'>
        {{$perfume->tipo}}
</div>
</div>
<hr/>

<div class='my-2 col-12 row ml-2 font-weight-bold'>
  Ingredientes (TSCA_CAS):
<div class='text-secondary text-capitalize'>
        @foreach ($ingredientes as $ingrediente)
        {{($ingrediente->nombre)}} ({{$ingrediente->tsca_cas}}) -
        @endforeach
        .
</div>
</div>
<hr/>
<div class='my-2 col-12 row ml-2 font-weight-bold'>
  Presentaciones:
<div class='ml-1 text-secondary text-capitalize'>
        @foreach ($presentaciones as $presentacion)
        {{(intval($presentacion->volml))}} ml -
        @endforeach
        .
</div>
</div>

<hr/>
@if($perfume->tipo=="f")
<div class='my-2 col-12 row ml-2 font-weight-bold'>
  Notas de Salida:
<div class='text-secondary text-capitalize'>
        @foreach ($notass as $s)
        {{($s->nombre)}} -
        @endforeach
        .
</div>
<div class='my-2 col-12 row font-weight-bold'>
  Notas de Corazón:
<div class='text-secondary text-capitalize'>
        @foreach ($notasc as $c)
        {{($c->nombre)}} -
        @endforeach
        .
</div>
<div class='my-2 col-12 row font-weight-bold'>
  Notas de Fondo:
<div class='text-secondary text-capitalize'>
        @foreach ($notasf as $f)
        {{($f->nombre)}} -
        @endforeach
        .
</div>
</div>
@endif
<hr/>
<hr/>
<hr/>
<hr/>
<hr/>
<hr/>
</span>
</div>


@endsection
