@extends('layouts.app')

@section('title', 'Menu')

@section('content')

<!-- Biblitoeca para exportação PDF -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

<div class="container">
    <div class="row">
        <div class="col-lg-12 col-md-12 mx-auto">
            <div class="mb-3 p-0">


                <form class="p-3 rounded bg-light border mb-3" id="selectYearSemester">

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
                            <select class="form-select form-select-sm" id="selectAno" name="ano" onchange="atualizaSemestres()">
                                <option value="" selected disabled>Escolha...</option>
                                @foreach (session('anosSemestresCursados', []) as $ano => $semestres)
                                <option value="{{ $ano }}">{{ $ano }}</option>
                                @endforeach
                                {{-- Remove a opção que estava com session('anos') pois já está no foreach --}}
                            </select>

                        </div>

                        <div class="col-12 col-md-3">
                            <label for="selectSemestre" class="form-label small mb-1">
                                <i class="bi bi-calendar2-week me-1"></i> Semestre
                            </label>
                            <select class="form-select form-select-sm" id="selectSemestre" name="semestre">
                                <option value="" selected disabled>Escolha o ano primeiro...</option>
                            </select>

                        </div>

                        <div class="col-12 col-md-auto">
                            <button class="btn btn-sm btn-primary px-4 mt-md-0 mt-2 w-100" id="searchGradesButton" type="submit">Pesquisar</button>
                        </div>

                        <div class="col-12 col-md">
                            <div class="alert alert-info p-2 mb-0 small d-flex align-items-center" role="alert">
                                <i class="bi bi-info-circle-fill me-2"></i>
                                Apenas notas do semestre atual podem ser simuladas.
                            </div>
                        </div>
                    </div>
                </form>



                <!-- TABELA -->
                <div class="table-responsive" id="grade-table">
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
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Ok</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function() {
    // Pega as notas salvas na sessão do Laravel no carregamento inicial
    let notas = @json(session('notas', []));

    const ctx = document.getElementById('gradesChart').getContext('2d');
    let chartType = 'bar';
    let chart;

    function criarOuAtualizarGrafico(notasArray) {
        if (!notasArray.length) {
            if (chart) {
                chart.destroy();
                chart = null;
            }
            ctx.clearRect(0, 0, ctx.canvas.width, ctx.canvas.height);
            ctx.font = '16px Poppins, sans-serif';
            ctx.fillStyle = '#666';
            ctx.textAlign = 'center';
            ctx.fillText('Nada a ser mostrado', ctx.canvas.width / 2, ctx.canvas.height / 2);
            return;
        }

        const disciplinas = [];
        const c1Notas = [];
        const c2Notas = [];
        const c3Notas = [];

        notasArray.forEach(nota => {
            let nomeDisciplina = nota['NOME_DISCIPLINA'];
            const limiteCaracteres = 15;
            if (nomeDisciplina.length > limiteCaracteres) {
                nomeDisciplina = nomeDisciplina.substring(0, limiteCaracteres) + '...';
            }
            const labelComQuebra = nomeDisciplina.includes(' ') ? nomeDisciplina.split(' ') : [nomeDisciplina];
            disciplinas.push(labelComQuebra);

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
                    backgroundColor: c1Notas.map(() => 'rgba(8, 92, 164, 0.3)'),
                    borderColor: c1Notas.map(() => '#085ca4'),
                    borderWidth: 1,
                    fill: true,
                    tension: 0.3
                },
                {
                    label: 'C2',
                    data: c2Notas,
                    backgroundColor: c2Notas.map(() => 'rgba(122, 172, 206, 0.3)'),
                    borderColor: c2Notas.map(() => '#7aacce'),
                    borderWidth: 1,
                    fill: true,
                    tension: 0.3
                },
                {
                    label: 'C3',
                    data: c3Notas,
                    backgroundColor: c3Notas.map(() => 'rgba(252, 124, 52, 0.3)'),
                    borderColor: c3Notas.map(() => '#fc7c34'),
                    borderWidth: 1,
                    fill: true,
                    tension: 0.3
                }
            ]
        };

        const options = {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                title: {
                    display: true,
                    font: {
                        size: 20,
                        weight: 'bold'
                    }
                },
                legend: {
                    position: 'top'
                }
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

    // Cria o gráfico inicial com as notas da sessão
    criarOuAtualizarGrafico(notas);

    // Botão para alternar tipo do gráfico
    const toggleButton = document.getElementById('toggleGraphType');
    toggleButton.addEventListener('click', function() {
        chartType = (chartType === 'line') ? 'bar' : 'line';
        criarOuAtualizarGrafico(notas); // usa o array atualizado
        toggleButton.textContent = (chartType === 'line') ? 'Alternar para Gráfico de Barras' : 'Alternar para Gráfico de Linhas';
    });

    // Função para ativar evento de modal nas linhas da tabela
    function ativarEventoModal() {
        const rows = document.querySelectorAll('#grades-table tbody tr');
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

    const alertModal = new bootstrap.Modal(document.getElementById('alertModal'));

    const form = document.getElementById('selectYearSemester');
    form.addEventListener('submit', function(event) {
        event.preventDefault();

        const ano = document.getElementById('selectAno').value;
        const semestre = document.getElementById('selectSemestre').value;

        if (ano === "" || semestre === "") {
            document.querySelector('#alertModal .modal-body').textContent = 'Por favor, selecione o ano e o semestre.';
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

            ativarEventoModal();

            // *** Atualiza a variável global notas com os novos dados ***
            notas = data;

            // Atualiza o gráfico com os dados atualizados
            criarOuAtualizarGrafico(notas);

            // Abaixo continua seu código original para a verificação das disciplinas
            const tabela = document.getElementById("grades-table");
            const linhas = tabela.querySelectorAll("tbody tr");

            const dadosTabela = Array.from(linhas).map(linha => {
                const colunas = linha.querySelectorAll("td");
                return {
                    disciplina: colunas[0].textContent.trim()
                };
            });

            return fetch("{{ route('verificar-disciplinas') }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    disciplinas: dadosTabela
                })
            });
        })
        .then(response => response.json())
        .then(data => {
            const inputC1 = document.getElementById('notaC1');
            const inputC2 = document.getElementById('notaC2');
            const inputC3 = document.getElementById('notaC3');
            const notaMP = document.getElementById('notaMP');
            const notaNM = document.getElementById('notaNM');
            disciplinaSelect.value = "";

            const simularTrigger = document.getElementById("simularTrigger");
            const limparBtn = document.getElementById("limparBtn");

            if (data === 1) {
                inputC1.disabled = false;
                inputC2.disabled = false;
                inputC3.disabled = false;
                disciplinaSelect.disabled = false;
                simularTrigger.disabled = false;
                limparBtn.disabled = false;
            } else {
                inputC1.disabled = true;
                inputC1.value = "";
                inputC2.disabled = true;
                inputC2.value = "";
                inputC3.disabled = true;
                inputC3.value = "";
                notaMP.value = "";
                notaNM.value = "";
                disciplinaSelect.disabled = true;
                simularTrigger.disabled = true;
                limparBtn.disabled = true;
            }
        });
    });
});
</script>


