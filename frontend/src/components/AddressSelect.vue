<template>
  <b-form-group :label="label" :label-for="id" label-class="text-left font-weight-bold" :invalid-feedback="error" :state="error ? false : null">
    <b-input-group class="position-relative">
      <b-form-input 
        ref="input"
        :id="id" 
        v-model="searchText" 
        :class="{ 'is-invalid': !!error }" 
        placeholder="Digite para buscar um endereço..."
        @focus="handleFocus"
        @blur="handleBlur"
        @click="handleFocus"
        autocomplete="off"
        v-bind="$attrs"
      />
      <div v-if="showOptions && filteredOptions.length" class="dropdown-menu show w-100" style="max-height: 250px; overflow-y: auto; position: absolute; top: 100%; left: 0; z-index: 1050; margin-top: 0;">
        <a v-for="option in filteredOptions" :key="option.value" class="dropdown-item text-truncate" href="#" @mousedown.prevent="selectOption(option)" :title="option.text">
          {{ option.text }}
        </a>
      </div>
      <div v-if="showOptions && !filteredOptions.length" class="dropdown-menu show w-100" style="position: absolute; top: 100%; left: 0; z-index: 1050; margin-top: 0;">
        <span class="dropdown-item text-muted">Nenhum endereço encontrado</span>
      </div>
      
      <b-input-group-append>
        <b-button variant="primary" @click="handleNewAddress" title="Novo endereço" class="px-3 font-weight-bold">
          +
        </b-button>
      </b-input-group-append>
    </b-input-group>
  </b-form-group>
</template>

<script>
export default {
  name: 'AddressSelect',
  inheritAttrs: false,
  props: {
    value: {
      type: [String, Number],
      default: ''
    },
    id: {
      type: String,
      required: true
    },
    label: {
      type: String,
      default: 'Endereço'
    },
    error: {
      type: String,
      default: ''
    }
  },
  data() {
    return {
      searchText: '',
      showOptions: false,
      searchTimeout: null
    }
  },
  computed: {
    options() {
      const addresses = this.$store.state.addresses.addresses || [];
      return addresses.map(address => ({
        text: `${address.street}, ${address.neighborhood}, ${address.city} - ${address.state} (CEP: ${address.zip_code})`,
        value: address.id
      }));
    },
    filteredOptions() {
      if (!this.searchText) return this.options;
      
      const selectedOption = this.options.find(option => option.value === this.value);
      if (selectedOption && selectedOption.text === this.searchText) {
        return this.options;
      }
      
      const lowercaseSearchText = this.searchText.toLowerCase();
      return this.options.filter(option => option.text.toLowerCase().includes(lowercaseSearchText));
    }
  },
  watch: {
    searchText(newVal) {
      if (this.searchTimeout) {
        clearTimeout(this.searchTimeout);
      }
      
      if (this.value) {
        const searchedOption = this.options.find(option => option.value === this.value);
        if (searchedOption && searchedOption.text === newVal) {
          return;
        }
      }
      
      this.searchTimeout = setTimeout(() => {
        const query = newVal ? `&search=${encodeURIComponent(newVal)}` : '';
        this.$store.dispatch('getAddresses', { 
          searchParams: `?per_page=999${query}`,
          axiosOptions: { silent: true }
        });
      }, 400);
    },
    value: {
      immediate: true,
      handler(newVal) {
        if (!newVal) {
          this.searchText = '';
        } else {
          this.syncSearchText();
        }
      }
    },
    options: {
      handler() {
        if (this.value) {
          this.syncSearchText();
        }
      }
    }
  },
  mounted() {
    this.$store.dispatch('getAddresses', { searchParams: '?per_page=999' });
  },
  methods: {
    syncSearchText() {
      if (this.value) {
        const searchedOption = this.options.find(option => option.value === this.value);
        if (searchedOption) {
          this.searchText = searchedOption.text;
        }
      }
    },
    selectOption(option) {
      this.searchText = option.text;
      this.$emit('input', option.value);
      this.showOptions = false;
      if (this.$refs.input) {
        this.$refs.input.blur();
      }
    },
    handleFocus() {
      this.showOptions = true;
      this.searchText = '';
    },
    handleBlur() {
      setTimeout(() => {
        this.showOptions = false;
        if (this.value) {
          const searchedOption = this.options.find(option => option.value === this.value);
          if (searchedOption && this.searchText !== searchedOption.text) {
            this.searchText = searchedOption.text; 
          }
        } else {
          this.searchText = '';
          this.$emit('input', '');
        }
      }, 150);
    },
    handleNewAddress() {
      const routeData = this.$router.resolve({ name: 'enderecos-form' });
      window.open(routeData.href, '_blank');
    }
  }
}
</script>
