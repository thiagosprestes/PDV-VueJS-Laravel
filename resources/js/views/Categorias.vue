<template>
    <pagina>
        <div class="col-md-12">
            <acoes titulobotao="Adicionar categoria" modal="modal-adicionar" v-bind:termodebusca="busca" v-on:input="busca = $event"></acoes>

            <div v-if="loader.categorias" class="alert alert-warning">Carregando lista...</div>

            <div v-if="erro.status" class="alert alert-danger">Ocorreu um erro ao obter dados...</div>

            <mensagem v-if="msg.status" v-bind:tipo="msg.tipo">{{msg.texto}}</mensagem>

            <tabela v-if="categorias != '' && !loader.categorias && !erro.status" v-bind:colunas="['#', 'Nome','Data', 'Ações']" v-bind:filtro="busca">
                <tr v-for="(categoria, index) in filtro" v-bind:key="index">
                    <td>{{ categoria.id }}</td>
                    <td>{{ categoria.nome }}</td>
                    <td>{{ categoria.data }}</td>
                    <td>
                        <button class="btn btn-warning" v-on:click="editar(categoria)">Editar</button>
                        <button class="btn btn-danger" v-on:click="deletar(categoria.id)">Excluir</button>
                    </td>
                </tr>
            </tabela>

            <pagination :data="categorias" @pagination-change-page="listar"></pagination>

            <div class="alert alert-warning" v-if="categorias == '' && !loader.categorias">Nenhuma categoria foi cadastrada</div>

            <modal nome="modal-adicionar" v-on:acao="adicionar(categoria)" titulo="Adicionar categoria" textobotao="adicionar">                                
                <div class="form-group row">
                    <div class="col-md-12" v-bind:class="{ invalid: statusForm == false && $v.categoria.nome.$invalid }">
                        <label for="nome">Nome da categoria</label>
                        <input type="text" name="nome" id="nome" placeholder="Nome da categoria" class="form-control" v-model="$v.categoria.nome.$model">
                    </div>
                </div>
                <div v-if="statusForm == false && $v.categoria.nome.$invalid" class="alert alert-danger">Insira um nome para registrar a categoria</div>
            </modal>

            <modal nome="modal-editar" v-on:acao="adicionar(categoria)" titulo="Editar categoria" textobotao="Salvar alterações">                               
                <div class="form-group row">
                    <div class="col-md-12" v-bind:class="{ invalid: statusForm == false &&  $v.categoria.nome.$invalid }">
                        <label for="nome">Nome da categoria</label>
                        <input type="text" name="nome" id="nome" placeholder="Nome da categoria" class="form-control" v-model="$v.categoria.nome.$model">
                    </div>
                </div>
                <div v-if="statusForm == false && $v.categoria.nome.$invalid" class="alert alert-danger">Insira um nome para registrar a categoria</div>
            </modal>
        </div>
    </pagina>
</template>

<script>

import categoria from "@/js/services/categoria";
import { required } from "vuelidate/lib/validators";

export default {
    data() {
        return {
            categorias: {},
            categoria: {
                nome: '',
            },
            busca: '',
            loader: {
                categorias: false
            },
            erro: {
                status: false
            },
            msg: {
                status: false,
                tipo: '',
                texto: '',
            },
            statusForm: null
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
                if (vm.categoria.id) {
                    categoria.atualiza(data.id, data).then(function (response) {
                        vm.categoria = {};
                        vm.$v.$reset();
                        vm.listar();
                        $('#modal-editar').modal('hide');
                        vm.mensagem(true, 'sucesso', 'Alterações salvas com sucesso');
                    }).catch(function () {
                        vm.categoria = {};
                        vm.$v.$reset();
                        $('#modal-editar').modal('hide');
                        vm.mensagem(true, 'erro', 'Ocorreu um erro ao salvar as alterações feitas na categoria');
                    })
                } else {
                    categoria.cadastra(data).then(function (response) {
                        vm.categoria = {};
                        vm.$v.$reset();
                        vm.listar();
                        $('#modal-adicionar').modal('hide');
                        vm.mensagem(true, 'sucesso', 'Categoria registrado com sucesso');
                    }).catch(function () {
                        vm.categoria = {};
                        vm.$v.$reset();
                        $('#modal-adicionar').modal('hide');
                        vm.mensagem(true, 'erro', 'Ocorreu um erro ao registrar o categoria');
                    })
                }
            } else {
                this.statusForm = false;
            }
        },
        listar: function (page = 1) {
            var vm = this;
            this.loader.categorias = true;
            categoria.lista(page).then(function (response) {
                vm.categorias = response.data;
            }).catch(function () {
                vm.erro.status = true;
            })
            .finally(function () {
                vm.loader.categorias = false;
            })
        }, 
        editar: function (data) {
            var vm = this;
            vm.categoria = data;
            $('#modal-editar').modal('show');
        }, 
        deletar: function (id) {
            var vm = this;
            if (confirm("Tem certeza que deseja excluir este item?")) {
                categoria.apaga(id).then(function (response) {
                    vm.listar();
                    vm.mensagem(true, 'sucesso', 'Categoria excluída com sucesso');
                }).catch(function () {
                    vm.mensagem(true, 'erro', 'Ocorreu um erro ao excluír esta categoria');
                })
            }
        }  
    },
    computed: {
        filtro: function () {
            if (!this.busca) return this.categorias.data;
            return this.categorias.data.filter((dado) => {
                return dado.nome.toLowerCase().includes(this.busca.toLowerCase());
            })
        }
    },
    validations: {
        categoria: { 
            nome: { required }
        }
    },
    mounted() {
        this.listar();
    }
}
</script>

<style>
    .invalid {
        border-color: red;
    }

    .invalid input, .invalid select {
        border-color: red;
    }

    label {
        font-weight: bold;
    }
</style>