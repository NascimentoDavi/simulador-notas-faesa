<div class="mt-4">
    <h5 class="text-center text-primary">Simule sua Nota</h5>

    <div class="d-flex justify-content-center mt-4">
        <div class="input-group" style="max-width: 500px; width: 100%;">

            <button class="btn btn-outline-primary fw-bold d-none d-sm-block" type="button">Disciplina</button>

            <select class="form-control border border-primary" style="max-width: 80%; margin-left: auto; margin-right: auto; border-radius: 10px" id="disciplinaSelect" name="disciplina">
                <option value="">Selecione uma disciplina</option>
                @foreach ($notas as $nota)
                    <option value="{{ $nota['DISCIPLINA'] }}" 
                        data-c1="{{ $nota['C1'] }}" 
                        data-c2="{{ $nota['C2'] }}" 
                        data-c3="{{ $nota['C3'] }}">
                        {{ $nota['NOME_DISCIPLINA'] }}
                    </option>
                @endforeach
            </select>

        </div>
    </div>

    <div class="container mt-3">
        <div class="row justify-content-center gap-2">
            @foreach (['C1', 'C2', 'C3'] as $campo)
                <div class="col-md-4">
                    <div class="input-group">
                        <button class="btn btn-outline-secondary fw-bold" type="button">{{ $campo }}</button>
                        <input type="number" step="0.1" class="form-control text-center border border-dark rounded"
                            min="0" max="10" id="nota{{ $campo }}" oninput="limitarValor(this)">
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="container d-flex justify-content-center mt-4 gap-3">
        <form id="simularForm">
            @csrf
            <button type="submit" class="btn btn-success fw-bold">Simular</button>
        </form>
        <button class="btn btn-warning fw-bold" id="limparBtn">Limpar</button>
    </div>

    {{-- Resultados --}}
    <div class="container mt-4">
        <div class="row justify-content-center gap-2">
            @foreach (['MP' => 'Média Parcial', 'NM' => 'Nota Mínima na Final'] as $key => $label)
                <div class="col-md-4">
                    <div class="card text-center border-primary">
                        <div class="card-header bg-primary text-white fw-bold">{{ $label }}</div>
                        <div class="card-body">
                            <input type="text" class="form-control text-center border border-dark rounded" 
                                id="nota{{ $key }}" disabled>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="text-center mt-4">
        <small class="text-muted">
            *MP = Média Parcial | *NM = Nota mínima necessária na avaliação final
        </small>
    </div>
</div>

<script>
    function limitarValor(input) {
        let valor = parseFloat(input.value);
        if (isNaN(valor) || valor < 0) {
            input.value = '0.00';
        } else if (valor > 10) {
            input.value = '10.00';
        } else {
            input.value = valor.toFixed(1);
        }
    }

    document.getElementById("simularForm").addEventListener("submit", function(event) {
        event.preventDefault();

        let c1 = document.getElementById("notaC1").value;
        let c2 = document.getElementById("notaC2").value;
        let c3 = document.getElementById("notaC3").value;
        let disciplina = document.getElementById("disciplinaSelect").value;

        if (!disciplina) {
            alert("Selecione uma disciplina antes de continuar!");
            return;
        }

        fetch("{{ route('simular') }}", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Content-Type": "application/json"
            },
            body: JSON.stringify({ c1, c2, c3, disciplina })
        })
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                alert(data.error);
            } else {
                document.getElementById("notaMP").value = parseFloat(data.original.mediaAritmetica).toFixed(1);
                document.getElementById("notaNM").value = parseFloat(data.original.mediaProvaFinal).toFixed(2);
            }
        })
        .catch(error => console.error("Erro:", error));
    });

    document.getElementById("limparBtn").addEventListener("click", function() {
        ["notaC1", "notaC2", "notaC3", "notaMP", "notaNM"].forEach(id => {
            document.getElementById(id).value = "";
        });
    });

    document.getElementById('disciplinaSelect').addEventListener('change', function() {
        let selectedOption = this.options[this.selectedIndex];
        if (selectedOption.value) {
            ["C1", "C2", "C3"].forEach(campo => {
                document.getElementById('nota' + campo).value = selectedOption.getAttribute('data-' + campo.toLowerCase()) || 0;
            });
        }
    });
</script>
