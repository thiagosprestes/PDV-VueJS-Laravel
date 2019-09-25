<template>
    <div class="modal fade" v-bind:id="nome" tabindex="-1" role="dialog" aria-labelledby="modal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form @submit.prevent="acaoEnviar()" id="form-modal">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ titulo }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body"> 
                        <slot></slot>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-primary">{{ textobotao }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['nome', 'acaoenviar', 'titulo', 'textobotao'],
    mounted() {
        $('#'+ this.nome).on('hide.bs.modal', function () {
            $('#form-modal input, select').each(function() {
                $(this).val(''); 
            });
        });
    },
    methods: {
        acaoEnviar: function () {
            this.$emit('acao');
        }
    }
}
</script>
