import Axios from "axios";

export default {
    cadastra: function (data) {
        return Axios.post('produtos', data);
    },

    lista: function (page) {
        return Axios.get('produtos?page=' + page);
    },

    atualiza: function (id, data) {
        return Axios.put('produtos/' + id, data);
    },

    apaga: function (id) {
        return Axios.delete('produtos/' + id);
    },

    numeroProdutos: function () {
        return Axios.get('numero-produtos');
    }
}
