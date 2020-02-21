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
                        <button class="btn btn-warning" data-toggle="modal" v-on:click="editar(venda)">Editar</button>
                        <button class="btn btn-danger" v-on:click="deletar(venda.id)">Excluir</button>
                    </td>
                </tr>
            </tabela>

            <pagination :data="vendas" @pagination-change-page="listar"></pagination>

            <div class="alert alert-warning" v-if="vendas == '' && !loader.vendas">Nenhuma venda foi registrada</div>

            <modal nome="modal-editar" v-on:acao="adicionar(venda)" titulo="Editar status da venda" textobotao="Salvar alterações">                         
                <div class="form-group row">
                    <div class="col-md-12" :class="{ invalid: statusForm == false && $v.venda.status.$invalid }">
                        <label for="codigo">Status</label>
                        <input type="text" name="codigo" id="codigo" placeholder="Código de barras" class="form-control" v-bind:class="{ invalid: statusForm == false && $v.venda.status.$dirty && $v.venda.status.$invalid }" v-model="$v.venda.status.$model">
                    </div>
                </div>
                <div v-if="statusForm == false && $v.venda.$invalid" class="alert alert-danger">Preencha todos os campos da forma correta para registrar um novo produto</div>
            </modal>
        </div>
    </pagina>
</template>

<script>

import venda from "@/js/services/venda";
import { required } from 'vuelidate/lib/validators'

export default {
    data() {
        return {
            vendas: {},
            venda: {
                status: ''
            },
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
            },
            statusForm: null
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
        adicionar: function (data) {
            var vm = this;
            if (!this.$v.$invalid) {
                this.statusForm = true;
                if (vm.venda.id) {
                    venda.atualiza(data.id, data).then((response) => {
                        vm.venda = {};
                        vm.$v.$reset();
                        vm.listar();
                        $('#modal-editar').modal('hide');
                        vm.mensagem(true, 'sucesso', 'Alterações salvas com sucesso');
                    }).catch((error) => {
                        vm.venda = {};
                        vm.$v.$reset();
                        $('#modal-editar').modal('hide');
                        vm.mensagem(true, 'erro', 'Ocorreu um erro ao salvar as alterações');
                    })
                }
            } else {
                this.statusForm = false;
            }
        },
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
    validations: {
        venda: {
            status: { required }
        }
    },
    mounted() {
        this.listar();
    }
}
</script>
