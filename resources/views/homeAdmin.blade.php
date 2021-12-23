@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.19.1/dist/bootstrap-table.min.css">
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
                                <th data-field="dataHoraAula" data-formatter="transDataBR">Dia</th>
                                <th data-field="nome">Aula</th>
                                <th data-field="nomeProf">Professor</th>
                                <th data-field="qtdeMaxima" data-align="center">Qtde de alunos Máximo</th>
                                <th data-field="qtdeAlunos" data-align="center">Qtde de alunos</th>
                                <th data-field="acoes" data-formatter="acoesFormatter" data-align="center">Ações</th>
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

<script>
    $table = $("#table");
    $table.bootstrapTable({
        url:"{{route('aula.listar')}}",
        cache:false,
        onLoadSuccess: function (data, d) {
            console.log(data);
            console.log(d);
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

    function transDataBR(data) {
        if(data){
            data = new Date(data);
            data = pad(data.getDate()) + "/" + pad(data.getMonth()  + 1 ) + "/" + pad(data.getFullYear()) + " " + pad(data.getHours()) + ":" + pad(data.getMinutes()) + ":" + pad(data.getSeconds());

        }
        return data;    
    }

    function pad(d) {
        return (d < 10) ? '0' + d.toString() : d.toString();
    }
    
    function acoesFormatter(value, row, index) {
        var urlEdit = "{{ route('aula.edit', ['id' => ':id']) }}"; 

        urlEdit = urlEdit.replace(":id", row.id);

        var urlDelete = "{{ route('aula.delete', ['id' => ':id']) }}"; 

        urlDelete = urlDelete.replace(":id", row.id);

        return [
            `
            <div class='row' style="padding-left: 25%">
                <div class="col-md-5" data-toggle="tooltip" title="Atualizar Situação"  style="font-size: 22px;" >
                    <a href="${urlEdit}"> <i class="far fa-edit" style="color: rgb(9, 43, 192)"></i></a>
                </div>
                <div class="col-md-4" data-toggle="tooltip" title="Informações" style="font-size: 22px;">
                    <a href="${urlDelete}"><i class="fas fa-trash-alt" style="color: rgb(252, 0, 0)"></i></a> 
                </div>
            </div>`]
    
    }

</script>
@endsection