<template>
  <b-table
    hover
    striped
    responsive
    :items="items"
    :fields="fields"
    v-bind="$attrs"
    v-on="$listeners"
  >
    <template v-for="(_, slot) in $scopedSlots" v-slot:[slot]="props">
      <slot :name="slot" v-bind="props" />
    </template>
  </b-table>
</template>

<script>
export default {
  name: 'BaseTable',
  inheritAttrs: false,
  props: {
    items: {
      type: Array,
      required: true
    },
    fields: {
      type: Array,
      required: true
    }
  }
}
</script>
