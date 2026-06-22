<template>
  <BaseForm @submit="handleSubmit" @cancel="$emit('cancel')">
    <b-row>
      <b-col md="6">
        <BaseInput id="zip_code" label="CEP" placeholder="Ex: 01310-200" v-model="form.zip_code" required mask="#####-###" @keyup.native="handleCepInput" />
      </b-col>
      <b-col md="6">
        <BaseInput id="street" label="Logradouro" placeholder="Ex: Avenida Paulista" v-model="form.street" required />
      </b-col>
      <b-col md="6">
        <BaseInput id="neighborhood" label="Bairro" placeholder="Ex: Bela Vista" v-model="form.neighborhood" required />
      </b-col>
      <b-col md="6">
        <BaseInput id="city" label="Cidade" placeholder="Ex: São Paulo" v-model="form.city" required />
      </b-col>
      <b-col md="6">
        <b-form-group label="UF" label-for="state" label-class="text-left font-weight-bold">
          <b-form-select id="state" v-model="form.state" :options="stateOptions" required />
        </b-form-group>
      </b-col>
    </b-row>
  </BaseForm>
</template>

<script>
import BaseForm from '@/components/BaseForm.vue';
import BaseInput from '@/components/BaseInput.vue';
import { VIA_CEP_API_URL, getOnlyNumbers, BRAZILIAN_STATES } from '@/utils';

export default {
  name: 'FormAddress',
  components: {
    BaseForm,
    BaseInput
  },
  data() {
    return {
      form: {
        zip_code: '',
        street: '',
        neighborhood: '',
        city: '',
        state: ''
      },
      lastFetchedCep: '',
      stateOptions: [
        { text: 'Selecione', value: '', disabled: true },
        ...BRAZILIAN_STATES.map(state => ({ text: state, value: state }))
      ]
    }
  },
  computed: {
    address() {
      return this.$store.state.addresses.address;
    }
  },
  watch: {
    address: {
      handler(newVal) {
        if (newVal && Object.keys(newVal).length > 0) {
          this.form = { ...newVal };
        } else {
          this.form = {
            zip_code: '',
            street: '',
            neighborhood: '',
            city: '',
            state: ''
          };
        }
      },
      immediate: true,
      deep: true,
    }
  },
  methods: {
    handleCepInput() {
      if (this.form.zip_code && this.form.zip_code.length === 9) {
        if (this.form.zip_code !== this.lastFetchedCep) {
          this.lastFetchedCep = this.form.zip_code;
          this.fetchAddress();
        }
      }
    },
    handleSubmit() {
      const payload = { ...this.form };
      if (payload.zip_code) {
        payload.zip_code = getOnlyNumbers(payload.zip_code);
      }
      this.$emit('submit', payload);
    },
    async fetchAddress() {
      const cep = getOnlyNumbers(this.form.zip_code);
      if (cep.length === 8) {
        try {
          console.log('fetching via cep');
          const url = VIA_CEP_API_URL.replace(':CEP', cep);
          const response = await fetch(url);
          const data = await response.json();
          if (!data.erro) {
            this.form = {
              ...this.form,
              street: data.logradouro || this.form.street,
              neighborhood: data.bairro || this.form.neighborhood,
              city: data.localidade || this.form.city,
              state: data.uf || this.form.state
            };
          }
        } catch (error) {
          console.error('Erro ao buscar CEP via ViaCEP:', error);
        }
      }
    }
  }
}
</script>
