import Axios from "axios";

export default {
    diario: function (page) {
        return Axios.get('relatorio-diario?page=' + page);
    },
    
    mensal: function (page) {
        return Axios.get('relatorio-mensal?page=' + page);
    }
}