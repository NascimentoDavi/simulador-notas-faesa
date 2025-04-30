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
                    <table class="table table-bordered table-striped table-hover" id="grades-table">
                        <thead class="table-dark" id="table_notas">
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





                <!-- MODAL - INFORMACOES DAS DISCIPLINAS -->
                <div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="infoModalLabel">Informações da Disciplina</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p><strong>Disciplina:</strong> <span id="modalDisciplina"></span></p>
                        <p><strong>Nome da Disciplina:</strong> <span id="modalNomeDisciplina"></span></p>
                        <p><strong>C1:</strong> <span id="modalC1"></span></p>
                        <p><strong>C2:</strong> <span id="modalC2"></span></p>
                        <p><strong>C3:</strong> <span id="modalC3"></span></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    </div>
                    </div>
                </div>
                </div>





                <!-- EXIBICAO DE MODAL - INFORMACOES DA DISCIPLINA -->
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const rows = document.querySelectorAll('#grades-table tbody tr');

                        rows.forEach(row => {
                            row.addEventListener('click', function() {
                                const disciplina = row.cells[0].textContent;  // Disciplina
                                const nomeDisciplina = row.cells[1].textContent;  // Nome da Disciplina
                                const c1 = row.cells[2].textContent;  // C1
                                const c2 = row.cells[3].textContent;  // C2
                                const c3 = row.cells[4].textContent;  // C3

                                // PREENCHE MODAL
                                document.getElementById('modalDisciplina').textContent = disciplina;
                                document.getElementById('modalNomeDisciplina').textContent = nomeDisciplina;
                                document.getElementById('modalC1').textContent = c1;
                                document.getElementById('modalC2').textContent = c2;
                                document.getElementById('modalC3').textContent = c3;

                                // EXIBE MODAL
                                var myModal = new bootstrap.Modal(document.getElementById('infoModal'));
                                myModal.show();
                            });
                        });
                    });
                </script>





            </div>
        </div>
    </div>
</div>

@endsection