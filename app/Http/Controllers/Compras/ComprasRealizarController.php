<?php

namespace App\Http\Controllers\Compras;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use Illuminate\Support\Facades\Log;

use App\Productor;
use App\Proveedor;
use App\Pedido;
use App\Pedido_Detalle;
use App\CondicionPago;


class ComprasRealizarController extends Controller
{

    function getContrato($id_productor, $id_proveedor){
        $contrato = DB::table('sms_contrato')
        ->select('sms_contrato.codigo')
        ->where('sms_contrato.id_proveedor','=',$id_proveedor)
        ->where('sms_contrato.id_productor','=',$id_productor)
        ->where('sms_contrato.motivo_no_renovacion','=',null)
        ->where('sms_contrato.fecha_cancelacion','=',null)
        ->distinct()
        ->get();
        return $contrato[0];
    }

    function getProductosContratados($id_productor, $id_proveedor){
        $productos_contratados= DB::table('sms_contrato')
        ->join('sms_det_contrato','sms_contrato.codigo','=','sms_det_contrato.cod_contrato')
        ->where('sms_contrato.id_proveedor','=',$id_proveedor)
        ->where('sms_contrato.id_productor','=',$id_productor)
        ->join('sms_materia_prima_esencias','sms_det_contrato.cod_mp_esencia','=','sms_materia_prima_esencias.codigo')
        ->join('sms_presentacion_mp','sms_materia_prima_esencias.codigo','=','sms_presentacion_mp.cod_materia_prima')
        ->select(
            'sms_materia_prima_esencias.codigo',
            'sms_materia_prima_esencias.nombre',
            'sms_materia_prima_esencias.nombre_alternativo',
            'sms_materia_prima_esencias.num_ipc',
            'sms_materia_prima_esencias.num_tsca_cas',
            'sms_materia_prima_esencias.num_einecs',
            'sms_materia_prima_esencias.descripcion_visual',
            'sms_materia_prima_esencias.vida_util',
            'sms_materia_prima_esencias.solubilidad',
            'sms_materia_prima_esencias.inflamabilidad',
            'sms_materia_prima_esencias.proceso',
            'sms_presentacion_mp.volml',
            'sms_presentacion_mp.precio',
            'sms_presentacion_mp.otro',
            'sms_presentacion_mp.id AS cod_presentacion',
        )
        ->distinct()
        ->get();

        return ($productos_contratados);
    }


    function getOtrosProductosContratados($id_productor, $id_proveedor){
        $contrato = self::getContrato($id_productor, $id_proveedor);
        $otros_productos_contratados =DB::table('sms_contrato')
        ->join('sms_det_contrato','sms_contrato.codigo','=','sms_det_contrato.cod_contrato')
        ->where('sms_contrato.id_proveedor','=',$id_proveedor)
        ->where('sms_contrato.id_productor','=',$id_productor)
        ->join('sms_componente_ing_otros','sms_det_contrato.cod_componente_ing','=','sms_componente_ing_otros.codigo')
        ->where('sms_det_contrato.cod_contrato','=',$contrato->codigo)
        ->join('sms_presentacion_mp','sms_componente_ing_otros.codigo','=','sms_presentacion_mp.cod_componente_ing')
        ->select(
            'sms_componente_ing_otros.nombre',
            'sms_componente_ing_otros.tsca_cas',
            'sms_componente_ing_otros.ipc',
            'sms_presentacion_mp.volml',
            'sms_presentacion_mp.precio',
            'sms_presentacion_mp.otro',
            'sms_presentacion_mp.id AS cod_presentacion',
        )
        ->distinct()
        ->get();

        return $otros_productos_contratados;
    }

    function getCondicionesPago($id_productor, $id_proveedor){
        $condiciones_pago= DB::table('sms_contrato')
        ->join('sms_c_p','sms_contrato.codigo','=','sms_c_p.cod_contrato')
        ->where('sms_contrato.id_proveedor','=',$id_proveedor)
        ->where('sms_contrato.id_productor','=',$id_productor)
        ->join('sms_condicion_pago','sms_c_p.cod_cond_pago','=','sms_condicion_pago.codigo')
        ->where('sms_c_p.id_proveedor_contrato','=',$id_proveedor)
        ->where('sms_c_p.id_productor_contrato','=',$id_productor)
        ->leftJoin('sms_cuotas','sms_condicion_pago.codigo','=','sms_cuotas.cod_cond_pago')
        ->where('sms_c_p.id_proveedor_contrato','=',$id_proveedor)
        ->select(
            'sms_condicion_pago.tipo',
            'sms_condicion_pago.cantidad_cuotas',
            'sms_condicion_pago.codigo',
            'sms_cuotas.porcentaje_pago',
            'sms_cuotas.tiempo_para_pago AS pago_dias',
            'sms_cuotas.porcentaje_recargo',
            'sms_cuotas.porcentaje_descuento',
            'sms_cuotas.cod_cond_pago',

        )
        ->get();

        return ($condiciones_pago);
    }


