<?php

namespace App\Http\Controllers;

use App\Models\Aula;
use DateInterval;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class AulaController extends Controller
{
    public function __construct() {
        $this->middleware('auth:admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $aula = new Aula();

            $this->validaAgendaAulas($request);

            $aula->fill([
                'nome' => $request->nome,
                'qtdeMaxima'=> $request->qtdeMaxima,
                'nomeProf'=> $request->nomeProf,
                'duracao'=> $request->duracao,
                'dataHoraAula' => date("Y-m-d G:i", strtotime($request->dataHoraAula))
            ]);
            $aula->save();

            \Session::flash('mensagem_sucesso','Aula adicionada com sucesso!');
            return Redirect::to("/admin/aula");
        } catch (\Exception $Exception){
            \Session::flash('mensagem_erro', $Exception->getMessage());
            return Redirect::to("/admin/aula/novo");

        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $aula = Aula::find($id);
        return view('admin.form', ['aula' => $aula]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $this->validaAgendaAulas($request);
            
            $aula = Aula::find($id);
            $aula->update($request->all());

            \Session::flash('mensagem_sucesso','Aula atualizada com sucesso!');
            return Redirect::to("/admin/aula/edit/".$id);

        } catch(\Exception $exception) {
            return $exception->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function listar()
    {
        try {
            $aulas = Aula::all();

            return ["total" => $aulas->count(), 'rows' => $aulas ];

        } catch(\Exception $exception) {
            return $exception->getMessage();
        }
    }

    function convertHoras($horasInteiras) {

        // Define o formato de saida
        $formato = '%02d:%02d:%02d';
        // Converte para minutos
        $minutos = $horasInteiras * 60;
    
        // Converte para o formato hora
        $horas = floor($minutos / 60);
        $minutos = ($minutos % 60);
    
        // Retorna o valor
        return sprintf($formato, $horas, $minutos, 00);
    }

    public function somaDataHora($request)
    {

        $data_hora= date("Y-m-d G:i",strtotime($request->dataHoraAula)) ; 
        $duracao = vsprintf(" +%d hours +%d minutes +%d seconds", explode(':', $this->convertHoras(round($request->duracao / 60, 2)))); 

        return date('Y-m-d G:i',strtotime($data_hora.$duracao));
    }

    public function validaAgendaAulas($request)
    {
        try {
            $totalRequest = $this->somaDataHora($request);
            $dataInicioResquest = date("Y-m-d G:i", strtotime($request->dataHoraAula));
            
            $datas = Aula::select('id','dataHoraAula', 'duracao')->get();
            
            foreach ($datas as $key => $d) {
                $total = $this->somaDataHora($d);

                if ($total > $dataInicioResquest &&  $total < $totalRequest) {
                    \Session::flash('mensagem_erro', "Já existe uma aula nesse horario.");
                    return Redirect::to("/admin/aula/novo");
                }
                
            }
        } catch(\Exception $exception) {
            return $exception->getMessage();
        }
    }

}
