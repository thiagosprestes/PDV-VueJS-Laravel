<template>
    <div class="d-flex" id="wrapper">
        <div class="bg-dark" id="sidebar-wrapper">
            <div class="sidebar-heading">PDV </div>
            <div class="list-group list-group-flush">
                <slot name="menu"></slot>
            </div>
        </div>
        <div id="page-content-wrapper">
            <nav class="navbar navbar-expand-lg navbar-dark bg-primary border-bottom" id="navbar">
                <button class="btn btn-primary" id="menu-toggle">
                    <i class="fa fa-bars"></i>
                </button>

                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" v-on:click="sair()" href="#"><i class="fa fa-user"></i> Sair</a>                                               
                        </li>
                    </ul>
                </div>
            </nav>
            <slot name="pagina"></slot>
        </div>
    </div>
</template>

<script>

import Axios from "axios";

export default {
    methods: {
        sair: function () {
            Axios.post('logout').then(function (response) {
                window.location.href = '/';
            });
        }
    }
}
</script>

<style>
    body {
        overflow-x: hidden;
    }

    #navbar {
        margin-bottom: 1%;
    }

    #sidebar-wrapper {
        min-height: 100vh;
        margin-left: -15rem;
        -webkit-transition: margin .25s ease-out;
        -moz-transition: margin .25s ease-out;
        -o-transition: margin .25s ease-out;
        transition: margin .25s ease-out;
    }

    #sidebar-wrapper .sidebar-heading {
        padding: 0.750rem 1.25rem;
        font-size: 1.2rem;
        background-color: #3490dc !important;
        color: #fff;
    }

    #sidebar-wrapper .list-group {
        width: 15rem;
    }

    #page-content-wrapper {
        min-width: 100vw;
    }

    #wrapper.toggled #sidebar-wrapper {
        margin-left: 0;
    }

    .bg-dark {
        background-color: #222d32 !important;
        color: #b8c7ce;
    }

    a.bg-dark:hover, a.bg-dark:focus, button.bg-dark:hover, button.bg-dark:focus {
        background-color: #1e282c !important;
        color: #fff;
    }

    .list-group-item {
        border: none;
    }

    #icone-menu {
        margin-right: 8px;
    }

    .router-link-exact-active {
        background-color:#1e282c !important;
        color: #fff;
        border-left: 3px solid #3490dc !important;
    }

    .relatorios-menu {
        background-color: #2c3b41;
        color: #8aa4af;
    }

    .relatorios-menu:hover {
        background-color: #2c3b41;
        color: #fff;
    }

    #relatorios .router-link-exact-active {
        background-color:#2c3b41 !important;
        color: #fff;
        border-left: 0 !important;
    }

    @media (min-width: 768px) {
        #sidebar-wrapper {
            margin-left: 0;
        }

        #page-content-wrapper {
            min-width: 0;
            width: 100%;
        }

        #wrapper.toggled #sidebar-wrapper {
            margin-left: -15rem;
        }
    }
</style>