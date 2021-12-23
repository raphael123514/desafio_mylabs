@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                @if(Request::is('*/edit/*'))
                    <div class="card-header">Painel administrador - Editar Aula</div>
                @else
                    <div class="card-header">Painel administrador - Nova Aula</div>
                @endif

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
                    @if(Request::is('*/edit/*'))

                        <form id="form" method="POST" _method="POST" action="{{route('aula.update', ['id' => $aula->id]) }}" >
                        @method('PATCH')
                    @else
                        <form id="form" method="POST" action="{{url('admin/aula/store')}}" >
                    @endif
                        {{ csrf_field() }}
                        <div class="form-group row">
                            <div class="col-md-7">
                                <label for="nome">Nome da aula</label>
                                <input id="nome" name="nome" type="text" class="form-control" value="{{$aula->nome ?? null}}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-7">
                                <label for="qtde_maxima">Quantidade máxima de alunos</label>
                                <input id="qtdeMaxima" name="qtdeMaxima" type="number" class="form-control" value="{{$aula->qtdeMaxima ?? null}}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-7">
                                <label for="nomeProf">Nome do professor</label>
                                <input id="nome_prof" name="nomeProf" type="text" class="form-control" value="{{$aula->nomeProf ?? null}}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-7">
                                <label for="duracao">Duração da aula</label>
                                <input id="duracao" name="duracao" type="datetime" class="form-control" value="{{$aula->duracao ?? null}}">
                            </div>
                        </div>
                        @php
                            $date = new DateTime($aula->dataHoraAula ?? null);
                            $dataInput =  $date->format('Y-m-d\TH:i:s'); 
                        @endphp 
                        <div class="form-group row">
                            <div class="col-md-7">
                                <label for="dataHoraAula">Data/Hora da aula</label>
                                <input id="data_hora" name="dataHoraAula" type="datetime-local" class="form-control" value="{{isset($aula->dataHoraAula) ? $dataInput : null}}">
                            </div>
                        </div>
                        <br>
                        <button type="submit" class="btn btn-primary">Salvar</button>
                        <a href="{{route('admin.dashboard')}}"><button type="button" class="btn btn-danger">Cancelar</button></a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>

 
</script>
@endsection
