<template>
  <b-form-group :label="label" :label-for="id" :invalid-feedback="error">
    <b-form-input
      :id="id"
      :value="value"
      @input="$emit('input', $event)"
      v-bind="$attrs"
      :state="state"
    ></b-form-input>
  </b-form-group>
</template>

<script>
export default {
  name: 'BaseInput',
  inheritAttrs: false,
  props: {
    id: {
      type: String,
      required: true
    },
    label: {
      type: String,
      default: ''
    },
    value: {
      type: [String, Number],
      default: ''
    },
    error: {
      type: String,
      default: ''
    }
  },
  computed: {
    state() {
      return this.error ? false : null;
    }
  }
}
</script>
