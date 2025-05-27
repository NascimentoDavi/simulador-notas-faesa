@extends('layouts.app')

@section('title', 'Menu')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-lg-10 col-md-12 mx-auto">
            <div class="mb-3 p-0">






                <form class="d-flex flex-row align-items-center flex-wrap" id="selectYearSemester">
                    <h2 class="poppins-semibold m-0 p-0 mx-3">Notas do Aluno</h2>

                    <div class="input-group input-group-sm me-2" style="width: auto;">
                        <label class="input-group-text bg-primary-subtle" for="selectAno">Ano</label>
                        <select class="form-select form-select-sm" id="selectAno" style="width: auto;">
                            <option selected>Escolha...</option>
                            <option value="2024">2024</option>
                            <option value="2025">2025</option>
                        </select>
                    </div>

                    <div class="input-group input-group-sm me-2" style="width: auto;">
                        <label class="input-group-text bg-primary-subtle" for="selectSemestre">Semestre</label>
                        <select class="form-select form-select-sm" id="selectSemestre" style="width: auto;">
                            <option selected>Escolha...</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                        </select>
                    </div>

                    <button class="btn btn-primary btn-sm" type="submit">Pesquisar</button>
                </form>


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


                <div class="mt-3">
                    <button id="toggleGraphType" class="btn btn-primary">Alternar para Gráfico de Barras</button>
                </div>


                <div class="mt-5">
                    <h3>Desempenho do Aluno</h3>
                    <canvas id="gradesChart"></canvas>
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


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const notas = @json(session('notas', [])); // Obtemos os dados da sessão
        
        // Prepare os dados para o gráfico
        const disciplinas = [];
        const c1Notas = [];
        const c2Notas = [];
        const c3Notas = [];

        // Preenche as variáveis com os dados das notas
        notas.forEach(nota => {
            disciplinas.push(nota['DISCIPLINA']);
            c1Notas.push(nota['C1'] ?? 0);  // Caso não haja nota, coloca 0
            c2Notas.push(nota['C2'] ?? 0);
            c3Notas.push(nota['C3'] ?? 0);
        });

        // Criação do gráfico
        const ctx = document.getElementById('gradesChart').getContext('2d');
        let chartType = 'line'; // O tipo inicial do gráfico é 'line'

        const chartData = {
            labels: disciplinas, // Disciplinas no eixo X
            datasets: [{
                label: 'C1',
                data: c1Notas,
                borderColor: 'rgba(75, 192, 192, 1)',
                backgroundColor: 'rgba(22, 212, 212, 0.2)',
                fill: true
            }, {
                label: 'C2',
                data: c2Notas,
                borderColor: 'rgba(54, 162, 235, 1)',
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                fill: false
            }, {
                label: 'C3',
                data: c3Notas,
                borderColor: 'rgb(103, 33, 243)',
                backgroundColor: 'rgba(153, 102, 255, 0.2)',
                fill: true
            }]
        };

        let chartOptions = {
    responsive: true,
    plugins: {
        legend: {
            position: 'top',
        },
        tooltip: {
            enabled: true
        }
    },
    scales: {
        x: {
            title: {
                display: false,
                text: 'Disciplinas'
            },
            ticks: {
                font: {
                    size: 12, // Reduz o tamanho da fonte dos rótulos
                    family: 'arial',
                    weight: 'normal'
                },
                maxRotation: 90,  // Define a rotação máxima dos rótulos
                minRotation: 20,  // Garante que todos os rótulos fiquem com 90 graus
            }
        },
        y: {
            title: {
                display: false,
                text: 'Notas'
            },
            min: 0,
            max: 10 // Ajuste conforme a escala de notas
        }
    }
};


        // Criação do gráfico inicial
        
        const chart = new Chart(ctx, {
            type: chartType,
            data: chartData,
            options: chartOptions
        });

        // Alternar o tipo de gráfico ao clicar no botão
        const toggleButton = document.getElementById('toggleGraphType');
        toggleButton.addEventListener('click', function() {
            // Alterna entre 'line' e 'bar'
            chartType = (chartType === 'line') ? 'bar' : 'line';
            
            // Atualiza o tipo de gráfico sem destruir o gráfico
            chart.config.type = chartType;
            chart.update(); // Atualiza o gráfico com o novo tipo

            // Altera o texto do botão para refletir o novo tipo
            toggleButton.textContent = (chartType === 'line') ? 'Alternar para Gráfico de Barras' : 'Alternar para Gráfico de Linhas';
        });
    });

    document.getElementById("selectYearSemester").addEventListener("change", function() {
        // Define method to select grades by year and semester
    })

</script>


            </div>
        </div>
    </div>
</div>

@endsection