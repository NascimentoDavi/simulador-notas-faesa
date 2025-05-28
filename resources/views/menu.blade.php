@extends('layouts.app')

@section('title', 'Menu')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-lg-10 col-md-12 mx-auto">
            <div class="mb-3 p-0">





                <form class="p-3 rounded bg-light border mb-3" id="selectYearSemester">
                    <h4 class="poppins-semibold mb-2">
                        Notas do Aluno
                    </h4>


                    <div class="d-block d-lg-none mb-3">
                        <h6 class="m-0">
                            <i class="bi bi-person-badge me-1 ps-2"></i> {{ $aluno->NOME_COMPL }}
                        </h6>
                        <h6 class="m-0">
                            <i class="bi bi-card-list me-1 ps-2"></i> {{ $aluno->ALUNO }}
                        </h6>
                        <h6 class="m-0">
                            <i class="bi bi-mortarboard me-1 ps-2"></i> {{ $curso->CURSO }} | {{ $curso->NOME }}
                        </h6>
                    </div>



                    <div class="row g-3 align-items-end">
                        <div class="col-12 col-md-3">
                            <label for="selectAno" class="form-label small mb-1">
                                <i class="bi bi-calendar me-1"></i> Ano
                            </label>
                            <select class="form-select form-select-sm" id="selectAno" name="ano">
                                <option value="" selected disabled>Escolha...</option>
                                @foreach (session('anosCursados', []) as $ano)
                                    <option value="{{ $ano }}">{{ $ano }}</option>
                                @endforeach
                                <option value="{{ session('anos') }}">{{ session('anos') }}</option>
                            </select>
                        </div>

                        <div class="col-12 col-md-3">
                            <label for="selectSemestre" class="form-label small mb-1">
                                <i class="bi bi-calendar2-week me-1"></i> Semestre
                            </label>
                            <select class="form-select form-select-sm" id="selectSemestre" name="semestre">
                                <option value="" selected disabled>Escolha...</option>
                                <option value="1">1º Semestre</option>
                                <option value="2">2º Semestre</option>
                            </select>
                        </div>

                        <div class="col-12 col-md-auto">
                            <button class="btn btn-sm btn-primary px-4 mt-md-0 mt-2 w-100" type="submit">Pesquisar</button>
                        </div>

                        <div class="col-12 col-md">
                            <div class="alert alert-info p-2 mb-0 small d-flex align-items-center" role="alert">
                                <i class="bi bi-info-circle-fill me-2"></i>
                                Apenas notas do semestre atual podem ser simuladas.
                            </div>
                        </div>
                    </div>
                </form>



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
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fechar</button>
                    </div>
                    </div>
                </div>
                </div>





                <!-- EXIBICAO DE MODAL - INFORMACOES DA DISCIPLINA -->
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                    const btnCloseModal = document.getElementById('btnCloseModal');
                    const infoModalEl = document.getElementById('infoModal');
                    const infoModal = bootstrap.Modal.getOrCreateInstance(infoModalEl);

                    btnCloseModal.addEventListener('click', function() {
                        // Cria e dispara evento keydown simulando ESC
                        const escEvent = new KeyboardEvent('keydown', {
                            key: 'Escape',
                            keyCode: 27,
                            code: 'Escape',
                            which: 27,
                            bubbles: true,
                            cancelable: true,
                        });
                        document.dispatchEvent(escEvent);

                        // Opcional: também fecha o modal diretamente
                        infoModal.hide();
                    });
                });
                </script>



                    <!-- Modal de alerta personalizado -->
                    <div class="modal fade" id="alertModal" tabindex="-1" aria-labelledby="alertModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="alertModalLabel">Atenção</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Mensagem será inserida via JS -->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Ok</button>
                        </div>
                        </div>
                    </div>
                    </div>



