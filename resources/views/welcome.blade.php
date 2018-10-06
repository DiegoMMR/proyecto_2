<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>

        <!-- Fonts -->
        <link rel="dns-prefetch" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <style>
        header {
        padding: 154px 0 100px;
        }

        @media (min-width: 992px) {
        header {
            padding: 156px 0 100px;
        }
        }

        section {
        padding: 150px 0;
        }
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
      <div class="container">
        <a class="navbar-brand js-scroll-trigger" href="#page-top">WD Bank</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            @auth
                <li class="nav-item">
                    <a class="nav-link js-scroll-trigger" href="{{ url('/home') }}">Inicio</a>
                </li>
            @else
                <li class="nav-item">
                    <a class="nav-link js-scroll-trigger" href="{{ route('login') }}">Acceder</a>
                </li>
            @endauth
          </ul>
        </div>
      </div>
    </nav>

    <header class="bg-primary text-white">
      <div class="container text-center">
        <h1>Bienvenido a WD Bank</h1>
        <p class="lead">Queremos ser tu banco. Un banco para tus ideas</p>
      </div>
    </header>

    <section id="about">
      <div class="container">
        <div class="row">
          <div class="col-lg-8 mx-auto">
            <h2>Quienes somos</h2>
            <p class="lead">
                Las Tecnologías de Información y las organizaciones, dan lugar a la implementación de una enorme cantidad de servicios y/o productos, y presentan una gran expectativa de crecimiento y demanda en la industria del Internet y desarrollo de sistemas computarizados (software).
                <br><br>

Somos un grupo financiero líder que marca tendencia, genera una experiencia superior para sus clientes, orgullo para sus empleados y valor para sus accionistas, de manera sostenible.

            </p>

          </div>
        </div>
      </div>
    </section>

    <section id="services" class="bg-light">
      <div class="container">
        <div class="row">
          <div class="col-lg-8 mx-auto">
            <h2>Integrantes</h2>

            <div class="row">
                <div class="col-md-6">
                    Diego Mauricio Mendez Rivera
                </div>
                <div class="col-md-6">
                    <strong>0900-15-10590</strong>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    K. Alejandro Toledo Silvestre
                </div>
                <div class="col-md-6">
                    <strong>0900-15-6022</strong>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    Kevin Jose Arreola
                </div>
                <div class="col-md-6">
                    <strong>900-13-19765</strong>
                </div>
            </div>

          </div>
        </div>
      </div>
    </section>

    <!-- Footer -->
    <footer class="py-5 bg-dark">
      <div class="container">
        <p class="m-0 text-center text-white">Copyright &copy; WD Bank 2018</p>
      </div>
      <!-- /.container -->
    </footer>

    </body>

</html>
