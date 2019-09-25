<template>
    <div v-bind:class="'alert alert-' + mudaCor">
        <slot></slot>
    </div>
</template>

<script>
export default {
    props: ['tipo'],
    computed: {
        mudaCor: function () {
            if (this.tipo == 'sucesso') {
                return 'success'; 
            } else if (this.tipo == 'erro') {
                return 'danger';
            } else if (this.tipo == 'carregando') {
                return 'warning';
            }
        }
    }
}
</script>