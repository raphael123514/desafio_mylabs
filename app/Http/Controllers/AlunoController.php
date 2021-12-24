<?php

namespace App\Http\Controllers;

use App\Models\Aula;
use App\Models\Checkin;
use Dflydev\DotAccessData\Data;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class AlunoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function checkin(Request $request)
    {
        try {
            $id= $request->id;
            $checkin = new Checkin;
            $aula = Aula::find($id);
            $data_hora_atual = date('Y-m-d G:i:s');
            $data_maxima_check = date('Y-m-d G:i:s', strtotime('- 30 minute', strtotime($aula->data_hora)));
            $data_minima = date('Y-m-d G:i:s', strtotime('- 24 hour', strtotime($aula->data_hora)));
            $qdte_aluno = ++$aula->qtde_aluno;
            
            if ($qdte_aluno > $aula->qtde_maxima) {
                abort(400, 'Número máximo de alunos foi atingido!');

            }

            if ($data_hora_atual <= $data_maxima_check &&  $data_hora_atual >= $data_minima) {
                $aula->update(['qtde_aluno' => $qdte_aluno]);
    
                $checkin->fill([
                    'user_id' => auth()->user()->id,
                    'aulas_id' => $id,
                ]);
                $checkin->save();
                return response('O checkin foi feito com sucesso!', 200);
            }
            abort(400, 'Não é possível fazer check-in antes das 24 horas da aula, nem faltando 30 minutos para começar a aula e aulas que já foi!');
        } catch(\Exception $exception) {
            abort(500,$exception->getMessage());
        }
    }

    public function listar(Request $request)
    {
        
        try {
            $aulas = new Aula();
            $aulas = Aula::select(
                'id',
                'nome',
                'qtde_maxima',
                'nome_prof',
                'duracao',
                'data_hora',
                'qtde_aluno',
                \DB::raw('(qtde_maxima - qtde_aluno) as qtde_disponivel'),
            );

            if ($request->opcaoData) {
                $aulas= $aulas->whereDate(\DB::raw('data_hora::date'),'>=', date('Y-m-d'))
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
