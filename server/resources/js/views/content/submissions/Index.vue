<template>
  <div class="animated fadeIn">
    <b-card>
      <template slot="header">
        <h3 class="card-title">{{ $route.meta.label }}</h3>
      </template>
      <Datatable
        model-route="submissions"
        model-name="submission"
        :fields="fields"
        sort-by="created_at"
        :sort-desc="true"
        :model-route-query="{ type }"
        :can-edit="false"
      >
      </Datatable>
    </b-card>
  </div>
</template>

<script>
export default {
  name: 'SubmissionList',
  data() {
    return {
      type: 'contact',
      fields: [
        {
          key: 'data',
          label: this.$t('attributes.data'),
          sortable: true
        },
        {
          key: 'created_at',
          label: this.$t('attributes.created_at'),
          class: 'text-center',
          sortable: true
        },
        {
          key: 'actions',
          label: this.$t('labels.actions')
        }
      ]
    }
  }
}
</script>
