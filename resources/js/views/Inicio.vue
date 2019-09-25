<template>
    <pagina>
        <div class="col-md-4">
            <links-inicio v-if="erro.vendas" titulo="Vendas" classe="primary" icone="fa fa-shopping-cart" link="vendas"></links-inicio>
            <links-inicio v-else v-for="vendas in totalVendas" v-bind:key="vendas.id" v-bind:dados="vendas.produtos" titulo="Vendas" classe="primary" icone="fa fa-shopping-cart" link="vendas"></links-inicio>
        </div>
        <div class="col-md-4">
            <links-inicio v-if="erro.produtos" titulo="Produtos" classe="success" icone="fa fa-box-open" link="produtos"></links-inicio>
            <links-inicio v-else v-for="produtos in totalProdutos" v-bind:key="produtos.id" v-bind:dados="produtos.codigo" titulo="Produtos" classe="success" icone="fa fa-box-open" link="produtos"></links-inicio>
        </div>
        <div class="col-md-4">
            <links-inicio v-if="erro.categorias" titulo="Categorias" classe="danger" icone="fa fa-folder" link="categorias"></links-inicio>
            <links-inicio v-else v-for="categorias in totalCategorias" v-bind:key="categorias.id" v-bind:dados="categorias.nome" titulo="Categorias" classe="danger" icone="fa fa-folder" link="categorias"></links-inicio>
        </div>
        <div class="col-md-6">
            <h4>Últimos produtos cadastrados</h4>
            <div class="alert alert-warning" v-if="carregando">Carregando...</div>
            <div class="alert alert-danger" v-if="erro.listaProdutos">Ocorreu um erro ao obter a lista...</div>
            <tabela v-if="!carregando && !erro.listaProdutos" v-bind:colunas="['Código','Nome','Quantidade', 'Valor', 'Categoria']">
                <tr v-for="(produto, index) in produtosCadastrados.data.slice(0, 5)" v-bind:key="index">
                    <td>{{ produto.codigo }}</td>
                    <td>{{ produto.nome }}</td>
                    <td>{{ produto.qtd }}</td>
                    <td>{{ produto.valor | moeda }}</td>
                    <td>{{ produto.categoria }}</td>
                </tr>
            </tabela>
            <router-link :to="{ name: 'produtos' }" class="btn btn-primary">Ver todos os produtos cadastrados</router-link>
        </div>
        <div class="col-md-6">
            <grafico></grafico>
        </div>
    </pagina>
</template>

<script>

import venda from "@/js/services/venda";
import produto from "@/js/services/produto";
import categoria from "@/js/services/categoria";

export default {
    data() {
        return {
            totalVendas: '',
            totalProdutos: '',
            totalCategorias: '',
            erro: {
                vendas: false,
                produtos: false,
                categorias: false,
                listaProdutos: false
            },
            carregando: true,
            produtosCadastrados: []
        }
    },
    methods: {
        vendas: function () {
            var vm = this;
            venda.numeroVendas().then(function (response) {
                vm.totalVendas = response.data;
            }).catch(function () {
                vm.erro.vendas = true;
            })
        },
        produtos: function () {
            var vm = this;
            produto.numeroProdutos().then(function (response) {
                vm.totalProdutos = response.data;
            }).catch(function () {
                vm.erro.produtos = true;
            })
        },
        categorias: function () {
            var vm = this;
            categoria.numeroCategorias().then(function (response) {
                vm.totalCategorias = response.data;
            }).catch(function () {
                vm.erro.categorias = true;
            })
        },

        listaProdutos: function () {
            var vm = this;
            produto.lista().then(function (response) {
                vm.produtosCadastrados = response.data;
            }).catch(function () {
                vm.erro.listaProdutos = true;
            }).finally(function () {
                vm.carregando = false;
            })
        }
    },
    mounted() {
        this.vendas();
        this.produtos();
        this.categorias();
        this.listaProdutos();
    }
}
</script>