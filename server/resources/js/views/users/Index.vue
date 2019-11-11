<template>
  <div class="animated fadeIn">
    <b-card>
      <template slot="header">
        <h3 class="card-title">{{ $route.meta.label }}</h3>
      </template>
      <Datatable
        model-route="users"
        model-name="user"
        :fields="fields"
        sort-by="created_at"
        :sort-desc="true"
        :row-actions="actions"
        @on-row-action="onRowAction"
        :row-action-predicate="rowActionPredicate"
        :can-export="true"
      >
        <template slot="actions">
          <b-btn to="/users/create" variant="success" size="sm"> {{ $t('titles.users.create') }} </b-btn>
        </template>
        <template v-slot:cell(name)="row">
          <router-link v-if="!row.item.is_owner" :to="`/users/${row.item.id}/edit`" v-text="row.value"></router-link>
          <span v-else v-text="row.value"></span>
        </template>
        <template v-slot:cell(roles)="row">
          {{ row.value ? formatRoles(row.value) : '' }}
        </template>
      </Datatable>
    </b-card>
  </div>
</template>

<script>
export default {
  name: 'UserList',
  data() {
    return {
      fields: [
        {
          key: 'name',
          label: this.$t('attributes.name'),
          sortable: true
        },
        {
          key: 'email',
          label: this.$t('attributes.email'),
          sortable: true
        },
        { key: 'roles', label: this.$t('attributes.roles') },
        {
          key: 'active',
          label: this.$t('attributes.active'),
          class: 'text-center',
          toggle: true
        },
        {
          key: 'last_access_at',
          label: this.$t('attributes.last_access_at'),
          class: 'text-center',
          sortable: true
        },
        {
          key: 'created_at',
          label: this.$t('attributes.created_at'),
          class: 'text-center',
          sortable: true
        },
        {
          key: 'updated_at',
          label: this.$t('attributes.updated_at'),
          class: 'text-center',
          sortable: true
        },
        {
          key: 'actions',
          label: this.$t('labels.actions')
        }
      ],
      actions: {
        impersonate: {
          variant: 'warning',
          label: this.$t('labels.login_as'),
          icon: 'fe fe-lock'
        }
      }
    }
  },
  methods: {
    formatRoles(value) {
      return value
        .map((item) => {
          return this.$app.enums.role_enum[item]
        })
        .join(', ')
    },
    onRowAction(name, item) {
      switch (name) {
        case 'impersonate':
          location.href = this.$app.route('users.impersonate', { user: item.id })
          break
      }
    },
    rowActionPredicate(name, row) {
      switch (name) {
        case 'edit':
          return !row.item.is_owner
        case 'delete':
          return !row.item.is_owner && row.item.id !== this.$store.state.user.id
        case 'impersonate':
          return !row.item.is_owner && row.item.id !== this.$store.state.user.id && this.$store.state.user.is_admin
      }
    }
  }
}
</script>
