<template>
    <pagina>
        <div class="col-md-12">
            <acoes titulobotao="Adicionar produto" modal="modal-adicionar" v-bind:termodebusca="busca" v-on:input="busca = $event"></acoes>

            <div v-if="loader.produtos" class="alert alert-warning">Carregando lista...</div>

            <div v-if="erro.status" class="alert alert-danger">Ocorreu um erro ao obter dados...</div>

            <div v-if="validacaoApi.codigo" class="alert alert-danger">{{ validacaoApi.codigo | toString }}</div>

            <mensagem v-if="msg.status" v-bind:tipo="msg.tipo">{{msg.texto}}</mensagem>

            <tabela v-if="produtos != '' && !loader.produtos && !erro.status" v-bind:colunas="['#', 'Código','Nome','Quantidade','Valor','Categoria','Data', 'Ações']" v-bind:filtro="busca">
                <tr v-for="(produto, index) in filtrar" v-bind:key="index">
                    <td>{{ produto.id }}</td>
                    <td>{{ produto.codigo }}</td>
                    <td>{{ produto.nome }}</td>
                    <td>{{ produto.qtd }}</td>
                    <td>{{ produto.valor | moeda }}</td>
                    <td>{{ produto.categoria }}</td>
                    <td>{{ produto.data }}</td>
                    <td>
                        <button class="btn btn-warning" data-toggle="modal" v-on:click="editar(produto)">Editar</button>
                        <button class="btn btn-danger" v-on:click="deletar(produto.id)">Excluir</button>
                    </td>
                </tr>
            </tabela>

            <pagination :data="produtos" @pagination-change-page="listar"></pagination>

            <div class="alert alert-warning" v-if="produtos == '' && !loader.produtos">Nenhum produto foi cadastrado</div>

            <modal nome="modal-adicionar" v-on:acao="adicionar(produto)" titulo="Adicionar produto" textobotao="Registrar">                         
                <div class="form-group row">
                    <div class="col-md-12" :class="{ invalid: statusForm == false && $v.produto.codigo
                .$invalid }">
                        <label for="codigo">Código de barras</label>
                        <input type="text" name="codigo" id="codigo" placeholder="Código de barras" class="form-control" v-bind:class="{ invalid: statusForm == false && $v.produto.codigo.$dirty && $v.produto.codigo.$invalid }" v-model="$v.produto.codigo.$model">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-6" :class="{ invalid: statusForm == false && $v.produto.nome
                .$invalid }">
                        <label for="nome">Nome</label>
                        <input type="text" name="nome" id="nome" placeholder="Nome do produto" class="form-control" v-bind:class="{ invalid: statusForm == false && $v.produto.nome.$dirty && $v.produto.nome.$invalid }" v-model="$v.produto.nome.$model">
                    </div>
                    <div class="col-md-3" :class="{ invalid: statusForm == false && $v.produto.qtd
                .$invalid }">
                        <label for="qtd">Quantidade</label>
                        <input type="text" name="qtd" id="qtd" placeholder="Quantidade" class="form-control" v-bind:class="{ invalid: statusForm == false && $v.produto.qtd.$dirty && $v.produto.qtd.$invalid }" v-model="$v.produto.qtd.$model">
                    </div>
                    <div class="col-md-3" :class="{ invalid: statusForm == false && $v.produto.valor
                .$invalid }">
                        <label for="valor">Valor</label>
                        <input type="text" name="valor" id="valor" placeholder="Valor" class="form-control" v-bind:class="{ invalid: statusForm == false && $v.produto.valor.$dirty && $v.produto.valor.$invalid }" v-model="$v.produto.valor.$model">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-12" :class="{ invalid: statusForm == false && $v.produto.categoria
                .$invalid }">
                        <div class="alert alert-danger" v-if="categorias == ''">Não existem categorias cadastradas, cadastre uma nova categoria para cadastrar um produto</div>

                        <label for="categoria">Categoria</label>
                        <select name="categoria" id="categoria" class="form-control" v-bind:class="{ invalid: statusForm == false && $v.produto.categoria.$dirty && $v.produto.categoria.$invalid }" v-model="$v.produto.categoria.$model">
                            <option value="" disabled>Selecione uma categoria</option>
                            <option v-for="(categoria, index) in categorias" v-bind:key="index" v-show="categorias != ''" >{{ categoria.nome }}</option>
                        </select>
                    </div>
                </div>
                <div v-if="statusForm == false && $v.produto.$invalid" class="alert alert-danger">Preencha todos os campos da forma correta para registrar um novo produto</div>
                <div v-if="statusForm == false && $v.produto.qtd.$invalid" class="alert alert-danger">Por favor, preencha o campo quantidade com um número válido</div>
                <div v-if="statusForm == false && $v.produto.valor.$invalid" class="alert alert-danger">Por favor, preencha o campo valor com um número válido</div>
            </modal>

            <modal nome="modal-editar" v-on:acao="adicionar(produto)" titulo="Editar produto" textobotao="Salvar alterações">                         
                <div class="form-group row">
                    <div class="col-md-12" :class="{ invalid: statusForm == false && $v.produto.codigo
                .$invalid }">
                        <label for="codigo">Código de barras</label>
                        <input type="text" name="codigo" id="codigo" placeholder="Código de barras" class="form-control" v-bind:class="{ invalid: statusForm == false && $v.produto.codigo.$dirty && $v.produto.codigo.$invalid }" v-model="$v.produto.codigo.$model">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-6" :class="{ invalid: statusForm == false && $v.produto.nome
                .$invalid }">
                        <label for="nome">Nome</label>
                        <input type="text" name="nome" id="nome" placeholder="Nome do produto" class="form-control" v-bind:class="{ invalid: statusForm == false && $v.produto.nome.$dirty && $v.produto.nome.$invalid }" v-model="$v.produto.nome.$model">
                    </div>
                    <div class="col-md-3" :class="{ invalid: statusForm == false && $v.produto.qtd
                .$invalid }">
                        <label for="qtd">Quantidade</label>
                        <input type="text" name="qtd" id="qtd" placeholder="Quantidade" class="form-control" v-bind:class="{ invalid: statusForm == false && $v.produto.qtd.$dirty && $v.produto.qtd.$invalid }" v-model="$v.produto.qtd.$model">
                    </div>
                    <div class="col-md-3" :class="{ invalid: statusForm == false && $v.produto.valor
                .$invalid }">
                        <label for="valor">Valor</label>
                        <input type="text" name="valor" id="valor" placeholder="Valor" class="form-control" v-bind:class="{ invalid: statusForm == false && $v.produto.valor.$dirty && $v.produto.valor.$invalid }" v-model="$v.produto.valor.$model">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-12" :class="{ invalid: statusForm == false && $v.produto.categoria
                .$invalid }">
                        <div class="alert alert-danger" v-if="categorias == ''">Não existem categorias cadastradas, cadastre uma nova categoria para cadastrar um produto</div>

                        <label for="categoria">Categoria</label>
                        <select name="categoria" id="categoria" class="form-control" v-bind:class="{ invalid: statusForm == false && $v.produto.categoria.$dirty && $v.produto.categoria.$invalid }" v-model="$v.produto.categoria.$model">
                            <option value="" disabled>Selecione uma categoria</option>
                            <option v-for="(categoria, index) in categorias" v-bind:key="index" v-show="categorias != ''" >{{ categoria.nome }}</option>
                        </select>
                    </div>
                </div>
                <div v-if="statusForm == false && $v.produto.$invalid" class="alert alert-danger">Preencha todos os campos da forma correta para registrar um novo produto</div>
                <div v-if="statusForm == false && $v.produto.qtd.$invalid" class="alert alert-danger">Por favor, preencha o campo quantidade com um número válido</div>
                <div v-if="statusForm == false && $v.produto.valor.$invalid" class="alert alert-danger">Por favor, preencha o campo valor com um número válido</div>
            </modal>
        </div>
    </pagina>
