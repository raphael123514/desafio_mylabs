@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.19.1/dist/bootstrap-table.min.css">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Aluno</div>

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
                        <div class="col-md-1">
                            <label for="opcaoData">Escolha:</label>
                        </div>
                        <div class="col-md-3">
                            <select class="form-control" id="opcaoData">
                                <option value="0">Dia atual</option>
                                <option value="1">Semana</option>
                            </select>
                          
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
                                <th data-field="data_hora" data-formatter="transDataBRDia">Dia</th>
                                <th data-field="data_hora" data-formatter="transDataBRHora">Hora</th>
                                <th data-field="nome">Aula</th>
                                <th data-field="qtde_disponivel" data-align="center">Vagas disponíveis</th>
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
<script src="https://unpkg.com/bootstrap-table@1.19.1/dist/bootstrap-table-locale-all.min.js"></script>

<script>
    $table = $("#table");
    $table.bootstrapTable({
        url:"{{route('aluno.aula.listar')}}",
        locale: 'pt-BR',
        cache:false,
        onLoadSuccess: function (data, d) {
        },
        onLoadError: function(data, d){
            console.log(d);
            console.log(data);
        },
        queryParams: function (p) {
            return {
                opcaoData: $("#opcaoData").val(), 
                params:p
            };
        },
    });

    $("#opcaoData").change(function(){
        $table.bootstrapTable('refresh')
    })

    function transDataBRDia(data) {
        if(data){
            data = new Date(data);
            data = pad(data.getDate()) + "/" + pad(data.getMonth()  + 1 ) + "/" + pad(data.getFullYear());

        }
        return data;    
    }

    function transDataBRHora(data) {
        if(data){
            data = new Date(data);
            data = pad(data.getHours()) + ":" + pad(data.getMinutes());

        }
        return data;    
    }

    function pad(d) {
        return (d < 10) ? '0' + d.toString() : d.toString();
    }
    
    function acoesFormatter(value, row, index) {
        var data = new Date(row.data_hora);
        data.setDate(data.getDate() - 1);
        let dataMinimo = data.toLocaleString();

        var dataAtual = new Date().toLocaleString();
        if (dataAtual > dataMinimo && dataAtual < (new Date(row.data_hora).toLocaleString())) {
            return [
                `
                <div class='row' style="padding-left: 25%">
                    <div class="col-md-5" data-toggle="tooltip" title="Checkin"  style="font-size: 22px;" >
                        <a onclick="checkin(${row.id})" style="cursor: pointer">
                            <i class="fas fa-check-circle" style="color: rgb(44, 230, 38)"></i>
                        </a>
                        
                    </div>
                    <div class="col-md-4" data-toggle="tooltip" title="Checkout" style="font-size: 22px;">
                        <a onclick="checkout(${row.id})" style="cursor: pointer">
                            <i class="fas fa-sign-out-alt" style="color: rgb(252, 0, 0)"></i>
                        </a> 
                    </div>
                </div>`
            ]
            
        } 
        return "";
    
    }

    function checkin(id) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        }); 

        $.ajax({ 
            data: {id : id}, 
            type: 'POST',
            url: "{{route('aluno.checkin')}}",
            success: function(data){
                $table.bootstrapTable('refresh')

                Swal.fire({
                    icon: 'success',
                    text: data
                })
            },
            error: function(data) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: data.responseJSON.message
                })
            }
        });
    }

    function checkout(id) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        }); 

        $.ajax({ 
            data: {id : id}, 
            type: 'POST',
            url: "{{route('aluno.checkout')}}",
            success: function(data){
                $table.bootstrapTable('refresh')

                Swal.fire({
                    icon: 'success',
                    text: data
                })
            },
            error: function(data) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: data.responseJSON.message
                })
            }
        });
    }

</script>
@endsection
