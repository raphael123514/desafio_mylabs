@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Painel administrador - Nova Aula</div>

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
                    
                    <form id="form" method="POST" action="{{url('admin/aula/store')}}" >
                        {{ csrf_field() }}
                        <div class="form-group row">
                            <div class="col-md-4">
                                <label for="nome">Nome da aula</label>
                                <input id="nome" name="nome" type="text" class="form-control">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-4">
                                <label for="qtdeMaxima">Quantidade máxima de alunos</label>
                                <input id="qtdeMaxima" name="qtdeMaxima" type="number" class="form-control">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-4">
                                <label for="nomeProf">Nome do professor</label>
                                <input id="nomeProf" name="nomeProf" type="text" class="form-control">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-4">
                                <label for="duracao">Duração da aula</label>
                                <input id="duracao" name="duracao" type="datetime" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-4">
                                <label for="dataHoraAula">Data/Hora da aula</label>
                                <input id="dataHoraAula" name="dataHoraAula" type="datetime-local" class="form-control">
                            </div>
                        </div>
                        <br>
                        <button type="submit" class="btn btn-primary">Salvar</button>
                        <button type="cancel" class="btn btn-danger">Cancelar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>

 
</script>
@endsection
