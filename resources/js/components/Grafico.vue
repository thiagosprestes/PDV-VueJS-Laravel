<script>
import { Bar } from 'vue-chartjs';
import relatorio from '@/js/services/relatorio';

export default {
    extends: Bar,
    data() {
        return {
            dados: [],
            vendas: [],
            legenda: []
        }
    },
    mounted() {
        var vm = this;
        relatorio.diario().then(function (response) {
            vm.dados = response.data;
            if(vm.dados) {
                vm.vendas = vm.dados.data.map(venda => venda.produtos)
                vm.legenda = vm.dados.data.map(legenda => legenda.dias)
                vm.renderChart({
                    labels: vm.legenda.slice(0, 5),
                    datasets: [{
                        label: 'Vendas diárias',
                        backgroundColor: '#3490dc',
                        data: vm.vendas.slice(0, 5)
                    }]
                }, {responsive: true, maintainAspectRatio: false})
            }
        });            
    }
}
</script>