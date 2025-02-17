<nav class="navbar navbar-expand-sm bg-blue-navbar-footer">
    <div class="container">

        {{-- Navbar Brand --}}
        <a href="#" class="navbar-brand d-flex align-items-center">
            <img src="{{ asset('faesa.png') }}" alt="FAESA LOGO" id="faesa-logo-navbar">
            Simulador de Notas
        </a>
        
        {{-- Nome e Matrícula do aluno --}}
        <div class="d-flex flex-column">
            <p class="navbar-text p-0 m-0 font-color" style="color: #ecf5f9">{{ $aluno->NOME_COMPL }}</p>
            <p class="navbar-text p-0 m-0 font-color" style="color: #ecf5f9">{{ $aluno->ALUNO }}</p>
        </div>

        {{-- <div class="collapse navbar-collapse">
            <div class="navbar-nav">
                <a href="#" class="nav-link">Menu 1</a>
                <a href="#" class="nav-link">Menu 2</a>
                <a href="#" class="nav-link">Menu 3</a>
                <a href="#" class="nav-link">Menu 4</a>
            </div>
        </div> --}}

    </div>
</nav>