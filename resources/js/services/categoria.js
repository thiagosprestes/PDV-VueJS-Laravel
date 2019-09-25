import Axios from "axios";

export default {
    cadastra: function (data) {
        return Axios.post('categorias', data);
    },

    lista: function (page) {
        return Axios.get('categorias?page=' + page);
    },

    atualiza: function (id, data) {
        return Axios.put('categorias/' + id, data);
    },

    apaga: function (id) {
        return Axios.delete('categorias/' + id);
    },

    numeroCategorias: function () {
        return Axios.get('numero-categorias');
    },

    nomeCategorias: function () {
        return Axios.get('categorias-produtos');
    }
}
