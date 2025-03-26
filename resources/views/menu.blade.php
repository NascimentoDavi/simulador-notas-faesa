@extends('layouts.app')

@section('title', 'Menu')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-lg-10 col-md-12 mx-auto">
            <div class="mb-3 p-0">






                
                <h2 class="poppins-semibold m-0 p-0">Notas do Aluno</h2>

                <div class="mb-3">
                    {{-- INFORMAÇÕES ALUNO --}}
                    <h6 class="d-block d-md-none m-0">{{ $aluno->NOME_COMPL }}</h6>
                    <h6 class="d-block d-md-none m-0">{{ $aluno->ALUNO }}</h6>
                    <h6 class="d-block d-md-none m-0">{{ $curso->CURSO }} | {{ $curso->NOME }}</h6>
                </div>
                





            {{-- TABELA --}}
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="grades-table">
                    <thead class="table-dark">
                        <tr>
                            <th>Disciplina</th>
                            <th>Nome da Disciplina</th>
                            <th>C1</th>
                            <th>C2</th>
                            <th>C3</th>
                        </tr>
                    </thead>






                    {{-- DISCIPLINAS E NOTAS --}}
                    <tbody>
                        @foreach(session('notas', []) as $nota)
                        <tr>
                            <td data-label="Disciplina">{{ $nota['DISCIPLINA'] }}</td>
                            <td data-label="Nome da Disciplina" class="text-truncate" style="max-width: 150px;">
                                {{ $nota['NOME_DISCIPLINA'] }}
                            </td>
                            <td data-label="C1">{{ $nota['C1'] ?? 'NI' }}</td>
                            <td data-label="C2">{{ $nota['C2'] ?? 'NI' }}</td>
                            <td data-label="C3">{{ $nota['C3'] ?? 'NI' }}</td> 
                        </tr>
                        @endforeach
                    </tbody>







                </table>
            </div>
        </div>
    </div>
</div>

@endsection