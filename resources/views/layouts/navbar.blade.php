<div class="d-none d-md-flex flex-row justify-content-start container text-end shadow" style="height: 17px; position: relative;">
    <p id="frase-carousel" class="frase-carousel" style="position: absolute; left: 15px;">O melhor Centro Universitário do Estado.</p>

    <a href="https://www.faesa.br/contato/" class="mx-1 text-decoration-none" style="font-size: 13px; position: absolute; right: 1rem;">Fale Conosco</a>
</div>

<nav class="navbar navbar-expand-md bg-blue-navbar-footer sticky-top border-top border-warning">
    <div class="container">

        {{-- Navbar Brand --}}
        <a href="#" class="navbar-brand d-flex align-items-center me-sm-3 me-md-5 p-0">
            <img class="m-0 p-0" src="{{ asset('faesa.png') }}" alt="FAESA LOGO" id="faesa-logo-navbar">
            <span class="ms-3" id="simulador-notas" style="color: #ecf5f9">
                <span class="">|</span>
                Simulador de Notas</span>
        </a>

        {{-- Nome e Matrícula do aluno --}}
        <div class="d-none d-md-flex flex-column ms-5" style="position: relative;">
            <!-- Botão para alternar a visibilidade -->
           <button id="toggle-info" class="info-button d-none d-lg-inline" style="color: #ecf5f9; font-size: 16px; background: transparent;">
                <i class="bi bi-person-square me-1"></i> <span class="info-text">Info</span> <span class="arrow">&gt;</span>
            </button>

            <div id="info-container" class="info-container d-flex align-items-start">
                <!-- Barra lateral -->
                <div class="info-bar"></div>

                <!-- Conteúdo das informações -->
                <div class="info-content ms-2">
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
            </div>

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
                <a href="{{ route('logout') }}" class="btn btn-danger w-75 mb-2">Sair</a>
                <a href="https://portaldoaluno.faesa.br/Login/" class="btn btn-primary w-75 mb-2">Portal do Aluno</a>
                <a href="https://ava.faesa.br/d2l/login" class="btn btn-secondary w-75 mb-2">AVA</a>
            </div>

        </div>

        <!-- Bootstrap JS (inclui Popper.js) -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

        <div class="mx-5 px-2 d-none d-xxl-flex">
            <a href="https://ava.faesa.br/d2l/login" class="btn logout-button text-decoration-none text-light d-inline-flex align-items-center">
                <span class="logout-text text-white">
                    <p class="fs-6 p-0 m-0">AVA</p>
                </span>
                <span class="logout-icon">
                    <i class="bi bi-box-arrow-in-right text-white"></i>
                </span>
            </a>

            <a href="https://portaldoaluno.faesa.br/Login/" class="btn logout-button text-decoration-none text-light d-inline-flex align-items-center">
                <span class="logout-text text-white">
                    <p class="fs-6 p-0 m-0">Portal</p>
                </span>
                <span class="logout-icon">
                    <i class="bi bi-box-arrow-in-right text-white"></i>
                </span>
            </a>
        </div>


        <form action="{{ route('logout') }}" method="GET" class="d-none d-md-inline ms-4 mx-2">
            @csrf
            <button type="submit" class="btn btn-warning logout-button">
                <span class="logout-text">Sair</span>
                <span class="logout-icon"><i class="bi bi-box-arrow-in-right"></i></span>
            </button>
        </form>

        <script>
            const btn = document.getElementById('toggle-info');
            const infoContainer = document.getElementById('info-container');

            function isVisible(element) {
                return element && element.offsetParent !== null;
            }

            if (isVisible(btn)) {
                btn.addEventListener('click', function() {
                infoContainer.classList.toggle('show');
                this.classList.toggle('active');
                });
            } else {
                
                infoContainer.classList.remove('show');
            }

            window.addEventListener('resize', () => {
                if (!isVisible(btn)) {
                infoContainer.classList.remove('show');
                }
            });

            const frases = [
                "O melhor Centro Universitário do Estado.",
                "Excelência no ensino superior.",
                "Inovação que transforma futuros.",
                "Compromisso com sua carreira.",
                "Educação de verdade, na prática."
            ];

            let index = 0;
            const fraseElement = document.getElementById('frase-carousel');

            setInterval(() => {
                fraseElement.style.opacity = 0;

                setTimeout(() => {
                    index = (index + 1) % frases.length;
                    fraseElement.textContent = frases[index];
                    fraseElement.style.opacity = 1;
                }, 1000);
            }, 4000);
        </script>
        
    </div>
</nav>