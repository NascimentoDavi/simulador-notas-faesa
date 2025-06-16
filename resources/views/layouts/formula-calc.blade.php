<div class="mt-2">



    <h5 class="text-center">Simule sua Nota</h5>



    <!-- SELECAO DE DISCIPLINA -->
    <div class="d-flex justify-content-center mt-3">
        <div class="input-group d-flex justify-content-center" style="max-width: 500px; width: 100%;">
            <button class="btn btn-outline-secondary" type="button">Disciplina</button>
            <select class="form-control border border-1 border-dark" id="disciplinaSelect" name="disciplina" style="width: 100%; max-width: 50%;">
                <option value="">Selecione uma disciplina</option>
                @foreach ($notas as $nota)
                <option value="{{ $nota['DISCIPLINA'] }}" data-c1="{{ $nota['C1'] }}" data-c2="{{ $nota['C2'] }}" data-c3="{{ $nota['C3'] }}">
                    {{ $nota['NOME_DISCIPLINA'] }}
                </option>
                @endforeach
            </select>
        </div>
    </div>



    <!-- CAMPOS DE PREENCHIMENTO DOS VALORES DAS NOTAS -->
    <div class="container mt-5">
        <div class="d-flex justify-content-center gap-lg-2 gap-md-2 gap-sm-2 gap-1">

            <!-- C1 -->
            <div>
                <div class="input-group mx-lg-1">
                    <button class="btn btn-outline-secondary" type="button" onclick="document.getElementById('notaC1').focus();">C1</button>
                    <input type="number" step="0.1" class="form-control text-center border border-1 border-dark" min="0" max="10" style="max-width: 90px;" id="notaC1" value="" oninput="limitarValor(this)">
                </div>
            </div>


            <!-- C2 -->
            <div>
                <div class="input-group mx-lg-1">
                    <button class="btn btn-outline-secondary" type="button" onclick="document.getElementById('notaC2').focus();">C2</button>
                    <input type="number" step="0.1" class="form-control text-center border border-1 border-dark" min="0" max="10" style="max-width: 90px;" id="notaC2" value="" oninput="limitarValor(this)">
                </div>
            </div>

            <!-- C3 -->
            <div>
                <div class="input-group mx-lg-1 mb-3">
                    <button class="btn btn-outline-secondary" type="button" onclick="document.getElementById('notaC3').focus();">C3</button>
                    <input type="number" step="0.1" class="form-control text-center border border-1 border-dark" min="0.00" max="10.00" style="max-width: 90px;" id="notaC3" value="" oninput="limitarValor(this)">
                </div>
            </div>
        </div>
    </div>



    <!-- VALIDACAO DOS VALORES INSERIDOS NOS CAMPOS -->
    <script>
        // Funcao que limita valor preenchido para 10.00
        function limitarValor(input) {
            let valor = input.value;

            // Verifica se o valor é um número válido
            if (isNaN(valor)) return;

            // Limita a quantidade de caracteres após o ponto decimal a dois
            let partes = valor.split('.');
            if (partes.length > 1) {
                partes[1] = partes[1].substring(0, 2);
                input.value = partes.join('.');
            }
            valor = parseFloat(input.value);
            if (valor < 0) {
                input.value = '0.00';
            } else if (valor > 10) {
                input.value = '10.00';
            }
        }
    </script>



    <!-- SIMULACAO DE NOTA -->
    <div class="container d-flex justify-content-center gap-lg-3 ga-md-3 gap-sm-3 gap-2 mb-4">
        <form id="simularForm">
            @csrf
            <button type="submit" class="btn btn-primary" id="simularTrigger">Simular</button>
        </form>
        <div>
            <button class="btn btn-warning" id="limparBtn">Limpar</button>
        </div>
    </div>



    <!-- RESULTADOS DA SIMULACAO -->
    <div class="d-flex justify-content-center gap-lg-2 gap-md-2 gap-sm-2 gap-1 mx-2">
        <div>
            <div class="input-group mx-lg-1">
                <button class="btn btn-outline-secondary" type="button" style="font-size: 14px;">Média Parcial</button>
                <input type="text" class="form-control text-center border border-1 border-dark" maxlength="4" title="Média Parcial"
                    style="max-width: 90px;" id="notaMP" disabled>
            </div>
        </div>
        <div>
            <div class="input-group mx-lg-1">
                <button class="btn btn-outline-secondary" type="button" style="font-size: 14px;">Nota Mínima</button>
                <input type="text" class="form-control text-center border border-1 border-dark" maxlength="4" title="Nota mínima necessária na avaliação final"
                    style="max-width: 90px;" id="notaNM" disabled>
            </div>
        </div>
    </div>

    <div class="container my-5">
        <div class="chart-container mt-5 mb-3">
            <h4 class="text-center">Notas por Disciplina</h4>
            <canvas id="gradesChart" style="height: 40px !important">
            </canvas>
        </div>
    </div>

        <!-- botão pra ALTERNAR TIPO DE GRAFICO -->
    <div class="mb-5 container text-center">
        <button id="toggleGraphType" class="btn btn-primary me-2 my-1">
            Alternar para Gráfico de Linhas
        </button>
        <button id="printTable" class="btn btn-secondary my-1">
            <i class="bi bi-printer"></i>
            Imprimir
        </button>
    </div>

    <style>
        .chart-container {
            height: 500px;
            width: 98%;
            margin: 0 auto;
            position: relative;
        }
    </style>


        <!-- SCRIPT PARA BOTAO DE IMPRIMIR NOTAS -->
        <script>
            document.getElementById("printTable").addEventListener("click", function() {
                const printHeader = document.getElementById("print-header");
                const tableDiv = document.querySelector(".table-responsive");

                printHeader.classList.add("print-area");
                printHeader.classList.remove("d-none");
                tableDiv.classList.add("print-area");
                
                window.print();

                setTimeout(() => {
                    tableDiv.classList.remove("print-area");
                    printHeader.classList.remove("print-area");
                    printHeader.classList.add("d-none");
                }, 100);
            });
        </script>

    <!-- INFORMACOES DA SIMULACAO -->
    <!-- <div class="text-center mt-3">
        *MP = Média Parcial
        <br>
        *NM = Nota mínima necessária na avaliação final
        <br>
        <br>
    </div>-->

