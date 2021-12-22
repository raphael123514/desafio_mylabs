<?php

namespace App\Http\Controllers;

use App\Models\Aula;
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
            $aula->fill([
                'nome' => $request->nome,
                'qtdeMaxima'=> $request->qtdeMaxima,
                'nomeProf'=> $request->nomeProf,
                'duracao'=> $request->duracao,
                'dataHoraAula' => date("Y-m-d G:i",strtotime($request->dataHoraAula))
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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

            return ["total" => $aulas->count(), 'data' => $aulas ];

        } catch(\Exception $exception) {
            return $exception->getMessage();
        }
    }
}
