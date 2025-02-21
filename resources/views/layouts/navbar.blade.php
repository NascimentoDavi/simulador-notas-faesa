<div class="d-none d-md-block container text-end">
    <a href="" class="mx-1 text-decoration-none">Portal do Aluno</a>
    |
    <a href="" class="mx-1 text-decoration-none">AVA</a>
</div>

<nav class="navbar navbar-expand-md bg-blue-navbar-footer sticky-top">
    <div class="container">

        {{-- Navbar Brand --}}
        <a href="#" class="navbar-brand d-flex align-items-center me-sm-3 me-md-5 p-0">
            <img class="m-0 p-0" src="{{ asset('faesa.png') }}" alt="FAESA LOGO" id="faesa-logo-navbar">
            <span class="ms-3" id="simulador-notas">Simulador de Notas</span>
        </a>

        {{-- Nome e Matrícula do aluno --}}
        <div class="d-none d-md-flex flex-column ms-5 ps-5">
            <p class="navbar-text p-0 m-0 font-color" style="color: #ecf5f9; font-size: 13px; white-space: nowrap;">
                {{ $aluno->NOME_COMPL }}
            </p>
            <p class="navbar-text p-0 m-0 font-color" style="color: #ecf5f9; font-size: 13px; white-space: nowrap;">
                {{ $aluno->ALUNO }}
            </p>
            <p class="navbar-text p-0 m-0 font-color" style="color: #ecf5f9; font-size: 13px; white-space: nowrap;">
                {{ $curso->CURSO }} | {{ $curso->NOME }}
            </p>
        </div>
        
        {{-- NavBar Button | Toggle Button --}}
        {{-- Not working properly --}}
        <button class="navbar-toggler btn-warning" type="button" data-bs-toggle="collapse" data-bs-target="#menuNavBar" aria-controls="navbarNav" aria-expanded="false" arial-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>        

        {{-- Logout Button | Dropdown link --}}
        {{-- Not working properly --}}
        <div class="collapse navbar-collapse" id="menuNavBar">
            <div class="navbar-nav">
                <button class="">Log-out</button>
            </div>
        </div>

       <button type="button" class="d-none d-md-block btn btn-warning" style="white-space: nowrap">
            <a href="{{ route("logout") }}" class="text-decoration-none" style="color:black">Log-out</a>
       </button>

    </div>
</nav>