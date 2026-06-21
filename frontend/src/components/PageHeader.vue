<template>
  <div class="page-header mb-5 d-flex justify-content-between align-items-center">
    <div class="text-left">
      <h2 class="font-weight-bold text-dark mb-2">{{ title }}</h2>
      <p v-if="subtitle" class="text-muted mb-0" style="font-size: 1.1rem;">{{ subtitle }}</p>
    </div>
    <div class="page-header-actions" v-if="$slots.actions">
      <slot name="actions"></slot>
    </div>
  </div>
</template>

<script>
export default {
  name: 'PageHeader',
  props: {
    title: {
      type: String,
      required: true
    },
    subtitle: {
      type: String,
      default: ''
    }
  }
}
</script>

<style scoped>
</style>
