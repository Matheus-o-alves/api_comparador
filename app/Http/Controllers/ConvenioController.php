<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response; // Importe a classe Response

class ConvenioController extends Controller
{
    public function all()
    {
        $response = Response::make(\File::get(storage_path("app/public/simulador/convenios.json")));
        // $response->header('Access-Control-Allow-Origin', '*');
        return $response;
    }
}
