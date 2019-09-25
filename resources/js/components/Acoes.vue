<template>
    <div class="form-group" style="overflow:auto">
        <div class="float-left">
            <button class="btn btn-primary" data-toggle="modal" v-bind:data-target="'#' + modal" v-on:click="acao()">{{ titulobotao }}</button>
        </div>
        <div class="float-right">
            <input type="text" name="busca" id="busca" placeholder="Digite um nome..." class="form-control" v-model="busca">
        </div>
    </div>
</template>

<script>
export default {
    props: ['titulobotao', 'modal', 'termodebusca'],
    methods: {
        acao: function () {
            this.$emit('listaCategorias');
        }
    },
    data() {
        return {
            busca: this.termodebusca
        }
    },
    watch: {
        busca(val) {
            this.$emit('input', val)
        }
    }
}
</script>