    function getCondicionesEnvio($id_productor, $id_proveedor){
        $condicionesEnvio = DB::table('sms_contrato')
        ->join('sms_c_e','sms_contrato.codigo','=','sms_c_e.cod_contrato')
        ->where('sms_contrato.id_proveedor','=',$id_proveedor)
        ->where('sms_contrato.id_productor','=',$id_productor)
        ->join('sms_envio','sms_c_e.cod_pais_envio','=','sms_envio.cod_pais')
        ->join('sms_paises','sms_envio.cod_pais','=','sms_paises.codigo')
        ->where('sms_envio.id_proveedor','=',$id_proveedor)
        ->where('sms_envio.id_proveedor','=',$id_proveedor)
        ->select(
            'sms_envio.tipo_transporte AS envio_transporte',
            'sms_envio.costo AS envio_costo',
            'sms_envio.cod_pais',
            'sms_paises.nombre AS envio_pais'
        )
        ->distinct()
        ->get();

        return ($condicionesEnvio);
    }


    function getIngredientePedido($id_presentacion){

        $ingrediente_pedido = DB::table('sms_presentacion_mp')
        ->join('sms_materia_prima_esencias','sms_presentacion_mp.cod_materia_prima','=','sms_materia_prima_esencias.codigo')
        ->where('sms_presentacion_mp.id','=',$id_presentacion)
        ->select(
            'precio',
            'nombre'
            )
        ->distinct()
        ->get();

        if (count($ingrediente_pedido) == 0){

            $ingrediente_pedido = DB::table('sms_presentacion_mp')
            ->join('sms_componente_ing_otros','sms_presentacion_mp.cod_componente_ing','=','sms_componente_ing_otros.codigo')
            ->where('sms_presentacion_mp.id','=',$id_presentacion)
            ->select(
                'precio',
                'nombre'
                )
            ->distinct()
            ->get();
        }


        return($ingrediente_pedido[0]);



    }

    function getCondicionEnvioPedido($cod_pais, $id_proveedor, $tipo_envio){
        $condicion_envio =  DB::table('sms_envio')
        ->join('sms_paises','sms_envio.cod_pais','=','sms_paises.codigo')
        ->where('sms_envio.id_proveedor','=',$id_proveedor)
        ->where('sms_envio.cod_pais','=',$cod_pais)
        ->where('sms_envio.tipo_transporte','=',$tipo_envio)
        ->select(
            'sms_envio.id_proveedor',
            'sms_envio.cod_pais',
            'sms_envio.id_proveedor',
            'sms_envio.costo',
            'sms_envio.tipo_transporte',
            'sms_paises.nombre'
            )
        ->distinct()
        ->get();
        return($condicion_envio[0]);
    }

    function getCondicionPago($cod_cond_pago){
        $condicion_pago =  DB::table('sms_condicion_pago')
        ->leftJoin('sms_cuotas','sms_condicion_pago.codigo','=','sms_cuotas.cod_cond_pago')
        ->where('sms_condicion_pago.codigo','=',$cod_cond_pago)
        ->select(
            'sms_condicion_pago.cantidad_cuotas',
            'sms_condicion_pago.tipo',
            'sms_condicion_pago.descripcion',
            'sms_cuotas.porcentaje_pago',
            'sms_cuotas.tiempo_para_pago',
            'sms_cuotas.porcentaje_descuento',
            'sms_cuotas.porcentaje_recargo',
            'sms_cuotas.cod_cond_pago'
            )
        ->distinct()
        ->get();

        return $condicion_pago;
    }




