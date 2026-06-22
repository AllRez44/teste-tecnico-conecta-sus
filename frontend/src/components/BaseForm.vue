<template>
  <b-form @submit.prevent="$emit('submit')" novalidate class="custom-form-wrapper p-4">
    <div class="form-content">
      <slot></slot>
    </div>

    <hr class="my-4 divider" />
    
    <div class="d-flex justify-content-end">
      <b-button type="button" variant="outline-secondary" class="btn-cancel px-4 mr-3" @click="$emit('cancel')">
        Cancelar
      </b-button>
      <b-button type="submit" variant="primary" class="btn-submit px-4">
        Salvar
      </b-button>
    </div>
  </b-form>
</template>

<script>
export default {
  name: 'BaseForm'
}
</script>

<style scoped>
.custom-form-wrapper {
  background-color: #ffffff;
  border-radius: 4px;
  border: 1px solid #e0e0e0;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
}

.divider {
  border-top: 1px solid #e0e0e0;
}
</style>
