<template>
  <b-modal
    :id="id"
    :title="title"
    @ok="$emit('confirm')"
    @cancel="$emit('cancel')"
    cancel-title="Cancelar"
    ok-title="Confirmar"
    ok-variant="primary"
    centered
  >
    <p class="my-4">{{ message }}</p>
  </b-modal>
</template>

<script>
export default {
  name: 'ConfirmModal',
  props: {
    id: {
      type: String,
      required: true
    },
    title: {
      type: String,
      default: 'Confirmação'
    },
    message: {
      type: String,
      required: true
    }
  }
}
</script>
