<div class="d-none d-md-block container text-end" style="height: 17px;">
    <a href="https://portaldoaluno.faesa.br/Login/" class="mx-1 text-decoration-none" style="font-size: 13px; position: absolute; right: 123px">Portal do Aluno | </a>
    <a href="https://ava.faesa.br/d2l/login" class="mx-1 text-decoration-none" style="font-size: 13px; position: absolute; right: 95px"> AVA</a>
</div>

<nav class="navbar navbar-expand-md bg-blue-navbar-footer sticky-top border-bottom border-black">
    <div class="container">

        {{-- Navbar Brand --}}
        <a href="#" class="navbar-brand d-flex align-items-center me-sm-3 me-md-5 p-0">
            <img class="m-0 p-0" src="{{ asset('faesa.png') }}" alt="FAESA LOGO" id="faesa-logo-navbar">
            <span class="ms-3" id="simulador-notas" style="color: #ecf5f9">Simulador de Notas</span>
        </a>

        {{-- Nome e Matrícula do aluno --}}
        <div class="d-none d-md-flex flex-column ms-5">
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
        
        <!-- Botão para abrir o offcanvas -->
        <button class="navbar-toggler btn-warning" type="button" data-bs-toggle="offcanvas" data-bs-target="#menuOffcanvas">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Menu Offcanvas -->
        <div class="offcanvas offcanvas-end bg-light" tabindex="-1" id="menuOffcanvas" aria-labelledby="menuOffcanvasLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="menuOffcanvasLabel">
                    Simulador de Notas
                    <img class="" src="{{ asset('faesa.png') }}" alt="FAESA LOGO" id="faesa-logo-offcanvas" style="height: 20px">
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
            </div>

            <div class="offcanvas-body text-center d-md-none">
                <a href="{{ route('logout') }}" class="btn btn-danger w-75 mb-2">Log-out</a>
                <a href="https://portaldoaluno.faesa.br/Login/" class="btn btn-primary w-75 mb-2">Portal do Aluno</a>
                <a href="https://ava.faesa.br/d2l/login" class="btn btn-secondary w-75 mb-2">AVA</a>
            </div>

        </div>

        <!-- Bootstrap JS (inclui Popper.js) -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

        <button type="button" class="d-none d-md-block btn btn-warning ms-4" style="white-space: nowrap">
                <a href="{{ route("logout") }}" class="text-decoration-none" style="color:black">Log-out</a>
        </button>

    </div>
</nav>