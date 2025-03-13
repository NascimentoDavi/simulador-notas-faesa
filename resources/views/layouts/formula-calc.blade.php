<div class="mt-4">
    <h5 class="text-center">Simule sua Nota</h5>

    <div class="d-flex justify-content-center mt-4">
        <div class="input-group d-flex justify-content-center" style="max-width: 500px; width: 100%;">
            <button class="btn btn-outline-secondary" type="button">Disciplina</button>
            <select class="form-control border border-1 border-dark" id="disciplinaSelect" name="disciplina" style="width: 100%; max-width: 50%;">
                <option value="">Selecione uma Disciplina</option>
                <!-- As opções de disciplinas serão inseridas aqui dinamicamente -->
            </select>
        </div>
    </div>
    
    <div class="container mt-3">
        <div class="d-flex justify-content-center gap-lg-2 gap-md-2 gap-sm-2 gap-1">
            <div class="">
                <div class="input-group mx-lg-1">
                    <button class="btn btn-outline-secondary" type="button">C1</button>
                    <input type="number" step="0.1" class="form-control text-center border border-1 border-dark" maxlength="3" style="max-width: 90px;" id="notaC1" value="">
                </div>
            </div>
    
            <div class="">
                <div class="input-group mx-lg-1">
                    <button class="btn btn-outline-secondary" type="button">C2</button>
                    <input type="number" step="0.1" class="form-control text-center border border-1 border-dark" maxlength="3" style="max-width: 90px;" id="notaC2" value="">
                </div>
            </div>
    
            <div class="">
                <div class="input-group mx-lg-1">
                    <button class="btn btn-outline-secondary" type="button">C3</button>
                    <input type="number" step="0.1" class="form-control text-center border border-1 border-dark" maxlength="3" style="max-width: 90px;" id="notaC3" value="">
                </div>
            </div>
        </div>
    </div>


    <div class="container d-flex justify-content-center mt-5 gap-lg-3 ga-md-3 gap-sm-3 gap-2 mb-5">
        {{-- SIMULACAO DE NOTA --}}
        <form id="simularForm">
            @csrf
            <button type="submit" class="btn btn-primary">Simular</button>
        </form>
        <div>
            <button class="btn btn-warning" id="limparBtn">Limpar</button>
        </div>
    </div>

    <div class="d-flex justify-content-center gap-lg-2 gap-md-2 gap-sm-2 gap-1">
        <div>
            <div class="input-group mx-lg-1">
                <button class="btn btn-outline-secondary" type="button">MP</button>
                <input type="text" class="form-control text-center border border-1 border-dark" maxlength="3"
                    style="max-width: 90px;" id="notaMP" disabled>
            </div>
        </div>
        <div>
            <div class="input-group mx-lg-1">
                <button class="btn btn-outline-secondary" type="button">NM</button>
                <input type="text" class="form-control text-center border border-1 border-dark" maxlength="4"
                    style="max-width: 90px;" id="notaNM" disabled>
            </div>
        </div>
    </div>
    <div class="text-center mt-3">
        *MP = Média Parcial
        <br>
        *NM = Nota mínima necessária na avaliação final
        <br>
        <br>
        Média aritmética: (C1+C2+C3)/3
    </div>
</div>


<script>
document.getElementById("simularForm").addEventListener("submit", function(event) {
        event.preventDefault(); // Impede o envio do formulário

        const c1 = document.getElementById("notaC1").value;
        const c2 = document.getElementById("notaC2").value;
        const c3 = document.getElementById("notaC3").value;

        const requestData = {
            c1: c1,
            c2: c2,
            c3: c3
        }

        fetch("{{ route('simular') }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(requestData)
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById("notaMP").value = parseFloat(data.mediaAritmetica).toFixed(1);
                document.getElementById("notaNM").value = parseFloat(data.mediaProvaFinal).toFixed(2);
            })
            .catch(error => console.error("Erro ao processar a simulação:", error));
    });

    // Limpar os campos ao clicar no botão "Limpar"
    document.getElementById("limparBtn").addEventListener("click", function() {
        document.getElementById("notaMP").value = "";
        document.getElementById("notaNM").value = "";
    });

    var curso = @json($curso->CURSO);
    var formula_nm = @json($formula_nm);
    var formula_mp = @json($formula_mp);

    document.getElementById('disciplinaSelect').addEventListener('change', function() {
        var selectedOption = this.options[this.selectedIndex];

        console.log(selectedOption.attributes);

        if (selectedOption.value) {
            document.getElementById('notaC1').value = selectedOption.getAttribute('data-c1') || '';
            document.getElementById('notaC2').value = selectedOption.getAttribute('data-c2') || '';
            document.getElementById('notaC3').value = selectedOption.getAttribute('data-c3') || '';
        } else {
            document.getElementById('notaC1').value = '';
            document.getElementById('notaC2').value = '';
            document.getElementById('notaC3').value = '';
        }
    });

    document.getElementById("notasPorPeriodo").addEventListener("submit", function(event) {
        event.preventDefault();
        
        const ano = document.getElementById("anoSelect").value;
        const semestre = document.getElementById("semestreSelect").value;

        const requestData = {
            ano: ano,
            semestre: semestre
        }

        fetch("{{ route('getNotas') }}", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Content-Type": "application/json"
            },
            body: JSON.stringify(requestData)
        })
        .then(response => response.json())
        .then(data => {
            const notasArray = Object.values(data.notas);

            console.log(notasArray);

            // Atualizando as opções de disciplinas no select
            const disciplinaSelect = document.getElementById("disciplinaSelect");
            disciplinaSelect.innerHTML = '<option value="">Selecione uma Disciplina</option>'; // Limpa as opções atuais

            notasArray.forEach(nota => {
                const option = document.createElement("option");
                option.value = nota.DISCIPLINA;
                option.textContent = nota.NOME_DISCIPLINA;
                option.dataset.c1 = nota.C1 !== null && nota.C1 !== undefined ? nota.C1 : '';
                option.dataset.c2 = nota.C2 !== null && nota.C2 !== undefined ? nota.C2 : '';
                option.dataset.c3 = nota.C3 !== null && nota.C3 !== undefined ? nota.C3 : '';
                disciplinaSelect.appendChild(option);
            });
        })
        .catch(error => console.error("Erro ao processar a simulação:", error));
    });

    // Adicionando o evento change no select de disciplina para preencher as notas C1, C2, C3
    document.getElementById("disciplinaSelect").addEventListener("change", function() {
        const selectedOption = this.options[this.selectedIndex];
        const c1 = selectedOption.dataset.c1;
        const c2 = selectedOption.dataset.c2;
        const c3 = selectedOption.dataset.c3;

        document.getElementById("notaC1").value = c1 ? c1 : '';
        document.getElementById("notaC2").value = c2 ? c2 : '';
        document.getElementById("notaC3").value = c3 ? c3 : '';
    });

</script>