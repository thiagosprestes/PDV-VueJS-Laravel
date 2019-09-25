<template>
    <pagina>
        <div class="col-md-12">
            <div class="form-group" style="overflow:auto">
                <div class="float-left">
                    <router-link :to="{ name: 'registrar-venda' }" class="btn btn-primary">Registrar venda</router-link>
                </div>
                <div class="float-right">
                    <input type="text" name="busca" id="busca" placeholder="Digite um data..." class="form-control" v-model="busca">
                </div>
            </div>
            <div v-if="loader.vendas" class="alert alert-warning">Carregando lista...</div>

            <div v-if="erro.status" class="alert alert-danger">Ocorreu um erro ao obter dados...</div>

            <mensagem v-if="msg.status" v-bind:tipo="msg.tipo">{{msg.texto}}</mensagem>

            <tabela v-if="vendasMensais != '' && !loader.vendasMensais && !erro.status" v-bind:colunas="['Mês','Quantidade de vendas','Total em vendas']" v-bind:filtro="busca">
                <tr v-for="(vendaMensal, index) in filtrar" v-bind:key="index">
                    <td>{{ vendaMensal.meseano }}</td>
                    <td>{{ vendaMensal.produtos }}</td>
                    <td>{{ vendaMensal.total | moeda }}</td>
                </tr>
            </tabela>

            <pagination :data="vendasMensais" @pagination-change-page="listar"></pagination>

            <div class="alert alert-warning" v-if="vendasMensais == '' && !loader.vendasMensais">Nenhuma venda foi registrada</div>
        </div>
    </pagina>
</template>

<script>

import relatorio from "@/js/services/relatorio";

export default {
    data() {
        return {
            vendasMensais: {},
            busca: '',
            loader: {
                vendas: false
            },
            erro: {
                status: false
            },
            msg: {
                status: false,
                tipo: '',
                texto: ''
            }
        }
    },
    computed: {
        filtrar: function() {
            if(!this.busca) return this.vendasMensais.data;
            return this.vendasMensais.data.filter((dado) => {
                return dado.meseano.toLowerCase().includes(this.busca.toLowerCase());
            });
        }
    },
    methods: {
        listar: function (page = 1) {
            var vm = this;
            this.loader.vendas = true;
            relatorio.mensal(page).then(function (response) {
                vm.vendasMensais = response.data;
            }).catch(function () {
                vm.erro.status = true;
            })
            .finally(function () {
                vm.loader.vendas = false;
            })
        },
    },
    mounted() {
        this.listar();
    }
}
</script>
