@extends('master')

@section('title','Fragance System')
@section('pageTitle', 'Recomendador')

@section('content')

      <img class="my-5 mx-auto d-block" src="assets/images/recom.jpg" class="rounded-lg">
    <div class='productCard row justify-content-center'>
    <span class="col 12 border border primary">
        <div class='col-12 py-5 text-center font-weight-light text-monospace'>
            <h3 class='my-5'>
                Recomendador de Perfumes
            </h3>
            <p class='text text-secondary'>
                Seleccione los filtros deseados del siguiente formulario para obtener su perfume ideal.
            </p>
            @if ($resultMessage != null)
                <p class='text text-warning'>
                    {{$resultMessage}}
                </p>
            @endif
        </div>

        <div class="col-12 form-group my-1">
            <hr/>
            <form class='px-md-5 y-5' action='/Recomendador/resultado' method='post' class="row bg-white">
                    <div class='text-right row'>
                        <div class='px-md-5 col-5 p-4'>
                            Género:
                        </div>
                        <div class='p-4 text-secondary l-2'>
                          <select name="genero" id="genero">
                            <option selected value="N">Sin definir</option>
                            <option value="f">Femenino</option>
                            <option value="m">Másculino</option>
                            <option value="u">Unisex</option>
                          </select>
                        </div>
                    </div>
                    <hr/>

                    <div class='text-right row'>
                        <div class='px-md-5 col-5 p-4'>
                            Edad:
                        </div>
                        <div class='p-4 text-secondary l-2'>
                          <select name="edad" id="edad">
                            <option selected value="N">Sin definir</option>
                            <option value="atemporal">Atemporal</option>
                            <option value="joven">Juvenil</option>
                            <option value="adulto">Adulto</option>
                            <option value="infantil">Infantil</option>
                          </select>
                        </div>
                    </div>
                    <hr/>

                    <div class='text-right row'>
                        <div class='px-md-5 col-5 p-4'>
                            Intensidad:
                        </div>
                        <div class='p-4 text-secondary l-2'>
                          <select name="intensidad" id="intensidad">
                            <option selected value="0">Sin definir</option>
                            <option value="1">Ligero/fresco</option>
                            <option value="2">Intermedio</option>
                            <option value="3">Intenso</option>
                          </select>
                        </div>
                    </div>
                    <hr/>


                    <div class='text-right row'>
                        <div class='px-md-5 col-5 p-4'>
                            Uso:
                        </div>
                        <div class='p-4 text-secondary l-2'>
                          <select name="uso" id="uso">
                            <option selected value="0">Sin definir</option>
                            <option value="1">Diario</option>
                            <option value="2">Trabajo</option>
                            <option value="3">Ocasiones Especiales</option>
                          </select>
                        </div>
                    </div>
                    <hr/>



                    <div class='col-12 ml-2'>
                      Familias Olfativas del Perfume:
                    </div>
                    <div class='col-12 ml-2 my-3'>
                        @foreach ($familias_olfativas as $familia_olfativa)
                        <input class="form-check-input" type="checkbox" name='familia_codigo[]' id='{{$familia_olfativa->codigo}}' value='{{$familia_olfativa->codigo}}'/>
                        <div class='bg-white'>
                                <div class='text-secondary text-capitalize'>
                                    <p>
                                        {{$familia_olfativa->nombre}}
                                    </p>
                                </div>
                        </div>
                      @endforeach
                    </div>
                    <hr/>

                    <div class='col-12 ml-2'>
                      Carácter del Perfume:
                    </div>
                    <div class='col-12 ml-2 my-3'>
                        @foreach ($caracteres as $caracter)
                        <input class="form-check-input" type="checkbox" name='caracter_id[]' id='{{$caracter->id}}' value='{{$caracter->id}}'/>
                        <div class='bg-white'>
                                <div class='text-secondary text-capitalize'>
                                    <p>
                                        {{$caracter->palabra}}
                                    </p>
                                </div>
                        </div>
                      @endforeach
                    </div>
                    <hr/>

                    <div class='col-12'>
                      Aromas del perfume:
                    </div>
                    <div class='col-5 my-3'>
                        @foreach ($aromas as $aroma)
                        <input class="form-check-input" type="checkbox" name='aroma_codigo[]' id='{{$aroma->id}}' value='{{$aroma->id}}'/>
                        <div class='bg-white'>
                                <div class='text-secondary text-capitalize'>
                                    <p>
                                        {{$aroma->palabra}}
                                    </p>
                                </div>
                        </div>
                      @endforeach
                    </div>
                    <hr/>

                    <div class='col-12'>
                      Personalidad:
                    </div>
                    <div class='col-5 my-3'>
                        @foreach ($personalidades as $personalidad)
                        <input class="form-check-input" type="checkbox" name='personalidad_codigo[]' id='{{$personalidad->id}}' value='{{$personalidad->id}}'/>
                        <div class='bg-white'>
                                <div class='text-secondary text-capitalize'>
                                    <p>
                                        {{$personalidad->palabra}}
                                    </p>
                                </div>
                        </div>
                      @endforeach
                    </div>
                    <hr/>

                {{ csrf_field() }}
                <div class='px-md-5 mt-5 col-12 text-center'>
                    <button type='submit' class="btn btn-info  w-1000">
                        Buscar Perfume
                    </button>
                </div>
                <hr/>
                <hr/>
                <hr/>

            </form>

        </div>

    </border>
      </span>
    </div>

@endsection
