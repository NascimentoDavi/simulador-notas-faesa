@extends('layouts.app')

@section('title', 'Menu')

@section('content')

<style>
    
</style>

<div class="container">

    <div class="row">
        
        <div class="col-lg-10 col-md-12 mx-auto">
            
            <div class="mb-3 p-0">
                <h2 class="poppins-semibold m-0 p-0">Notas do Aluno</h2>

                <div class="my-1">
                    <form method="POST" action="{{ route('getNotas') }}" id="notasPorPeriodo">
                        <div class="my-1">
                            <div class="row">
                                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                    <select class="form-select" name="ano" id="anoSelect">
                                        <option value="2025">2025</option>
                                        <option value="2024">2024</option>
                                        <option value="2023">2023</option>
                                    </select>
                                </div>
                                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                    <select class="form-select" name="semestre" id="semestreSelect">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                    </select>
                                </div>
                                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                    <button class="btn btn-primary">Pesquisar</button>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
                  
                <h6 class="d-block d-md-none m-0">{{ $aluno->NOME_COMPL }}</h4>
                <h6 class="d-block d-sm-none m-0">{{ $aluno->ALUNO }}</h4>
                <h6 class="d-block d-sm-none m-0">{{ $curso->CURSO }} | {{ $curso->NOME }}</h6>
            </div>


            @if($notasPivot->isEmpty())
                <div class="alert alert-warning" role="alert">
                    Nenhuma nota encontrada.
                </div>
            @else
                <div class="table-responsive">

                    <table class="table table-bordered table-striped">
                        
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

            @endif
        </div>
    </div>
</div>

@endsection

<script>
    document.getElementById("notasPorPeriodo").addEventListener("Submit", function(event) {
        event.preventDefault();

        const $ano = document.getElementById('anoSelect').value;
        const $semestre = document.getElementById('semestreSelect').value;

        fetch("{{ route('getNotas') }}", {
            method: "GET",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Content-Type": "application/json"
            },
            body: JSON.stringify($ano, $semestre)
        })
        .then(response => response.json())
        .then(data)
    })
</script>