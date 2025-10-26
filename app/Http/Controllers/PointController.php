<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PointRequest;
use App\Models\Point;
use Illuminate\Support\Facades\Redis;

class PointController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }


    // GET /points?tipo=accidente&lat=..&long=..&radius=10
    public function index(Request $request)
    {
        $query = Point::with('user');
        //Filtro por tipo
        if ($request->filled('tipo')) {
            $query->where('tipo', $request->query('tipo'));
        }
        //Filtro por proximidad usando fórmula de Haversine
        if ($request->filled('lat') && $request->filled('long') && $request->filled('radius')) {
            $lat = (float) $request->query('lat');
            $lng = (float) $request->query('long');
            $radius = (float) $request->query('radius'); // en kilómetros

            //Validación rápida de rango
            if ($lat < -90 || $lat > 90 || $lng < -180 || $lng > 180) {
                return response()->json(['message' => 'Valores inválidos de latitud o longitud'], 400);
            }

            //Fórmula de Haversine (añade distancia en km)
            $haversine = "(6371 * acos( cos(radians(?)) * cos(radians(latitud)) * cos(radians(longitud) - radians(?)) + sin(radians(?)) * sin(radians(latitud)) ))";

            $query->selectRaw('points.*, ' . $haversine . ' AS distancia_km', [$lat, $lng, $lat])
                ->having('distancia_km', '<=', $radius)
                ->orderBy('distancia_km');
        }
        $points = $query->paginate(25);
        //Mensaje de respuesta si no se encontraron resultados
        if ($points->isEmpty()) {
            return response()->json([
                'message' => 'No se encontraron resultados con los filtros aplicados.',
                'data' => []
            ], 404);
        }

        return response()->json($points);
    }


    public function show($id)
    {
        $point = Point::with('user')->find($id);
        if (!$point) return response()->json(['message' => 'Point no encontrado'], 404);
        return response()->json($point);
    }

    public function store(PointRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth('api')->id();
        $point = Point::create($data);
        return response()->json($point, 201);
    }
    public function update(PointRequest $request, $id)
    {
        $point = Point::find($id);
        if (! $point) return response()->json(['message' => 'Point no encontrado'], 404);
        // Ownership check
        if ($point->user_id !== auth('api')->id()) {
            return response()->json(['message' => 'Denegado: No eres el creador'], 403);
        }
        $point->update($request->validated());
        return response()->json($point);
    }
    public function destroy($id)
    {
        $point = Point::find($id);
        if (! $point) return response()->json(['message' => 'Point no encontrado'], 404);
        if ($point->user_id !== auth('api')->id()) {
            return response()->json(['message' => 'Denegado: tu no eres el creador'], 403);
        }
        $point->delete();
        return response()->json(['message' => 'Point eliminado']);
    }
}
