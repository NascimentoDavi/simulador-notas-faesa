<div class="mt-4">
    <h5 class="text-center">Simule sua Nota</h5>

    <div class="d-flex justify-content-center mt-4">
        <div class="input-group d-flex justify-content-center" style="max-width: 500px; width: 100%;">
            <button class="btn btn-outline-secondary" type="button">Disciplina</button>
            <select class="form-control border border-1 border-dark" id="disciplinaSelect" name="disciplina" style="width: 100%; max-width: 50%;">
                <option value="">Selecione uma Disciplina</option>
                @foreach($notasPivot as $nota)
                    <option value="{{ $nota->DISCIPLINA }}" 
                            data-c1="{{ $nota->C1 }}" 
                            data-c2="{{ $nota->C2 }}" 
                            data-c3="{{ $nota->C3 }}">
                        {{ $nota->NOME_DISCIPLINA }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    
    <div class="container mt-3">
        <div class="d-flex justify-content-center gap-lg-2 gap-md-2 gap-sm-2 gap-1">
            <div class="">
                <div class="input-group mx-lg-1">
                    <button class="btn btn-outline-secondary" type="button">C1</button>
                    <input type="number" class="form-control text-center border border-1 border-dark" maxlength="3"
                        style="max-width: 90px;" id="notaC1" oninput="this.value=this.value.slice(0,3)" value="">
                </div>
            </div>
            
            <div class="">
                <div class="input-group mx-lg-1">
                    <button class="btn btn-outline-secondary" type="button">C2</button>
                    <input type="number" class="form-control text-center border border-1 border-dark" maxlength="3"
                        style="max-width: 90px;" id="notaC2" oninput="this.value=this.value.slice(0,3)" value="">
                </div>
            </div>
    
            <div class="">
                <div class="input-group mx-lg-1">
                    <button class="btn btn-outline-secondary" type="button">C3</button>
                    <input type="number" class="form-control text-center border border-1 border-dark" maxlength="3"
                        style="max-width: 90px;" id="notaC3" oninput="this.value=this.value.slice(0,3)" value="">
                </div>
            </div>
        </div>
    </div>
    
    <div class="container d-flex justify-content-center mt-5 gap-lg-3 ga-md-3 gap-sm-3 gap-2 mb-5">
        <button class="btn btn-primary" id="simularBtn">Simular</button>
        <button class="btn btn-warning" id="limparBtn">Limpar</button>
    </div>
    
    <div class="container">
        <div class="d-flex justify-content-center gap-lg-2 gap-md-2 gap-sm-2 gap-1">
            <div>
                <div class="input-group mx-lg-1">
                        <button class="btn btn-outline-secondary" type="button">MP</button>
                        <input type="number" class="form-control text-center border border-1 border-dark" maxlength="3"
                        style="max-width: 90px;" id="notaMP" oninput="this.value=this.value.slice(0,3)" value="" disabled>
                </div>
            </div>

            <div>
                <div class="input-group mx-lg-1">
                    <button class="btn btn-outline-secondary" type="button">NM</button>
                    <input type="number" class="form-control text-center border border-1 border-dark" maxlength="3"
                        style="max-width: 90px;" id="notaNM" oninput="this.value=this.value.slice(0,3)" value="" disabled>
                </div>
            </div>
        </div>

        <div class="text-center mt-3">
            *MP = Média Aritmética: (C1 + C2 + C3) / 3
        </div>
    </div>

</div>

<script>
    var curso = @json($curso->CURSO);  // Passando o valor de $curso->CURSO para o JavaScript
    
    document.getElementById('disciplinaSelect').addEventListener('change', function() {
        var selectedOption = this.options[this.selectedIndex];

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

    document.getElementById('limparBtn').addEventListener('click', function() {
        document.getElementById('notaC1').value = '';
        document.getElementById('notaC2').value = '';
        document.getElementById('notaC3').value = '';
        document.getElementById('notaMP').value = '';
        document.getElementById('notaNM').value = '';
        document.getElementById('disciplinaSelect').value = '';
    });

    document.getElementById('simularBtn').addEventListener('click', function() {
        var c1 = parseFloat(document.getElementById('notaC1').value) || 0;
        var c2 = parseFloat(document.getElementById('notaC2').value) || 0;
        var c3 = parseFloat(document.getElementById('notaC3').value) || 0;
        
        // Condicional para a fórmula de NM dependendo do valor de 'curso'
        var nm;
        var curso = @json($curso->CURSO);
        if ( curso == 3006) {
            nm = ((c1 + c2 + c3) * 0.1) / 0.4;
        } else {
            nm = ((c1 + c2 + c3) * 0.6) / 0.4;
        }

        var mp = (c1 + c2 + c3) / 3;

        // Preencher os campos MP e NM
        document.getElementById('notaMP').value = mp.toFixed(2); // Média ponderada
        document.getElementById('notaNM').value = nm.toFixed(2); // Nota final, com base na fórmula
    });
</script>
