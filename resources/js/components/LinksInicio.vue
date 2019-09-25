<template>
    <div :class="'card text-white bg-' + classe" style="margin-bottom: 10px">
        <div class="card-header">
            <div class="row">
                <div class="col-md-8">
                    <h1 class="dados">{{dados}}</h1>
                    <div>{{titulo}}</div>
                </div>
                <div class="col-md-4" id="icone">
                    <i v-bind:class="icone + ' fa-5x'"></i>
                </div>
            </div>
        </div>
        <div class="card-footer" id="rodape">
            <router-link :to="{ name: link }">
                <div class="float-left">Ver mais</div>
                <div class="float-right"><i class="fa fa-chevron-right"></i></div>
            </router-link>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['dados', 'titulo', 'classe', 'icone', 'link']
    }
</script>

<style>
    .card-title {
        font-size: 3em;
        font-weight: bold;
    }

    .card-link {
        color: #fff;
    }

    .dados {
        font-weight: bold;
    }

    #icone {
        color: rgba(0,0,0,0.15);
    }

    #rodape, #rodape a {
        color: rgba(255,255,255,0.8);
        background: rgba(0,0,0,0.1);
        border-top: none;
    }

    #rodape:hover, #rodape a:hover {
        color: #fff;
        background: rgba(0,0,0,0.15);
        border-top: none;
    }
</style>