<!-- INFORMCAOES QUE APARECEM SOMENTE AO CLICAR EM IMPRIMIR NOTAS -->
<div id="print-header" class="d-none">
    <ul class="print-header-student-info">
        <li>Nome Completo: {{ session('aluno')->NOME_COMPL }}</li>
        <li>Matrícula: {{ session('aluno')->ALUNO }}</li>
        <li>Curso: {{ session('curso')->NOME }}</li>
        <li>Período: {{ session('aluno')->SERIE }}</li>
        <li>Currículo: {{ session('aluno')->CURRICULO }}</li>
    </ul>
</div>




<!-- SCRIPT PARA IMPRIMIR AO CLICAR CONTROL+P -->
<script>
    document.addEventListener("keydown", function(e) {
        if (e.ctrlKey && e.key.toLowerCase() === "p") {
            e.preventDefault();
            document.getElementById("printTable").click();
        }
    });
</script>





<!-- LIMITA A SELECAO DE ANO E SEMESTRE DE ACORDO COM OS QUE FORAM CURSAODS -->
<script>
    const anosSemestres = @json(session('anosSemestresCursados', []));

    function atualizaSemestres() {
        const selectAno = document.getElementById('selectAno');
        const selectSemestre = document.getElementById('selectSemestre');
        const anoSelecionado = selectAno.value;

        selectSemestre.innerHTML = '<option value="" selected disabled>Escolha...</option>';

        if (anosSemestres.hasOwnProperty(anoSelecionado)) {
            anosSemestres[anoSelecionado].forEach(function(semestre) {
                const option = document.createElement('option');
                option.value = semestre;
                option.text = semestre + 'º Semestre';
                selectSemestre.appendChild(option);
            });
        }
    }
</script>




@endsection