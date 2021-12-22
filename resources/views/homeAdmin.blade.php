@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Painel administrador</div>

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
                    <div class="row">
                        <div class="md-col-3">
                            <a href="{{route('aula.create')}}"><button type="button" class="btn btn-primary">Adicionar Aula</button></a>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <table
                            id="table" 
                            data-toggle="table"
                        >
                            <thead>
                              <tr>
                                <th data-field="Data/Hora">Dia</th>
                                <th data-field="nome">Aula</th>
                                <th data-field="nomeProf">Professor</th>
                                <th data-field="qtdeMaximo">Qtde de alunos Máximo</th>
                                <th>Qtde de alunos</th>
                              </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $table = $("#table");

    $table.bootstrapTable({
        url:"{{route('aula.listar')}}",
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
