<template>
    <pagina>
        <div class="col-md-12">
            <div class="form-group">
                <painel>
                    <form @submit.prevent="listarProduto(codigo)">
                        <div class="form-group" v-bind:class="{ invalid: statusForm == false && $v.codigo.$invalid }">
                            <input type="text" name="codigo" id="codigo" placeholder="Código de barras do produto" class="form-control" v-model="$v.codigo.$model">
                        </div>
                        <div v-if="statusForm == false && $v.codigo.$invalid" class="alert alert-danger">Por favor, digite um código de barras válido antes de registrar o produto</div>
                        <button type="submit" class="btn btn-primary btn-block">Registrar</button>
                    </form>
                </painel>
            </div>
            <div v-if="msg.status && msg.tipo == 'sucesso'" class="alert alert-success">{{ msg.texto }}</div>
            <div v-if="msg.status && msg.tipo == 'erro'" class="alert alert-danger">{{ msg.texto }}</div>

            <tabela v-if="produtos.status" v-bind:colunas="['Código','Nome do produto','Categoria','Valor','']">
                <tr v-for="(produto, index) in produtos" v-bind:key="index">
                    <td>{{ produto.codigo }}</td>
                    <td>{{ produto.nome }}</td>
                    <td>{{ produto.categoria }}</td>
                    <td>{{ produto.valor | moeda }}</td>
                    <td>
                        <button class="btn btn-danger" v-on:click="removerProduto(index)"><i class="fa fa-trash"></i></button>
                    </td>
                </tr>
            </tabela>
        </div>
        <div class="bg-white valor-total" v-if="produtos.status" style="position: fixed">
            <h4>TOTAL: {{ produtosTotal | moeda }}</h4>
            <button class="btn btn-danger" data-toggle="modal" data-target="#modal-venda">Finalizar venda</button>
        </div>

        <modal nome="modal-venda" v-on:acao="fecharVenda(produtosNome, produtosTotal, venda)" titulo="Finalizar venda" textobotao="Registrar venda">
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-info"><b>Atenção</b>: os campos com <b>*</b> são  obrigatórios.</div>
                </div>
                </div>
            <div class="form-group row">
                <div class="col-md-12">
                    <label for="cliente">Cliente*</label>
                    <input type="text" name="cliente" id="cliente" placeholder="Nome do cliente" class="form-control" v-model="venda.cliente" required>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-6" :class="{ 'col-md-12': venda.pagamento != 'Dinheiro'}">
                    <label for="pagamento">Método de pagamento*</label>
                    <select name="pagamento" id="pagamento" class="form-control" v-model="venda.pagamento" required>
                        <option value="" disabled>Selecione um método de pagamento</option>
                        <option value="Dinheiro">Dinheiro</option>
                        <option value="Cartão de débito">Cartão de débito</option>
                        <option value="Cartão de crédito">Cartao de crédito</option>
                    </select>
                </div>
                <div class="col-md-6" v-if="venda.pagamento == 'Dinheiro'">
                    <label for="recebido">Valor recebido</label>
                    <input type="text" name="recebido" id="recebido" placeholder="Valor recebido" class="form-control" v-model="venda.recebido">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-12">
                    <label for="observacoes">Observações da venda</label>
                    <textarea name="observacoes" id="observacoes" cols="10" rows="5" class="form-control" placeholder="Observações da venda" v-model="venda.observacoes"></textarea>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-12">
                    <label for="status">Status da venda*</label>
                    <input type="text" name="status" id="status" placeholder="Status da venda" class="form-control" v-model="venda.status" required>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-12">
                    <h4>TOTAL: {{ produtosTotal | moeda }}</h4>
                    <h4 v-if="venda.recebido">VALOR DO TROCO: {{ parseFloat(venda.recebido.replace(',', '.')) - parseFloat(produtosTotal) | moeda }}</h4>
                </div>
            </div>
        </modal>
    </pagina>
</template>

<script>

import produtosVenda from "@/js/services/produtosVenda";
import venda from "@/js/services/venda";
import { required } from "vuelidate/lib/validators";

export default {
    data() {
        return {
            codigo: '',
            msg: {
                status: false,
                tipo: '',
                texto: ''
            },
            venda: {
                cliente: 'Não identificado',
                pagamento: '',
                recebido: '',
                observacoes: '',
                status: 'Ok'
            },
            produtos: [],
            produtosTotal: '',
            produtosNome: [],
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
        listarProduto: function(codigo) {
            var vm = this;
            if (!this.$v.$invalid) {
                this.statusForm = true;
                produtosVenda.listar(codigo).then(function (response) {
                    if (!response.data.length) {
                        vm.mensagem(true, 'erro', 'Código de barras não encontrado');
                        vm.codigo = '';
                    } else {
                        vm.produtos = vm.produtos.concat(response.data);
                        vm.produtos.status = true;
                        vm.codigo = '';
                        vm.produtosTotal = vm.produtos.reduce((sum, total) => parseFloat(sum) + parseFloat(total.valor), 0);

                        vm.produtosNome = vm.produtos.map(produto => produto.nome);                        
                    }
                }).catch(function () {
                    vm.mensagem(true, 'erro', 'Ocorreu um erro ao obter os dados');
                    vm.codigo = '';
                })
            } else {
                this.statusForm = false;
            }
        },
        removerProduto: function (index) {
            this.produtos.splice(index, 1);
            this.produtosNome.splice(index, 1);

            this.produtosTotal = this.produtos.reduce((sum, total) => parseFloat(sum) - parseFloat(total.valor), 0);

            this.produtosTotal = this.produtosTotal * -1;

            if (this.produtos.length == 0) {
                this.produtos.status = false;
            }
        },
        fecharVenda: function (produtosNome, totalVenda, dadosVenda) {
            var vm = this;
            var nomeQtd = {};
            produtosNome.forEach(function(x) { 
                nomeQtd[x] = (nomeQtd[x] || 0)+1;
            });

            var nomeQtdString = JSON.stringify(nomeQtd).replace(/[{}""]/g, '');
                    
            produtosNome = nomeQtdString;

            //console.log(produtosNome);
            
            venda.cria(produtosNome, totalVenda, dadosVenda).then(function (response) {
                vm.produtos = [];
                $('#modal-venda').modal('hide');
                vm.mensagem(true, 'sucesso', 'Venda registrada com sucesso');
            })
        }
    },
    validations: {
        codigo: { required }
    },
    mounted() {
        $(window).scroll(function () {
            var posicaoAtual = $(window).scrollTop();
            var tamanhoTotal = $(document).height();
            var tamanhoJanela = $(window).height();

            if (posicaoAtual >= (tamanhoTotal - tamanhoJanela)) {
                $('.valor-total').css('position', 'relative');
            }
        })
    }
}
</script>

<style>
    .valor-total {
        border-top: 1px solid #cecece;
        bottom: 0;
        width: 100%;
        padding: 10px;
    }

    .valor-total h4 {
        font-weight: bold;
    }

    .invalid input {
        border-color: 1px solid red;
    }
</style>
