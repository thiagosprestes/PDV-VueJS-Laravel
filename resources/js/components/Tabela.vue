<template>
    <table class="table table-bordered table-responsive-md">
        <thead>
            <tr>
                <th v-for="(coluna, index) in colunas" v-bind:key="index">{{coluna}}</th>
            </tr>
        </thead>
        <tbody>
            <slot></slot>
        </tbody>
    </table>
</template>

<script>
export default {
    props: ['colunas', 'filtro'],
}
</script>