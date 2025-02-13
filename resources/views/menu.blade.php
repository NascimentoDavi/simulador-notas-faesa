@extends('layouts.app')

@section('title', 'Menu')

@section('content')

    <p>Login: {{ $credenciais['Login'] }}</p>
    <p>Password: {{ $credenciais['Senha'] }}</p>

@endsection()