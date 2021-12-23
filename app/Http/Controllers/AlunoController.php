<?php

namespace App\Http\Controllers;

use App\Models\Aula;
use Illuminate\Http\Request;

class AlunoController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function checkin($id)
    {
        try {
        } catch(\Exception $exception) {
            return $exception->getMessage();
        }
    }

    public function listar(Request $request)
    {
        
        try {
            $aulas = new Aula();
            if ($request->opcaoData) {
                $aulas= $aulas->whereDate(\DB::raw('data_hora::date'),'>', date('Y-m-d'))
                ->whereDate(\DB::raw('data_hora::date'),'<', date('d/m/Y', strtotime('+7 days', strtotime(date('Y-m-d')))));
            } else {
                $aulas= $aulas->whereDate(\DB::raw('data_hora::date'), date('Y-m-d'));
            }
            
            $aulas = $aulas->get();

            return ["total" => $aulas->count(), 'rows' => $aulas ];

        } catch(\Exception $exception) {
            return $exception->getMessage();
        }
    }
}
