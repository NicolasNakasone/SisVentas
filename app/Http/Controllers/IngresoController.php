<?php

namespace SisVentas\Http\Controllers;

/* 
    TIP
    - Los imports/use de terceros, es decir los ajenos a nuestra aplicacion
    (todo lo que sea laravel, y demas librerias), deben ir primero.
*/

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Collection;

use SisVentas\Ingreso;
use SisVentas\DetalleIngreso;
use SisVentas\Http\Requests\IngresoFormRequest;

class IngresoController extends Controller
{
    public function __construct()
    {
    }
    public function index(Request $request)
    {
        if ($request) {
            $query = trim($request->get('searchText'));
            $ingresos = DB::table('ingreso as i')
                ->join('persona as p', 'i.idproveedor', '=', 'p.idpersona')
                ->join('detalle_ingreso as di', 'i.idingreso', '=', 'di.id_ingreso')
                ->select('i.idingreso', 'i.fecha_hora', 'p.nombre', 'i.tipo_comprobante', 'i.serie_comprobante', 'i.num_comprobante', 'i.impuesto', 'i.estado', DB::raw('sum(di.cantidad*precio_compra) as total'))
                ->where('i.num_comprobante', 'LIKE', '%' . $query . '%')
                ->orderBy('i.idingreso', 'desc')
                ->groupBy('i.idingreso', 'i.fecha_hora', 'p.nombre', 'i.tipo_comprobante', 'i.serie_comprobante', 'i.num_comprobante', 'i.impuesto', 'i.estado')
                ->paginate(5);
            return view('compras.ingreso.index', ["ingresos" => $ingresos, "searchText" => $query]);
        }
    }
    public function create()
    {
        $personas = DB::table('persona')
            ->where('tipo_persona', '=', 'Proveedor')
            ->get();
        $articulos = DB::table('articulo as art')
            ->select(DB::raw('CONCAT(art.codigo," ",art.nombre) AS articulo'), 'art.idarticulo')
            ->where('art.estado', '=', 'Activo')
            ->get();
        return view("compras.ingreso.create", ["personas" => $personas, "articulos" => $articulos]);
    }

    public function store(IngresoFormRequest $request)
    {
        try {
            DB::beginTransaction();
            $mytime = Carbon::now('America/Argentina/Salta');

            $ingreso = new Ingreso([
                'idproveedor' => $request->get('idproveedor'),
                'tipo_comprobante' => $request->get('tipo_comprobante'),
                'serie_comprobante' => $request->get('serie_comprobante'),
                'num_comprobante' => $request->get('num_comprobante'),
                'fecha_hora' => $mytime->toDateTimeString(),
                'impuesto' => '18',
                'estado' => 'A',
            ]);

            $ingreso->save();

            $idarticulo = $request->get('idarticulo');
            $cantidad = $request->get('cantidad');
            $precio_compra = $request->get('precio_compra');
            $precio_venta = $request->get('precio_venta');

            $cont = 0;
            while ($cont < count($idarticulo)) {
                $detalle = new DetalleIngreso();
                $detalle->id_ingreso = $ingreso->idingreso;
                $detalle->id_articulo = $idarticulo[$cont];
                $detalle->cantidad = $cantidad[$cont];
                $detalle->precio_compra = $precio_compra[$cont];
                $detalle->precio_venta = $precio_venta[$cont];
                $detalle->save();
                $cont = $cont + 1;
            }

            DB::commit();

            return Redirect::to('compras/ingreso');

        } catch (\Exception $e) {
            DB::rollback();

            return Redirect::to('compras/ingreso')->withInput();
        }

        
    }
    public function show($id)
    {
        $ingreso = DB::table('ingreso as i')
            ->join('persona as p', 'i.idproveedor', '=', 'p.idpersona')
            ->join('detalle_ingreso as di', 'i.idingreso', '=', 'di.id_ingreso')
            ->select('i.idingreso', 'i.fecha_hora', 'p.nombre', 'i.tipo_comprobante', 'i.serie_comprobante', 'i.num_comprobante', 'i.estado', DB::raw('sum(di.cantidad*precio_compra) as total'))
            ->where('i.idingreso', '=', $id)
            ->first();

        $detalles = DB::table('detalle_ingreso as d')
            ->join('articulo as a', 'd.idarticulo', '=', 'a.idarticulo')
            ->select('a.nombre as articulo', 'd.cantidad', 'd.precio_compra', 'd.precio_venta')
            ->where('d.idingreso', '=', $id)
            ->get();
        return view("compras.ingreso.show", ["ingreso" => $ingreso, "detalles" => $detalles]);
    }
    public function destroy($id)
    {
        $ingreso = Ingreso::findOrFail($id);
        $ingreso->Estado = 'C';
        $ingreso->update();
        return Redirect::to('compras/ingreso');
    }
}
