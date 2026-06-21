<template>
  <b-pagination
    :value="value"
    @input="$emit('input', $event)"
    :total-rows="totalRows"
    :per-page="perPage"
    align="center"
    v-bind="$attrs"
  ></b-pagination>
</template>

<script>
export default {
  name: 'PaginationRow',
  inheritAttrs: false,
  props: {
    value: {
      type: Number,
      required: true
    },
    totalRows: {
      type: Number,
      required: true
    },
    perPage: {
      type: Number,
      default: 10
    }
  }
}
</script>
