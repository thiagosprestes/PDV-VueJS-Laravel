import Axios from "axios";

export default {
    listar: function (codigo) {
        return Axios.get('produtos/' + codigo);
    }
}