    public function createProductos($id_productor, $id_proveedor, Request $request){

        $productor = Productor::findOrFail($id_productor);
        $proveedor = Proveedor::findOrFail($id_proveedor);
        $contrato = self::getContrato($id_productor, $id_proveedor);


        $pedido = new Pedido();
        $pedido->id_proveedor = $id_proveedor;
        $pedido->id_productor = $id_productor;
        $pedido->cod_contrato_c_p = $contrato->codigo;
        $pedido->id_proveedor_c_p = $id_proveedor;
        $pedido->id_productor_c_p = $id_productor;
        $pedido->cod_contrato_c_e = $contrato->codigo;
        $pedido->id_proveedor_c_e_contrato = $id_proveedor;
        $pedido->id_productor_c_e_contrato = $id_productor;
        $pedido->id_proveedor_c_e_envio = $id_proveedor;
        $pedido->fecha_creacion = date('Y-m-d');

        $detalles_pedido = [];
        $productos_contratados = self::getProductosContratados($id_productor, $id_proveedor);


        //verificar que las cantidades no sean 0
        for ($i = 0; $i < count($request->producto); $i++){
            if ($request->producto[$i] < 0) {
                return redirect()->action(
                    'Compras\ComprasRealizarController@view',
                    [
                        'id_productor'=>$id_productor,
                        'id_proveedor'=>$id_proveedor

                    ]
                );
            }
            $i = $i + 1;
        }

        if($request->producto_otro != null){
            for ($i = 0; $i < count($request->producto_otro); $i++){
                if ($request->producto_otro[$i] < 0) {
                    return redirect()->action(
                        'Compras\ComprasRealizarController@view',
                        [
                            'id_productor'=>$id_productor,
                            'id_proveedor'=>$id_proveedor

                        ]
                    );
                }
                $i = $i + 1;
            }
        }


        for ($i = 0; $i < count($request->producto); $i++){
            if ($request->producto[$i] != (null || 0) ){
                $det_pedido = new Pedido_Detalle();
                $det_pedido->cantidad = $request->producto[$i];
                $det_pedido->id_presentacion_mp = intval($request->producto[$i + 1]);
                array_push($detalles_pedido, $det_pedido);

            }
            $i = $i + 1;
        }

        if($request->producto_otro != null){
            for ($i = 0; $i < count($request->producto_otro); $i++){
                if ($request->producto_otro[$i] != (null || 0)){
                    $det_pedido = new Pedido_Detalle();
                    $det_pedido->cantidad = $request->producto_otro[$i];
                    $det_pedido->id_presentacion_mp = intval($request->producto_otro[$i + 1]);
                    array_push($detalles_pedido, $det_pedido);
                }
                $i = $i + 1;
            }
        }

        $request->session()->put('detalles_pedido', $detalles_pedido);
        $request->session()->put('pedido', $pedido);


        return self::viewEnvio($productor, $proveedor, $request);

    }


    public function view($id_productor, $id_proveedor){

        $productor = Productor::findOrFail($id_productor);
        $proveedor = Proveedor::findOrFail($id_proveedor);

        $productos_contratados = self::getProductosContratados($id_productor, $id_proveedor);
        $otros_productos_contratados = self::getOtrosProductosContratados($id_productor, $id_proveedor);
        $condiciones_envio = self::getCondicionesEnvio($id_productor, $id_proveedor);

        return view('compras/comprasRealizar', [
            'proveedor' => $proveedor,
            'productor' => $productor,
            'productos' => $productos_contratados,
            'ingredientes_otros' => $otros_productos_contratados,
            'condiciones_envio' => $condiciones_envio
        ]);

    }

    public function createEnvio($id_productor, $id_proveedor, $cod_pais_envio, $tipo_envio, Request $request){

        $productor = Productor::findOrFail($id_productor);
        $proveedor = Proveedor::findOrFail($id_proveedor);

        $request->session()->put('cod_pais_envio', $cod_pais_envio);
        $request->session()->put('tipo_envio', $tipo_envio);
        $pedido = $request->session()->get('pedido');

        $pedido->cod_pais_c_e = $cod_pais_envio;

        return self::viewResumen($productor, $proveedor, $request);

    }

    public function viewEnvio($productor, $proveedor, Request $request){

        $condiciones_envio = self::getCondicionesEnvio($productor->id, $proveedor->id);

        $detalles_pedido = $request->session()->get('detalles_pedido');
        $pedido = $request->session()->get('pedido');

        return view('compras/comprasRealizarEnvio', [
            'proveedor' => $proveedor,
            'productor' => $productor,
            'pedido' => $pedido,
            'condiciones_envio' => $condiciones_envio
        ]);

    }


    public function viewResumen($productor, $proveedor, $request){


        $detalles_pedido = $request->session()->get('detalles_pedido');
        $pedido = $request->session()->get('pedido');
        $cod_pais_envio = $request->session()->get('cod_pais_envio');
        $tipo_envio = $request->session()->get('tipo_envio');

        $monto_total = 0;
        $montos = [];
        $ingredientes_pedidos = [];
        $envio = self::getCondicionEnvioPedido($cod_pais_envio,$proveedor->id,$tipo_envio);


        foreach($detalles_pedido as $detalle){
            array_push($ingredientes_pedidos, self::getIngredientePedido($detalle->id_presentacion_mp));
            array_push($montos, self::getIngredientePedido($detalle->id_presentacion_mp)->precio * $detalle->cantidad);
            $monto_total += self::getIngredientePedido($detalle->id_presentacion_mp)->precio * $detalle->cantidad;
        }


        $pedido->total = $monto_total + $envio->costo;


        $request->session()->put('envio',$envio);
        $request->session()->put('ingredientes_pedidos', $ingredientes_pedidos);
        $request->session()->put('monto_total',$monto_total);


        return view('compras/comprasResumen', [
            'proveedor' => $proveedor,
            'productor' => $productor,
            'det_pedido' => $detalles_pedido,
            'montos' => $montos,
            'monto_total' => $monto_total,
            'ingredientes_pedidos' => $ingredientes_pedidos,
            'envio'=>$envio
        ]);
    }

