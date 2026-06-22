<template>
  <ValidationObserver ref="observer" v-slot="{ handleSubmit: handleValidate }">
    <BaseForm @submit="handleValidate(handleSubmit)" @cancel="$emit('cancel')">
      <b-row>
        <b-col md="6">
          <ValidationProvider name="Nome" rules="required" v-slot="{ errors }">
            <BaseInput id="name" label="Nome Completo *" placeholder="Ex: Maria Silva Santos" v-model="form.name" required :error="errors[0] || getError('name')" />
          </ValidationProvider>
        </b-col>
        <b-col md="6">
          <ValidationProvider name="CPF" rules="required" v-slot="{ errors }">
            <BaseInput id="cpf" label="CPF *" placeholder="000.000.000-00" v-model="form.cpf" required mask="###.###.###-##" :error="errors[0] || getError('cpf')" />
          </ValidationProvider>
        </b-col>
        <b-col md="6">
          <ValidationProvider name="CNS" rules="required" v-slot="{ errors }">
            <BaseInput id="cns" label="CNS (Cartão Nacional de Saúde)" placeholder="000 0000 0000 0000" v-model="form.cns" required mask="### #### #### ####" :error="errors[0] || getError('cns')" />
          </ValidationProvider>
        </b-col>
        <b-col md="6">
          <ValidationProvider name="Data de Nascimento" rules="required" v-slot="{ errors }">
            <BaseInput id="birth_date" label="Data de Nascimento *" type="date" v-model="form.birth_date" required :error="errors[0] || getError('birth_date')" />
          </ValidationProvider>
        </b-col>
        <b-col md="6">
          <ValidationProvider name="Gênero" rules="required" v-slot="{ errors }">
            <b-form-group label="Gênero" label-class="text-left font-weight-bold" :invalid-feedback="errors[0] || getError('gender')" :state="(errors[0] || getError('gender')) ? false : null">
              <b-form-select v-model="form.gender" :options="[
                { text: 'Selecione...', value: '', disabled: true },
                { text: 'Masculino', value: 'M' },
                { text: 'Feminino', value: 'F' },
                { text: 'Outro', value: 'O' }
              ]" :class="{ 'is-invalid': !!(errors[0] || getError('gender')) }" required />
            </b-form-group>
          </ValidationProvider>
        </b-col>
        <b-col md="6">
          <ValidationProvider name="Telefone" v-slot="{ errors }">
            <BaseInput id="phone" label="Telefone" placeholder="(00) 00000-0000" v-model="form.phone" mask="(##) #####-####" :error="errors[0] || getError('phone')" />
          </ValidationProvider>
        </b-col>
        <b-col md="6">
          <ValidationProvider name="Endereço" rules="required" v-slot="{ errors }">
            <AddressSelect id="address_id" label="Endereço *" v-model="form.address_id" required :error="errors[0] || getError('address_id')" />
          </ValidationProvider>
        </b-col>
      </b-row>
    </BaseForm>
  </ValidationObserver>
</template>

<script>
import BaseForm from '@/components/BaseForm.vue';
import BaseInput from '@/components/BaseInput.vue';
import AddressSelect from '@/components/AddressSelect.vue';
import { getOnlyNumbers } from '@/utils';

export default {
  name: 'FormPatient',
  components: {
    BaseForm,
    BaseInput,
    AddressSelect
  },
  props: {
    apiErrors: {
      type: Object,
      default: () => ({})
    }
  },
  data() {
    return {
      form: {
        name: '',
        cpf: '',
        cns: '',
        birth_date: '',
        gender: '',
        phone: '',
        address_id: ''
      }
    }
  },
  computed: {
    patient() {
      return this.$store.state.patients.patient;
    }
  },
  watch: {
    patient: {
      immediate: true,
      handler(newVal) {
        if (newVal && Object.keys(newVal).length > 0) {
          this.form = { ...newVal };
        } else {
          this.form = {
            name: '',
            cpf: '',
            cns: '',
            birth_date: '',
            gender: '',
            phone: '',
            address_id: ''
          }
        }
      }
    }
  },
  methods: {
    handleSubmit() {
      const payload = { ...this.form };
      if (payload.cpf) payload.cpf = getOnlyNumbers(payload.cpf);
      if (payload.cns) payload.cns = getOnlyNumbers(payload.cns);
      if (payload.phone) payload.phone = getOnlyNumbers(payload.phone);
      
      this.$emit('submit', payload);
    },
    getError(field) {
      if (this.apiErrors && this.apiErrors[field]) {
        const err = this.apiErrors[field];
        return Array.isArray(err) ? err[0] : err;
      }
      return '';
    }
  }
}
</script>
