@extends('layouts.app')

@section('title', 'Menu')

@section('content')

<div class="container">

    <div class="row">

        <div class="col-lg-10 col-md-12 mx-auto">
            
            <div class="mb-3 p-0">
                <h2 class="poppins-semibold m-0 p-0">Notas do Aluno</h2>

                <div class="my-1">
                    <form id="notasPorPeriodo">
                        @csrf
                        <div class="my-1">
                            <div class="row">
                
                                <!-- Campo de Ano -->
                                <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-3">
                                    <select class="form-select" name="ano" id="anoSelect">
                                        {{-- JavaScript --}}
                                    </select>
                                </div>
                
                                <!-- Campo de Semestre -->
                                <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-3">
                                    <select class="form-select" name="semestre" id="semestreSelect">
                                        <option value="1">1º Semestre</option>
                                        <option value="2">2º Semestre</option>
                                    </select>
                                </div>
                
                                <!-- Botão Pesquisar -->
                                <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-3 mx-auto mx-md-0">
                                    <button class="btn btn-primary w-100">Pesquisar</button>
                                </div>
                
                            </div>
                        </div>
                    </form>
                </div>
                
                <div class="mb-2">
                    <!-- Exibição de Informações do Aluno -->
                    <h6 class="d-block d-md-none m-0">{{ $aluno->NOME_COMPL }}</h6>
                    <h6 class="d-block d-md-none m-0">{{ $aluno->ALUNO }}</h6>
                    <h6 class="d-block d-md-none m-0">{{ $curso->CURSO }} | {{ $curso->NOME }}</h6>
                </div>
                
                <script>
                    const anoSelect = document.getElementById('anoSelect');
                    const currentYear = new Date().getFullYear();
                
                    for (let i = currentYear; i >= currentYear - 5; i--) {
                        const option = document.createElement('option');
                        option.value = i;
                        option.textContent = i;
                        anoSelect.appendChild(option);
                    }
                </script>
                

            <!-- Table -->
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

<script>

    document.getElementById('notasPorPeriodo').addEventListener('submit', function(event) {
        event.preventDefault();

        let formData = new FormData(this);

        fetch('/notas-por-periodo', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name=_token]').value
            }
        })
        .then(response => response.json())
        .then(data => {
            console.log(data);
        })
        .catch(error => console.error('Erro: ', error));
    });

</script>

@endsection