    public function metodoPagoCreate($id_productor, $id_proveedor, $cod_cond_pago, Request $request){

        $productor = Productor::findOrFail($id_productor);
        $proveedor = Proveedor::findOrFail($id_proveedor);
        $condicion_pago = CondicionPago::findOrFail($cod_cond_pago);
        $condicion_pago = self::getCondicionPago($cod_cond_pago);

        $detalles_pedido = $request->session()->get('detalles_pedido');
        $pedido = $request->session()->get('pedido');
        $cod_pais_envio = $request->session()->get('cod_pais_envio');
        $tipo_envio = $request->session()->get('tipo_envio');
        $ingredientes_pedidos = $request->session()->get('ingredientes_pedidos');
        $envio = $request->session()->get('envio');
        $monto_total = $request->session()->get('monto_total');

        $pedido->cod_cond_pago_c_p = $cod_cond_pago;

        return view('compras/comprasConfirmar', [
            'proveedor' => $proveedor,
            'productor' => $productor,
            'pedido' => $pedido,
            'det_pedido' => $detalles_pedido,
            'ingredientes_pedidos' => $ingredientes_pedidos,
            'envio'=>$envio,
            'metodos_pago' => $condicion_pago,
            'monto_total' => $monto_total
        ]);

    }

    public function metodoPagoView($id_productor, $id_proveedor, Request $request){

        $productor = Productor::findOrFail($id_productor);
        $proveedor = Proveedor::findOrFail($id_proveedor);
        $metodos_pago = self::getCondicionesPago($id_productor, $id_proveedor);
        $pedido = $request->session()->get('pedido');
        $detalles_pedido = $request->session()->get('detalles_pedido');

        $monto_total = 0;
        $ingredientes_pedidos = [];
        $montos=[];

        foreach($detalles_pedido as $detalle){
            array_push($ingredientes_pedidos, self::getIngredientePedido($detalle->id_presentacion_mp));
            array_push($montos, self::getIngredientePedido($detalle->id_presentacion_mp)->precio * $detalle->cantidad);
            $monto_total += self::getIngredientePedido($detalle->id_presentacion_mp)->precio * $detalle->cantidad;
        }

        foreach($metodos_pago AS $metodo){
            $pedido->total += $pedido->total * ($metodo->porcentaje_recargo / 100);
            $pedido->total -= $pedido->total * ($metodo->porcentaje_descuento / 100);
        }

        //$pedido->total = $monto_total + $envio->costo;


        return view('compras/comprasPago', [
            'proveedor' => $proveedor,
            'productor' => $productor,
            'metodos_pago' => $metodos_pago,
            'monto_total' => $monto_total,
            'pedido' => $pedido
        ]);

    }

    public function pedidoCreate($id_productor, $id_proveedor, Request $request){
        $productor = Productor::findOrFail($id_productor);
        $proveedor = Proveedor::findOrFail($id_proveedor);
        $pedido = $request->session()->get('pedido');
        $detalles_pedido = $request->session()->get('detalles_pedido');


        $pedido->estado = 1;


        // echo "id_proveedor ";
        // var_dump($pedido->id_proveedor);
        // echo "id_productor ";
        // var_dump($pedido->id_productor);
        // echo "cod_contrato_c_p ";
        // var_dump($pedido->cod_contrato_c_p);
        // echo "id_proveedor_c_p ";
        // var_dump($pedido->id_proveedor_c_p);
        // echo "id_productor_c_p ";
        // var_dump($pedido->id_productor_c_p);
        // echo "cod_cond_pago_c_p ";
        // var_dump($pedido->cod_cond_pago_c_p);
        // echo "cod_contrato_c_e ";
        // var_dump($pedido->cod_contrato_c_e);
        // echo "id_proveedor_c_e_contrato ";
        // var_dump($pedido->id_proveedor_c_e_contrato);
        // echo "id_productor_c_e_contrato ";
        // var_dump($pedido->id_productor_c_e_contrato);
        // echo "cod_pais_c_e ";
        // var_dump($pedido->cod_pais_c_e);
        // echo "id_proveedor_c_e_envio ";
        // var_dump($pedido->id_proveedor_c_e_envio);
        // echo "fecha_creacion ";
        // var_dump($pedido->fecha_creacion);
        // echo "total ";
        // var_dump($pedido->total);

        $pedido->save();

        foreach ($detalles_pedido as $detalle){
            $detalle->cod_pedido = $pedido->codigo;
            $detalle->save();
        }

        return redirect()->action(
            'Compras\ComprasMenuController@view',
            ['id'=>$id_productor]
        );





    }




}