</div>

<!-- Modal de Erro | Quando não há fórmula cadastrada para cálculo de nota -->
<div class="modal fade" id="errorFormulaException" tabindex="-1" aria-labelledby="errorFormulaExceptionLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content border-danger">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title" id="errorFormulaExceptionLabel">Erro</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
      </div>
      <div class="modal-body">
        Não foi encontrada uma fórmula cadastrada para a disciplina nesta turma. Por favor, entre em contato com a coordenação do seu curso.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Modal de Selecao de Disciplina antes da simulacao
        const modalHTML = `
            <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title text-danger" id="errorModalLabel">Erro</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Selecione uma disciplina antes de continuar!
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">OK</button>
                        </div>
                    </div>
                </div>
            </div>
        `;
        // Adicionando o modal ao DOM
        document.body.insertAdjacentHTML('beforeend', modalHTML);
        // Move o foco para um evento fora do modal que foi 'escondido' (hidden)
        const errorModalModal = document.getElementById('errorModal');
        errorModalModal.addEventListener('hide.bs.modal', function() {
            document.getElementById('disciplinaSelect')?.focus();
        });




        // Modal de insercao de, no minimo, um valor maior que 0 antes da simulacao
        const zeroValueModalHTML = `
            <div class="modal fade" id="zeroValueModal" tabindex="-1" aria-labelledby="zeroValueModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title text-warning" id="zeroValueModalLabel">Atenção</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                        </div>
                        <div class="modal-body">
                            Informe pelo menos uma nota maior que zero para simular!
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">OK</button>
                        </div>
                    </div>
                </div>
            </div>
        `;
        document.body.insertAdjacentHTML('beforeend', zeroValueModalHTML);
        // Move o foco para um evento fora do modal que foi 'escondido' (hidden)
        const zeroValueModalElement = document.getElementById('zeroValueModal');
        zeroValueModalElement.addEventListener('hide.bs.modal', function() {
            document.getElementById('disciplinaSelect')?.focus();
        });


        // Pega Formulário quando é submetido
        document.getElementById("simularForm").addEventListener("submit", function(event) {

            // Evita que página seja recarregada
            event.preventDefault();

            // Armazena valores de notas
            let c1 = document.getElementById("notaC1").value;
            let c2 = document.getElementById("notaC2").value;
            let c3 = document.getElementById("notaC3").value;

            // Verifica se foi informado, no minimo, um valor maior que 0
            if (
                (c1 === '' && c2 === '' && c3 === '') ||
                (c1 == 0 && c2 == 0 && c3 == 0)
            ) {
                let errorModal = new bootstrap.Modal(document.getElementById("zeroValueModal"));
                errorModal.show();
                return;
            }

            // Armazena disciplina selecionada
            let disciplina = document.getElementById("disciplinaSelect").value;

            // Verifica se a disciplina foi selecionada
            if (!disciplina) {
                let errorModal = new bootstrap.Modal(document.getElementById("errorModal"));
                errorModal.show();
                return;
            }

            const requestData = {
                c1: c1,
                c2: c2,
                c3: c3,
                disciplina: disciplina
            }

            console.log(requestData);

            $.ajax({
                url: "{{ route('simular') }}",
                type: "POST",
                data: JSON.stringify(requestData),
                contentType: "application/json",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                success: function (data) {
                    if (Object.keys(data).length === 0) {
                        const errorModal = new bootstrap.Modal(document.getElementById('errorFormulaException'));
                        errorModal.show();
                        return;
                    }

                    if (data.error) {
                        alert(data.error);
                        return;
                    } else if (c1 + c2 + c3 < 0.16) {
                        $("#notaMP").val(0.0);
                        $("#notaNM").val(0.0);
                    } else {
                        console.log(data);
                        $("#notaMP").val(parseFloat(data.original.mediaAritmetica));

                        const nmValue = data.original.mediaProvaFinal;
                        if (nmValue === null || nmValue === '') {
                            $("#notaNM").val('');
                        } else {
                            $("#notaNM").val(parseFloat(nmValue));
                        }
                    }
                },
                error: function (xhr, status, error) {
                    console.error("Erro na requisição AJAX:", error);
                }
            });
        });

        // Limpar os campos ao clicar no botão "Limpar"
        document.getElementById("limparBtn").addEventListener("click", function() {
            document.getElementById("notaC1").value = "";
            document.getElementById("notaC2").value = "";
            document.getElementById("notaC3").value = "";
            document.getElementById("notaMP").value = "";
            document.getElementById("notaNM").value = "";
            document.getElementById("disciplinaSelect").value = "";
        });

        var curso = @json($curso -> CURSO);
        var formula_nm = @json($formula_nm);
        var formula_mp = @json($formula_mp);

        // Quando a disciplina for selecionada, as notas C1, C2 e C3 serão preenchidas
        document.getElementById('disciplinaSelect').addEventListener('change', function() {
            var selectedOption = this.options[this.selectedIndex];

            if (selectedOption.value) {
                // Verificando se os valores das notas são válidos, caso contrário, atribui 0
                document.getElementById('notaC1').value = selectedOption.getAttribute('data-c1') || 0;
                document.getElementById('notaC2').value = selectedOption.getAttribute('data-c2') || 0;
                document.getElementById('notaC3').value = selectedOption.getAttribute('data-c3') || 0;
            } else {
                // Se nada for selecionado, atribui 0
                document.getElementById('notaC1').value = 0;
                document.getElementById('notaC2').value = 0;
                document.getElementById('notaC3').value = 0;
            }
        });

        // Ensure focus is properly handled when modal is hidden
        const errorModalElement = document.getElementById("errorModal");
        errorModalElement.addEventListener("hidden.bs.modal", function() {
            document.getElementById("disciplinaSelect").focus();
        });
    });
</script>
<script>

</script>