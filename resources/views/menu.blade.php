@extends('layouts.app')

@section('title', 'Menu')

@section('content')

    <h2>Notas do Aluno</h2>

    @if($notasPivot->isEmpty())
        <p>Nenhuma nota encontrada.</p>
    @else
        <table border="1">
            <thead>
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
                        <td>{{ $nota->DISCIPLINA }}</td>
                        <td>{{ $nota->NOME_DISCIPLINA }}</td>
                        <td>{{ $nota->C1 }}</td>
                        <td>{{ $nota->C2 }}</td>
                        <td>{{ $nota->C3 }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

@endsection
