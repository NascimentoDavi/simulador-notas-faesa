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

                                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                    <select class="form-select" name="ano" id="anoSelect">
                                        {{-- JavaScript --}}
                                    </select>
                                </div>

                                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                    <select class="form-select" name="semestre" id="semestreSelect">
                                        <option value="1">1º Semestre</option>
                                        <option value="2">2º Semestre</option>
                                    </select>
                                </div>

                                <script>

                                    const anoSelect = document.getElementById('anoSelect');
                                    const currentYear = new Date().getFullYear();

                                    for(let i = currentYear; i >= currentYear - 5; i--) {
                                        const option = document.createElement('option');
                                        option.value = i;
                                        option.textContent = i;
                                        anoSelect.appendChild(option);
                                    }

                                </script>

                                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
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
                        @foreach(session('notas', []) as $nota)
                        <tr>
                            <td data-label="Disciplina">{{ $nota['DISCIPLINA'] }}</td>
                            <td data-label="Nome da Disciplina" class="text-truncate" style="max-width: 150px;">
                                {{ $nota['DISCIPLINA'] }}
                            </td>
                            <td data-label="C1">{{ $nota['C1'] ?? 'NI' }}</td>
                            <td data-label="C2">{{ $nota['C2'] ?? 'NI' }}</td>
                            <td data-label="C3">{{ $nota['C3'] ?? 'NI' }}</td> <!-- Usando o operador null coalescing -->
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>

    // document.getElementById("notasPorPeriodo").addEventListener("submit", function(event) {
    //     event.preventDefault(); // Impede envio padrão do formulário. Não recarrega a página

    //     const aluno = @json(session('aluno'));
    //     const ano = document.getElementById("anoSelect").value;
    //     const semestre = document.getElementById("semestreSelect").value;

    //     const requestData = {
    //         aluno: aluno,
    //         ano: ano,
    //         semestre: semestre
    //     }

    //     fetch("{{ route('getNotas') }}", {
    //         method: "POST",
    //         headers: {
    //             "X-CSRF-TOKEN": "{{ csrf_token() }}",
    //             "Content-Type": "application/json"
    //         },
    //         body: JSON.stringify(requestData)
    //     })
    //     .then(response => response.json())
    //     .then(data => {
    //         console.log(data);
    //     })
    //     .catch(error => console.error("erro ao buscar as notas", error));
    // })

</script>

@endsection