</template>

<script>

import produto from "@/js/services/produto";
import categoria from "@/js/services/categoria";
import { required, minlength, between, decimal, helpers } from "vuelidate/lib/validators";
const currency = helpers.regex('currency', /[\t ]*((\d{1,3}\.?)+(,\d{2})?)/);

export default {
    data() {
        return {
            produtos: {},
            categorias: [],
            produto: {
                codigo: '',
                nome: '',
                qtd: '',
                valor: '',
                categoria: ''
            },
            busca: '',
            loader: {
                produtos: false
            },
            erro: {
                status: false
            },
            msg: {
                status: false,
                tipo: '',
                texto: ''
            },
            statusForm: null,
            validacaoApi: []
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
        selecionaCategoria: function () {
          var vm = this;
          categoria.nomeCategorias().then(function (response) {
              vm.categorias = response.data;
          })  
        },
        adicionar: function (data) {
            var vm = this;
            if (!this.$v.$invalid) {
                this.statusForm = true;
                if (vm.produto.id) {
                    produto.atualiza(data.id, data).then(function (response) {
                        vm.produto = {};
                        vm.$v.$reset();
                        vm.listar();
                        $('#modal-editar').modal('hide');
                        vm.mensagem(true, 'sucesso', 'Alterações salvas com sucesso');
                    }).catch(function (error) {
                        vm.validacaoApi = error.response.data.errors;
                        vm.produto = {};
                        vm.$v.$reset();
                        $('#modal-editar').modal('hide');
                        vm.mensagem(true, 'erro', 'Ocorreu um erro ao salvar as alterações feitas no produto');
                    })
                } else {
                    produto.cadastra(data).then(function (response) {
                        vm.produto = {};
                        vm.$v.$reset();
                        vm.listar();
                        $('#modal-adicionar').modal('hide');
                        vm.mensagem(true, 'sucesso', 'Produto registrado com sucesso');
                    }).catch(function (error) {
                        vm.validacaoApi = error.response.data.errors;
                        vm.produto = {};
                        vm.$v.$reset();
                        $('#modal-adicionar').modal('hide');
                        vm.mensagem(true, 'erro', 'Ocorreu um erro ao registrar o produto');
                    })
                }
            } else {
                this.statusForm = false;
            }
        },
        listar: function (page = 1) {
            var vm = this;
            this.loader.produtos = true;
            produto.lista(page).then(function (response) {
                vm.produtos = response.data;
            }).catch(function () {
                vm.erro.status = true;
            })
            .finally(function () {
                vm.loader.produtos = false;
            })
        }, 
        editar: function (data) {
            var vm = this;
            vm.produto = data;
            $('#modal-editar').modal('show');
            vm.selecionaCategoria();
        }, 
        deletar: function (id) {
            var vm = this;
            if (confirm("Tem certeza que deseja excluir este item?")) {
                produto.apaga(id).then(function (response) {
                    vm.listar();
                    vm.mensagem(true, 'sucesso', 'Produto excluído com sucesso');
                }).catch(function () {
                    vm.mensagem(true, 'erro', 'Ocorreu um erro ao excluír o produto');
                })
            }
        }  
    },
    computed: {
        filtrar: function() {
            if(!this.busca) return this.produtos.data;
            return this.produtos.data.filter((dado) => {
                return dado.nome.toLowerCase().includes(this.busca.toLowerCase());
            })
        }
    },
    validations: {
        produto: {
            codigo: { required },
            nome: { required },
            qtd: { required, between: between(0, 100000) },
            valor: { required, currency },
            categoria: { required }
        }
    },
    mounted() {
        this.listar();
        this.selecionaCategoria();
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