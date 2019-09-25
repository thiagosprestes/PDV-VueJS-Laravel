import Vue from "vue";
import VueRouter from "vue-router";
import painel from "@/js/views/Inicio.vue";
import produtos from "@/js/views/Produtos.vue";
import registrarvenda from "@/js/views/RegistrarVenda.vue";
import categorias from "@/js/views/Categorias.vue";
import vendas from "@/js/views/vendas.vue";
import relatoriodiario from "@/js/views/relatorioDiario.vue";
import relatoriomensal from "@/js/views/RelatorioMensal.vue";

Vue.use(VueRouter);

const router = new VueRouter({
    routes: [
        {
            path: '/',
            redirect: {
                name: 'painel'
            }
        },
        {
            path: '/painel',
            name: 'painel',
            component: painel
        },
        {
            path: '/painel/produtos',
            name: 'produtos',
            component: produtos
        },
        {
            path: '/painel/registrar-venda',
            name: 'registrar-venda',
            component: registrarvenda
        },
        {
            path: '/painel/categorias',
            name: 'categorias',
            component: categorias
        },
        {
            path: '/painel/vendas',
            name: 'vendas',
            component: vendas
        },
        {
            path: '/painel/relatorios/relatorio-diario',
            name: 'relatorio-diario',
            component: relatoriodiario
        },
        {
            path: '/painel/relatorios/relatorio-mensal',
            name: 'relatorio-mensal',
            component: relatoriomensal
        }
    ]
}) 

export default router;
