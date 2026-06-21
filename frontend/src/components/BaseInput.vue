<template>
  <b-form-group :label="label" :label-for="id" :invalid-feedback="error" :state="error ? false : null" label-class="text-left font-weight-bold">
    <input
      class="form-control"
      :class="{ 'is-invalid': !!error }"
      :id="id"
      v-model="computedValue"
      v-bind="$attrs"
      v-mask="mask"
    />
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
    },
    mask: {
      type: [String, Array],
      default: undefined
    }
  },
  computed: {
    computedValue: {
      get() {
        return this.value;
      },
      set(val) {
        this.$emit('input', val);
      }
    }
  }
}
</script>
