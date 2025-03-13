@extends('layouts.app')

@section('title', 'Menu')

@section('content')

<div class="container">

    <div class="row">

        <div class="col-lg-10 col-md-12 mx-auto">
            
            <div class="mb-3 p-0">
                <h2 class="poppins-semibold m-0 p-0">Notas do Aluno</h2>

                <div class="my-1">
                    <form id="notasPorPeriodo">
                        @csrf
                        <div class="my-1">
                            <div class="row">

                                <!-- Select Ano -->
                                <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-3">
                                    <select class="form-select" name="ano" id="anoSelect">
                                        <option value="2025">2025</option>
                                        <option value="2024">2024</option>
                                        <option value="2023">2023</option>
                                    </select>
                                </div>

                                <!-- Select Semestre -->
                                <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-3">
                                    <select class="form-select" name="semestre" id="semestreSelect">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                    </select>
                                </div>

                                <!-- Button Pesquisar -->
                                <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-3 d-flex align-items-center justify-content-center">
                                    <button class="btn btn-primary">Pesquisar</button>
                                </div>

                            </div>
                        </div>
                    </form>
                </div>

                <h6 class="d-block d-md-none m-0">{{ $aluno->NOME_COMPL }}</h6>
                <h6 class="d-block d-sm-none m-0">{{ $aluno->ALUNO }}</h6>
                <h6 class="d-block d-sm-none m-0">{{ $curso->CURSO }} | {{ $curso->NOME }}</h6>
            </div>

            <!-- Table -->
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="grades-table">
                    <thead class="table-dark">
                        <tr>
                            <th>Disciplina</th>
                            <th>Nome da Disciplina</th>
                            <th>C1</th>
                            <th>C2</th>
                            <th>C3</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($notasPivot as $nota)
                            <tr>
                                <td data-label="Disciplina">{{ $nota->DISCIPLINA }}</td>
                                <td data-label="Nome da Disciplina" class="text-truncate" style="max-width: 150px;">
                                    {{ $nota->NOME_DISCIPLINA }}
                                </td>
                                <td data-label="C1">{{ $nota->C1 }}</td>
                                <td data-label="C2">{{ $nota->C2 }}</td>
                                <td data-label="C3">{{ $nota->C3 }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
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

        let tableBody = document.getElementById("grades-table").getElementsByTagName('tbody')[0];

        // Limpar tabela antes de adicionar novos dados
        tableBody.innerHTML = '';

        if (notasArray.length === 0) {
            // Criar uma linha informando que não há notas
            let row = tableBody.insertRow();
            let cell = row.insertCell(0);
            cell.colSpan = 5; // Mesclar todas as colunas
            cell.classList.add("text-center", "fw-bold"); // Adicionar estilos
            cell.textContent = "Nenhuma nota encontrada";
        } else {
            notasArray.forEach(nota => {
                let row = tableBody.insertRow();

                row.insertCell(0).textContent = nota.DISCIPLINA;
                row.insertCell(1).textContent = nota.NOME_DISCIPLINA;
                row.insertCell(2).textContent = nota.C1 !== null && nota.C1 !== undefined ? nota.C1 : '-';
                row.insertCell(3).textContent = nota.C2 !== null && nota.C2 !== undefined ? nota.C2 : '-';
                row.insertCell(4).textContent = nota.C3 !== null && nota.C3 !== undefined ? nota.C3 : '-';
            });
        }
    })
    .catch(error => console.error("Erro ao processar a simulação:", error));
});

</script>

@endsection
