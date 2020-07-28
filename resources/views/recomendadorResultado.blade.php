@extends('master')

@section('title','Fragance System')
@section('pageTitle', 'Recomendador')

@section('content')
<img class="my-5 mx-auto d-block" src="assets/images/recom.jpg" class="rounded-lg">
<div class='productCard row justify-content-center'>
<span class="col 12 border border primary">
  <div class='col-12 py-5 text-center font-weight-light text-monospace'>
      <h3 class='my-5'>
          RESULTADO
      </h3>
      <p class='text text-secondary font-weight-bold'>
          ¡El recomendador dió con los siguientes resultados en la búsqueda de su perfume ideal! <br>
          Con una compatibilidad de {{number_format($mayor*100/$max_resultado, 2, '.', ',')}}%, se tiene:
      </p>
      @if ($mayor == 0)
          <p class='text text-warning'>
              Lamentablemente, no hay perfumes compatibles con su búsqueda. <br>
          </p>
      @else
          @foreach ($perfumes as $perfume)
          @if ($perfume->puntaje == $mayor)
          <div class='col-8 p-4'>
              <div class='card bg-white p-0 '>
                  <div class='productCard card-img-top text-center'>

                  </div>
                  <div class='card-body'>
                      <div class='text-secondary'>
                          <p class='font-weight-bold'>
                              ✓ {{$perfume->nombre}}
                          </p>
                          <a href='/Perfume/{{$perfume->codigo}}' class='text-light'>
                              <button type='button' class='btn btn-info'>
                                  Ver Detalles
                              </button>
                          </a>
                      </div>
                  </div>
              </div>
          </div>
          @endif
          @endforeach
      @endif

  </div>



</border>
</span>
</div>

@endsection
