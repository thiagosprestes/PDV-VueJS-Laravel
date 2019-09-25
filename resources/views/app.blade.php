<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>PDV</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- CSS -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    </head>
    <body>
        @guest
            @yield('content')
        @endguest

        @auth
            <div id="app">
                <navegacao>
                    <template v-slot:menu>
                        <router-link :to="{ name: 'painel' }" class="list-group-item list-group-item-action bg-dark">
                            <i class="fa fa-tachometer-alt" id="icone-menu"></i> Painel
                        </router-link>
                        <router-link :to="{ name: 'produtos' }" class="list-group-item list-group-item-action bg-dark">
                            <i class="fa fa-box-open" id="icone-menu"></i> Produtos
                        </router-link>
                        <router-link :to="{ name: 'registrar-venda' }" class="list-group-item list-group-item-action bg-dark">
                            <i class="fa fa-cart-plus" id="icone-menu"></i> Registrar venda
                        </router-link>
                        <router-link :to="{ name: 'vendas' }" class="list-group-item list-group-item-action bg-dark">
                            <i class="fa fa-shopping-cart" id="icone-menu"></i> Vendas
                        </router-link>
                        <router-link :to="{ name: 'categorias' }" class="list-group-item list-group-item-action bg-dark">
                            <i class="fa fa-folder" id="icone-menu"></i> categorias
                        </router-link>
                        <a class="list-group-item list-group-item-action bg-dark" id="menu-relatorios" data-toggle="collapse" data-target="#relatorios" aria-expanded="true" aria-controls="relatorios">
                            <i class="fa fa-chart-bar" id="icone-menu"></i> Relatórios
                            <i class="fa fa-angle-right float-right" id="icone-seta"></i>
                        </a>
                        <div class="collapse" id="relatorios">
                            <router-link :to="{ name: 'relatorio-diario' }" class="list-group-item list-group-item-action relatorios-menu">
                                <i class="far fa-circle" id="icone-menu"></i> Relatório diario
                            </router-link>
                            <router-link :to="{ name: 'relatorio-mensal' }" class="list-group-item list-group-item-action relatorios-menu">
                                <i class="far fa-circle" id="icone-menu"></i> Relatório mensal
                            </router-link>
                        </div>
                    </template>
                    
                    <template v-slot:pagina>
                        <router-view></router-view>
                    </template>   
                </navegacao>
            </div>
            <!-- JS -->
            <script src="{{ asset('js/app.js') }}"></script>

            <script>
                $("#menu-toggle").click(function(e) {
                    e.preventDefault();
                    $("#wrapper").toggleClass("toggled");
                });

                $("#menu-relatorios").click(function(e) {
                    $("#icone-seta").toggleClass("fa-angle-right fa-angle-down");
                });
            </script>
        @endauth
    </body>
</html>
