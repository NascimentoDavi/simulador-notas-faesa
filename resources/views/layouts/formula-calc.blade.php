<div class="mt-4">
    <h5 class="text-center">Simule sua Nota</h5>

    <!-- Selecione a Disciplina -->
    <div class="d-flex justify-content-center mt-4">
        <div class="input-group d-flex justify-content-center" style="max-width: 500px; width: 100%;">
            <button class="btn btn-outline-secondary" type="button">Disciplina</button>
            <select class="form-control" id="disciplinaSelect" name="disciplina" style="width: 100%; max-width: 50%;">
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
        <div class="d-flex fex-row justify-content-center gap-lg-5 gap-md-4 gap-sm-3 gap-2">
            <!-- Campo para C1 -->
            <div class="">
                <div class="input-group mx-lg-1">
                    <button class="btn btn-outline-secondary" type="button">C1</button>
                    <input type="number" class="form-control text-center" maxlength="3"
                        style="max-width: 90px;" id="notaC1" oninput="this.value=this.value.slice(0,3)"
                        value="">
                </div>
            </div>
    
            <!-- Campo para C2 -->
            <div class="">
                <div class="input-group mx-lg-1">
                    <button class="btn btn-outline-secondary" type="button">C2</button>
                    <input type="number" class="form-control text-center" maxlength="3"
                        style="max-width: 90px;" id="notaC2" oninput="this.value=this.value.slice(0,3)"
                        value="">
                </div>
            </div>
    
            <!-- Campo para C3 -->
            <div class="">
                <div class="input-group mx-lg-1">
                    <button class="btn btn-outline-secondary" type="button">C3</button>
                    <input type="number" class="form-control text-center" maxlength="3"
                        style="max-width: 90px;" id="notaC3" oninput="this.value=this.value.slice(0,3)"
                        value="">
                </div>
            </div>
        </div>
    </div>
    

</div>

<script>
    document.getElementById('disciplinaSelect').addEventListener('change', function() {
        // Obtém a disciplina selecionada
        var selectedOption = this.options[this.selectedIndex];

        // Se houver uma disciplina selecionada
        if (selectedOption.value) {
            // Atualiza os valores dos campos de notas com base nas opções da disciplina
            document.getElementById('notaC1').value = selectedOption.getAttribute('data-c1') || '';
            document.getElementById('notaC2').value = selectedOption.getAttribute('data-c2') || '';
            document.getElementById('notaC3').value = selectedOption.getAttribute('data-c3') || '';
        } else {
            // Se nenhuma disciplina for selecionada, os campos são limpos
            document.getElementById('notaC1').value = '';
            document.getElementById('notaC2').value = '';
            document.getElementById('notaC3').value = '';
        }
    });
</script>
