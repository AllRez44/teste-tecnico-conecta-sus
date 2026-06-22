<template>
  <b-card no-body class="shadow-sm custom-card">
    <BaseTable
      :items="items"
      :fields="fields"
      class="mb-0 custom-table"
      head-variant="light"
      tbody-tr-class="align-middle"
      no-local-sorting
      :sort-by="sortBy"
      :sort-desc="sortDesc"
      @sort-changed="handleSortChange"
      v-bind="$attrs"
      v-on="$listeners"
    >
      <template v-for="(_, slot) in $scopedSlots" v-slot:[slot]="props">
        <slot :name="slot" v-bind="props" />
      </template>
    </BaseTable>

    <div class="card-footer bg-white d-flex justify-content-between align-items-center py-3 border-top">
      <div class="text-muted font-weight-medium" style="font-size: 0.95rem;">
        Mostrando {{ showingFrom }} a {{ showingTo }} de {{ totalRows }} registros
      </div>
      <PaginationRow
        :value="currentPage"
        @input="handlePageChange"
        :total-rows="totalRows"
        :per-page="perPage"
        class="mb-0 custom-pagination"
      />
    </div>
  </b-card>
</template>

<script>
import BaseTable from './BaseTable.vue';
import PaginationRow from './Pagination.vue';

export default {
  name: 'TablePaginated',
  components: {
    BaseTable,
    PaginationRow
  },
  inheritAttrs: false,
  props: {
    items: {
      type: Array,
      required: true
    },
    fields: {
      type: Array,
      required: true
    },
    totalRows: {
      type: Number,
      required: true
    }
  },
  computed: {
    perPage() {
      return Number(this.$route.query.per_page) || 10;
    },
    currentPage() {
      return Number(this.$route.query.page) || 1;
    },
    showingFrom() {
      if (this.totalRows === 0) return 0;
      return (this.currentPage - 1) * this.perPage + 1;
    },
    showingTo() {
      return Math.min(this.currentPage * this.perPage, this.totalRows);
    },
    sortBy() {
      return this.$route.query.order_by || '';
    },
    sortDesc() {
      return this.$route.query.order_dir === 'desc';
    }
  },
  methods: {
    handlePageChange(page) {
      if (this.$route.query.page !== String(page)) {
        this.$router.push({
          query: {
            ...this.$route.query,
            page: page
          }
        }).catch(() => {});
      }
    },
    handleSortChange(ctx) {
      const query = { ...this.$route.query };
      
      if (ctx.sortBy) {
        query.order_by = ctx.sortBy;
        query.order_dir = ctx.sortDesc ? 'desc' : 'asc';
      } else {
        delete query.order_by;
        delete query.order_dir;
      }
      
      if (this.$route.query.order_by !== query.order_by || this.$route.query.order_dir !== query.order_dir) {
        this.$router.push({ query }).catch(() => {});
      }
    }
  }
}
</script>

<style scoped>
.custom-card {
  border-radius: 8px;
  border: 1px solid #e2e8f0;
}

::v-deep .custom-table th {
  padding: 1rem 1.5rem;
  font-size: 0.95rem;
  letter-spacing: 0.3px;
  border-bottom-width: 1px;
}

::v-deep .custom-table td {
  padding: 1.25rem 1.5rem;
  vertical-align: middle;
}
</style>
