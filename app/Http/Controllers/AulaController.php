<?php

namespace App\Http\Controllers;

use App\Mail\CancelarAula;
use App\Models\Aula;
use App\Models\Checkin;
use DateInterval;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;

class AulaController extends Controller
{
    public function __construct() {
        $this->middleware('auth:admin');
    }

    public function show($id)
    {
        try {
            $aula = Aula::find($id);
            return view('admin.aula.info', ['aula' => $aula]);
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
        
    }

    public function create()
    {
        try {
            return view('admin.aula.form');
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }

    public function store(Request $request)
    {
        try {
            $aula = new Aula();

            $validaAgenda = $this->validaAgendaAulas($request);
            if (!$validaAgenda) {
                return redirect("/admin/aula/novo");
            }
            
            $valida =  $this->validateCampos($request);
            if (!$valida) {
                return redirect("/admin/aula/novo");
            }
            
            $aula->fill([
                'nome' => $request->nome,
                'qtde_maxima'=> $request->qtde_maxima,
                'nome_prof'=> $request->nome_prof,
                'duracao'=> $request->duracao,
                'data_hora' => date("Y-m-d G:i", strtotime($request->data_hora))
            ]);
            $aula->save();

            \Session::flash('mensagem_sucesso','Aula adicionada com sucesso!');
            return redirect("/admin/aula");
        } catch (\Exception $Exception){
            \Session::flash('mensagem_erro', $Exception->getMessage() . " " . $Exception->getLine(). " " . $Exception->getFile());
            return redirect("/admin/aula/novo");

        }
    }

    public function edit($id)
    {
        try {
            $aula = Aula::find($id);
            return view('admin.aula.form', ['aula' => $aula]);
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validaAgenda = $this->validaAgendaAulas($request, $id);
            if (!$validaAgenda) {
                return Redirect::to("/admin/aula/edit/".$id);
            }

            $valida =  $this->validateCampos($request, $id);
            if (!$valida) {
                return Redirect::to("/admin/aula/edit/".$id);
            }
            
            
            $aula = Aula::find($id);
            $aula->update($request->all());

            \Session::flash('mensagem_sucesso','Aula atualizada com sucesso!');
            return Redirect::to("/admin/aula/edit/".$id);

        } catch(\Exception $exception) {
            \Session::flash('mensagem_erro', $exception->getMessage() . " ". $exception->getLine() . " " . $exception->getFile());
            return Redirect::to("/admin/aula/edit/".$id);
        }
    }

    public function destroy($id)
    {
        try {
            $alunos = Checkin::where('aulas_id', $id)
                            ->leftJoin('users', 'users.id', 'checkins.user_id')
                            ->leftJoin('aulas', 'aulas.id', 'checkins.aulas_id')
                            ->get();
            
            Checkin::where('aulas_id', $id)->delete();
            Aula::where('id', $id)->delete();
            

            foreach ($alunos as $key => $aluno) {
                Mail::to($aluno)->send(new CancelarAula($aluno));
            }
            \Session::flash('mensagem_sucesso','Aula excluída com sucesso!');
            return Redirect::to("/admin/aula");
        } catch(\Exception $exception) {
            \Session::flash('mensagem_erro', $exception->getMessage());
            return Redirect::to("/admin/aula");
        }
        
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
        try {
            // Define o formato de saida
            $formato = '%02d:%02d:%02d';
            // Converte para minutos
            $minutos = $horasInteiras * 60;
        
            // Converte para o formato hora
            $horas = floor($minutos / 60);
            $minutos = ($minutos % 60);
        
            // Retorna o valor
            return sprintf($formato, $horas, $minutos, 00);
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }

    public function somaDataHora($request)
    {
        try {
            $data_hora= date("Y-m-d G:i",strtotime($request->data_hora)) ; 
            $duracao = vsprintf(" +%d hours +%d minutes +%d seconds", explode(':', $this->convertHoras(round($request->duracao / 60, 2)))); 
    
            return date('Y-m-d G:i',strtotime($data_hora.$duracao));
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }

    public function validaAgendaAulas($request, $id=null)
    {
        try {
            $totalRequest = $this->somaDataHora($request);
            $dataInicioResquest = date("Y-m-d G:i", strtotime($request->data_hora));
            
            $datas = Aula::select('id','data_hora', 'duracao')->get();
            
            foreach ($datas as $key => $d) {
                $total = $this->somaDataHora($d);

                if ($total > $dataInicioResquest &&  $total < $totalRequest) {
                    \Session::flash('mensagem_erro', "Já existe uma aula nesse horario.");
                    return false;
                }
                
            }
            return true;
        } catch(\Exception $exception) {
            \Session::flash('mensagem_erro', $exception->getMessage());
            if (!empty($id)) {
                return Redirect::to("/admin/aula/edit/".$id);
            } else {
                return Redirect::to("/admin/aula/novo");

            }
        }
    }

    public function listarAlunos($id)
    {
        try {
            $dados = Checkin::select('users.name as nome')
                            ->where('aulas_id', $id)
                            ->leftJoin('users', 'users.id', 'checkins.user_id')
                            ->get();
            return $dados;
        } catch(\Exception $exception) {
            return $exception->getMessage();
        }
    }

    protected function validateCampos(Request $request, $id=null)
    {
        try {
            if (empty($request->nome)) {
                \Session::flash('mensagem_erro', "O Nome é obrigatorio.");
                return false;
            } elseif(empty($request->qtde_maxima)) {
                \Session::flash('mensagem_erro', "O Quantidade maxima é obrigatorio.");
                return false;
            } elseif(empty($request->nome_prof)) {
                \Session::flash('mensagem_erro', "O Nome do professor é obrigatorio.");
                return false;
            } elseif(empty($request->duracao)) {
                \Session::flash('mensagem_erro', "O Duração é obrigatorio.");
                return false;
            } elseif(empty($request->data_hora)) {
                \Session::flash('mensagem_erro', "O Data/hora é obrigatorio.");
                return false;
            } 

            return true;

        } catch(\Exception $exception) {
            \Session::flash('mensagem_erro', $exception->getMessage());
            if (!empty($id)) {
                return Redirect::to("/admin/aula/edit/".$id);
            } else {
                return Redirect::to("/admin/aula/novo");

            }
        }
    }

}
