@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.19.1/dist/bootstrap-table.min.css">

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Painel administrador - Informações da Aula</div>

                <div class="card-body">
                    @if (session('mensagem_sucesso'))
                        <div class="alert alert-success">
                            {{ session('mensagem_sucesso') }}
                        </div>
                    @endif

                    @if (session('mensagem_erro'))
                        <div class="alert alert-danger">
                            {{ session('mensagem_erro') }}
                        </div>
                    @endif
                    <div class="form-group row">
                        <div class="col-md-7">
                            <label for="nome"><strong>Nome da aula</strong></label>
                            <h3>{{$aula->nome ?? null}}</h3>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-7">
                            <label for="data_hora"><strong>Data/Hora da aula</strong></label>
                            <h3>{{date("d/m/Y G:i", strtotime($aula->data_hora ?? null))}}</h3>
                        </div>
                    </div>

                    <div class="row">
                        <table
                            id="table" 
                            data-toggle="table"
                        >
                            <thead>
                              <tr>
                                <th data-field="nome">Alunos</th>
                              </tr>
                            </thead>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="https://unpkg.com/bootstrap-table@1.19.1/dist/bootstrap-table.min.js"></script>
<script src="https://unpkg.com/bootstrap-table@1.19.1/dist/bootstrap-table-locale-all.min.js"></script>
<script>
    $table = $("#table");

    $table.bootstrapTable({
        locale: 'pt-BR',
        url:"{{route('aluno.listar', ['id' => $aula->id])}}",
        cache:false,
        onLoadSuccess: function (data, d) {
        },
        onLoadError: function(data, d){
            console.log(d);
            console.log(data);
        },
        queryParams: function (p) {
            return {
                params:p
            };
        },
    });
 
</script>
@endsection
