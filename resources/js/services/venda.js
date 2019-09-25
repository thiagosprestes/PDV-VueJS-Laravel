import Axios from "axios";

export default {
    cria: function (produtosNome, totalVenda, dadosVenda) {
        return Axios.post('vendas', { 
            produtos: produtosNome, 
            total: totalVenda, 
            cliente: dadosVenda.cliente,
            observacoes: dadosVenda.observacoes,
            pagamento: dadosVenda.pagamento,
            recebido: dadosVenda.recebido,
            status: dadosVenda.status 
        });
    },

    lista: function (page) {
        return Axios.get('vendas?page=' + page);
    },

    atualiza: function (id, data) {
        return Axios.put('vendas/' + id, data);
    },

    apaga: function (id) {
        return Axios.delete('vendas/' + id);
    },

    numeroVendas: function () {
        return Axios.get('numero-vendas');
    }
}