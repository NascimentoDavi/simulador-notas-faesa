<div class="mt-4">
    <h5 class="text-center">Simule sua Nota</h5>

    <div class="d-flex justify-content-center mt-4">
        <div class="input-group d-flex justify-content-center" style="max-width: 500px; width: 100%;">
            <button class="btn btn-outline-secondary" type="button">Disciplina</button>
            <select class="form-control border border-1 border-dark" id="disciplinaSelect" name="disciplina" style="width: 100%; max-width: 50%;">
                @foreach ($notas as $nota)
                    <option value="{{ $nota['DISCIPLINA'] }}" data-c1="{{ $nota['C1'] }}" data-c2="{{ $nota['C2'] }}" data-c3="{{ $nota['C3'] }}">
                        {{ $nota['NOME_DISCIPLINA'] }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    
    <div class="container mt-3">
        <div class="d-flex justify-content-center gap-lg-2 gap-md-2 gap-sm-2 gap-1">
            <div>
                <div class="input-group mx-lg-1">
                    <button class="btn btn-outline-secondary" type="button">C1</button>
                    <input type="number" step="0.1" class="form-control text-center border border-1 border-dark" min="0" max="10" style="max-width: 90px;" id="notaC1" value="" oninput="limitarValor(this)">
                </div>
            </div>
    
            <div>
                <div class="input-group mx-lg-1">
                    <button class="btn btn-outline-secondary" type="button">C2</button>
                    <input type="number" step="0.1" class="form-control text-center border border-1 border-dark" min="0" max="10" style="max-width: 90px;" id="notaC2" value="" oninput="limitarValor(this)">
                </div>
            </div>
    
            <div>
                <div class="input-group mx-lg-1">
                    <button class="btn btn-outline-secondary" type="button">C3</button>
                    <input type="number" step="0.1" class="form-control text-center border border-1 border-dark" min="0" max="10" style="max-width: 90px;" id="notaC3" value="" oninput="limitarValor(this)">
                </div>
            </div>
        </div>
    </div>
    
    <script>
        function limitarValor(input) {
            let valor = parseFloat(input.value);
            if (valor < 0) {
                input.value = 0;
            } else if (valor > 10) {
                input.value = 10;
            }
        }
    </script>
    
    
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
    </div>
</div>


<script>

document.getElementById("simularForm").addEventListener("submit", function(event) {
        event.preventDefault();

        let c1 = document.getElementById("notaC1").value;
        let c2 = document.getElementById("notaC2").value;
        let c3 = document.getElementById("notaC3").value;

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


    // document.getElementById('disciplinaSelect').addEventListener('change', function() {
    //     // Obtém a disciplina selecionada
    //     var selectedOption = this.options[this.selectedIndex];
        
    //     // Preenche os campos C1, C2, C3 com as notas da disciplina selecionada
    //     document.getElementById('notaC1').value = selectedOption.getAttribute('data-c1') || '';  // C1
    //     document.getElementById('notaC2').value = selectedOption.getAttribute('data-c2') || '';  // C2
    //     document.getElementById('notaC3').value = selectedOption.getAttribute('data-c3') || '';  // C3
    // });

</script>