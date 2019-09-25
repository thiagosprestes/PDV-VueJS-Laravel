<template>
    <pagina>
        <div class="col-md-12">
            <div class="form-group" style="overflow:auto">
                <div class="float-left">
                    <router-link :to="{ name: 'registrar-venda' }" class="btn btn-primary">Registrar venda</router-link>
                </div>
                <div class="float-right">
                    <input type="text" name="busca" id="busca" placeholder="Digite um nome..." class="form-control" v-model="busca">
                </div>
            </div>
            <div v-if="loader.vendas" class="alert alert-warning">Carregando lista...</div>

            <div v-if="erro.status" class="alert alert-danger">Ocorreu um erro ao obter dados...</div>

            <mensagem v-if="msg.status" v-bind:tipo="msg.tipo">{{msg.texto}}</mensagem>

            <tabela v-if="vendas != '' && !loader.vendas && !erro.status" v-bind:colunas="['#', 'Cliente', 'Produtos e quantidade','Total', 'Forma de pagamento', 'Observações', 'Status', 'Data','Ação']" v-bind:filtro="busca">
                <tr v-for="(venda, index) in filtrar" v-bind:key="index">
                    <td>{{ venda.id }}</td>
                    <td>{{ venda.cliente }}</td>
                    <td>{{ venda.produtos }}</td>
                    <td>{{ venda.total | moeda }}</td>
                    <td>{{ venda.pagamento }}</td>
                    <td>{{ venda.observacoes }}</td>
                    <td>{{ venda.status }}</td>
                    <td>{{ venda.data }}</td>
                    <td>
                        <button class="btn btn-danger" v-on:click="deletar(venda.id)">Excluir</button>
                    </td>
                </tr>
            </tabela>

            <pagination :data="vendas" @pagination-change-page="listar"></pagination>

            <div class="alert alert-warning" v-if="vendas == '' && !loader.vendas">Nenhuma venda foi registrada</div>
        </div>
    </pagina>
</template>

<script>

import venda from "@/js/services/venda";

export default {
    data() {
        return {
            vendas: {},
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
            if(!this.busca) return this.vendas.data;
            return this.vendas.data.filter((dado) => {
                return dado.produtos.toLowerCase().includes(this.busca.toLowerCase());
            });
        }
    },
    methods: {
        mensagem: function (status, tipo, texto) {
            this.msg.status = status;
            this.msg.tipo = tipo;
            this.msg.texto = texto;
            setTimeout(() => {
                this.msg.status = false;
            }, 5000);
        },
        listar: function (page = 1) {
            var vm = this;
            this.loader.vendas = true;
            venda.lista(page).then(function (response) {
                vm.vendas = response.data;
            }).catch(function () {
                vm.erro.status = true;
            })
            .finally(function () {
                vm.loader.vendas = false;
            })
        }, 
        editar: function (data) {
            var vm = this;
            vm.venda = data;
            $('#modal-editar').modal('show');
        }, 
        deletar: function (id) {
            var vm = this;
            if (confirm("Tem certeza que deseja excluir este item?")) {
                venda.apaga(id).then(function (response) {
                    vm.listar();
                    vm.mensagem(true, 'sucesso', 'Venda excluída com sucesso');
                }).catch(function () {
                    vm.mensagem(true, 'erro', 'Ocorreu um erro ao excluír a venda');
                })
            }
        }  
    },
    mounted() {
        this.listar();
    }
}
</script>