<script>
    document.addEventListener('DOMContentLoaded', function() {
        const notas = @json(session('notas', []));

        // Inicialização do gráfico, função para criar/atualizar o gráfico
        const ctx = document.getElementById('gradesChart').getContext('2d');
        let chartType = 'line';
        let chart;

        function criarOuAtualizarGrafico(notasArray) {
            const ctx = document.getElementById('gradesChart').getContext('2d');

            if (!notasArray.length) {
                // Se não tem notas, mostra mensagem no canvas
                if (chart) {
                    chart.destroy();
                    chart = null;
                }

                // Limpa o canvas e escreve mensagem "Nada a ser mostrado"
                ctx.clearRect(0, 0, ctx.canvas.width, ctx.canvas.height);
                ctx.font = '16px Poppins, sans-serif';
                ctx.fillStyle = '#666';
                ctx.textAlign = 'center';
                ctx.fillText('Nada a ser mostrado', ctx.canvas.width / 2, ctx.canvas.height / 2);
                return;
            }

            // Caso tenha dados, cria as arrays para o gráfico
            const disciplinas = [];
            const c1Notas = [];
            const c2Notas = [];
            const c3Notas = [];

            notasArray.forEach(nota => {
                disciplinas.push(nota['DISCIPLINA']);
                c1Notas.push(nota['C1'] ?? 0);
                c2Notas.push(nota['C2'] ?? 0);
                c3Notas.push(nota['C3'] ?? 0);
            });

            const data = {
                labels: disciplinas,
                datasets: [
                    {
                        label: 'C1',
                        data: c1Notas,
                        borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: 'rgba(22, 212, 212, 0.2)',
                        fill: true
                    },
                    {
                        label: 'C2',
                        data: c2Notas,
                        borderColor: 'rgba(54, 162, 235, 1)',
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        fill: false
                    },
                    {
                        label: 'C3',
                        data: c3Notas,
                        borderColor: 'rgb(103, 33, 243)',
                        backgroundColor: 'rgba(153, 102, 255, 0.2)',
                        fill: true
                    }
                ]
            };

            const options = {
                responsive: true,
                plugins: {
                    legend: { position: 'top' },
                    tooltip: { enabled: true }
                },
                scales: {
                    x: {
                        ticks: {
                            maxRotation: 90,
                            minRotation: 20
                        }
                    },
                    y: { min: 0, max: 10 }
                }
            };

            if (chart) {
                chart.data = data;
                chart.config.type = chartType;
                chart.options = options;
                chart.update();
            } else {
                chart = new Chart(ctx, {
                    type: chartType,
                    data: data,
                    options: options
                });
            }
        }

        criarOuAtualizarGrafico(notas);

        // ALTERNAR GRÁFICO
        const toggleButton = document.getElementById('toggleGraphType');
        toggleButton.addEventListener('click', function() {
            chartType = (chartType === 'line') ? 'bar' : 'line';
            criarOuAtualizarGrafico(
                chart.data.datasets[0].data.map((_, i) => ({
                    DISCIPLINA: chart.data.labels[i],
                    C1: chart.data.datasets[0].data[i],
                    C2: chart.data.datasets[1].data[i],
                    C3: chart.data.datasets[2].data[i]
                }))
            );
            toggleButton.textContent = (chartType === 'line') 
                ? 'Alternar para Gráfico de Barras' 
                : 'Alternar para Gráfico de Linhas';
        });

        // ATIVA EVENTOS DE MODAL NAS LINHAS DA TABELA
        function ativarEventoModal() {
            const rows = document.querySelectorAll('#grades-table tbody tr');

            // Crie a instância uma vez
            const infoModalElement = document.getElementById('infoModal');
            const infoModal = new bootstrap.Modal(infoModalElement);

            rows.forEach(row => {
                row.addEventListener('click', function() {
                    document.getElementById('modalDisciplina').textContent = row.cells[0].textContent;
                    document.getElementById('modalNomeDisciplina').textContent = row.cells[1].textContent;
                    document.getElementById('modalC1').textContent = row.cells[2].textContent;
                    document.getElementById('modalC2').textContent = row.cells[3].textContent;
                    document.getElementById('modalC3').textContent = row.cells[4].textContent;

                    infoModal.show();
                });
            });
        }

        ativarEventoModal();

        // FORMUÁRIO DE BUSCA DE NOTAS
        // Inicializa o modal do Bootstrap
const alertModal = new bootstrap.Modal(document.getElementById('alertModal'));

const form = document.getElementById('selectYearSemester');
form.addEventListener('submit', function(event) {
    event.preventDefault();

    const ano = document.getElementById('selectAno').value;
    const semestre = document.getElementById('selectSemestre').value;

    if (ano === "" || semestre === "") {
        // Insere a mensagem no corpo do modal
        document.querySelector('#alertModal .modal-body').textContent = 'Por favor, selecione o ano e o semestre.';
        
        // Mostra o modal
        alertModal.show();
        return;
    }

    fetch("{{ route('selecionar-notas') }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        body: JSON.stringify({ ano, semestre })
    })
    .then(res => res.json())
    .then(data => {
        const tbody = document.querySelector('#grades-table tbody');
        tbody.innerHTML = '';

        data.forEach(nota => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td data-label="Disciplina">${nota.DISCIPLINA}</td>
                <td data-label="Nome da Disciplina" class="text-truncate" style="max-width: 150px;">${nota.NOME_DISCIPLINA}</td>
                <td data-label="C1">${nota.C1 ?? 'NI'}</td>
                <td data-label="C2">${nota.C2 ?? 'NI'}</td>
                <td data-label="C3">${nota.C3 ?? 'NI'}</td>
            `;
            tbody.appendChild(row);
        });

        ativarEventoModal(); // Reativa o modal nas novas linhas
        criarOuAtualizarGrafico(data); // Atualiza o gráfico com os novos dados
    })
    .catch(err => {
        console.error('Erro ao buscar notas:', err);
        // Também pode mostrar o modal para erro, se quiser:
        document.querySelector('#alertModal .modal-body').textContent = 'Erro ao buscar notas.';
        alertModal.show();
    });
});


    });
</script>
@endsection