@extends('layouts.app')

@section('title', 'Menu')

@section('content')

<style>
    
</style>

<div class="container">

    <div class="row">
        
        <div class="col-lg-10 col-md-12 mx-auto">
            
            <div class="mb-3 p-0 gap-0">
                <h2 class="poppins-semibold">Notas do Aluno</h2>
                <h6 class="d-block d-md-none m-0">{{ $aluno->NOME_COMPL }}</h4>
                <h6 class="d-block d-sm-none m-0">{{ $aluno->ALUNO }}</h4>
            </div>

            @if($notasPivot->isEmpty())
                <div class="alert alert-warning" role="alert">
                    Nenhuma nota encontrada.
                </div>
            @else
                <div class="table-responsive">

                    <table class="table table-bordered table-striped">
                        
                        <thead class="table-dark">
                            <tr>
                                <th>Disciplina</th>
                                <th>Nome da Disciplina</th>
                                <th>C1</th>
                                <th>C2</th>
                                <th>C3</th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            @foreach($notasPivot as $nota)
                                <tr>
                                    <td data-label="Disciplina">{{ $nota->DISCIPLINA }}</td>
                                    <td data-label="Nome da Disciplina" class="text-truncate" style="max-width: 150px;">
                                        {{ $nota->NOME_DISCIPLINA }}
                                    </td>
                                    <td data-label="C1">{{ $nota->C1 }}</td>
                                    <td data-label="C2">{{ $nota->C2 }}</td>
                                    <td data-label="C3">{{ $nota->C3 }}</td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>

                </div>

            @endif
        </div>
    </div>
</div>

@endsection
