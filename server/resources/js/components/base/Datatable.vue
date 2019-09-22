<template>
  <div>
    <div class="d-flex mb-3 position-relative">
      <b-form inline class="d-flex justify-content-end" @submit.prevent v-click-outside="onCloseFilters">
        <b-input-group v-if="canSearch && hasFilters">
          <b-form-input
            v-if="canSearch"
            v-model="searchQuery"
            @input="debounceInput"
            size="sm"
            :placeholder="$t('labels.search')"
          ></b-form-input>
          <b-input-group-append>
            <b-btn size="sm" class="dropdown-toggle" v-if="hasFilters" @click="showFilters = !showFilters">
              <i class="fe fe-filter"></i>
              <span v-text="$t('labels.filters')" class="mr-1"></span>
            </b-btn>
          </b-input-group-append>
        </b-input-group>
        <template v-else>
          <b-form-input
            v-if="canSearch"
            v-model="searchQuery"
            @input="debounceInput"
            size="sm"
            :placeholder="$t('labels.search')"
          ></b-form-input>
          <b-input-group-append>
            <b-btn size="sm" class="dropdown-toggle" v-if="hasFilters" @click="showFilters = !showFilters">
              <i class="fe fe-filter"></i>
              <span v-text="$t('labels.filters')" class="mr-1"></span>
            </b-btn>
          </b-input-group-append>
        </template>
        <b-collapse id="collapseFilters" class="mt-2 custom-filters__collapse" v-model="showFilters">
          <b-card><slot name="filters"></slot></b-card>
        </b-collapse>
      </b-form>
      <div class="ml-auto d-flex">
        <slot name="actions"></slot>
        <div v-if="canExport" class="d-flex justify-content-end">
          <b-btn @click.prevent="onExport" size="sm ml-2">
            <i class="fe fe-download"></i>&nbsp;&nbsp;{{ $t('labels.export') }}
          </b-btn>
        </div>
      </div>
    </div>
    <div style="overflow-x: auto">
      <b-table
        ref="datatable"
        striped
        bordered
        show-empty
        no-local-sorting
        :selectable="selectable"
        :empty-text="$t('labels.no_results')"
        :empty-filtered-text="$t('labels.no_matched_results')"
        :items="dataLoadProvider"
        :fields="fields"
        :sort-by.sync="sortByData"
        :sort-desc.sync="sortDescData"
        @row-selected="onRowSelected"
      >
        <template v-slot:cell()="row">
          <Checkbox
            v-if="row.field.toggle"
            :checked="row.value"
            @change="onToggle(row.item.id, row.field.key)"
            :key="row.field.key"
            switch
          ></Checkbox>
          <span v-else>{{ row.value }}</span>
        </template>
        <template v-for="slot in Object.keys($scopedSlots)" v-slot:[slot]="scope">
          <slot :name="slot" v-bind="scope"></slot>
        </template>
        <template v-slot:cell(actions)="row">
          <div class="actions">
            <b-btn
              v-if="canMove"
              size="sm"
              v-b-tooltip.hover
              :title="$t('buttons.move_down')"
              @click="onMove(row.item.id, 'down')"
            >
              <i class="fe fe-arrow-down"></i>
            </b-btn>
            <b-btn
              v-if="canMove"
              size="sm"
              v-b-tooltip.hover
              :title="$t('buttons.move_up')"
              @click="onMove(row.item.id, 'up')"
            >
              <i class="fe fe-arrow-up"></i>
            </b-btn>
            <b-btn
              size="sm"
              variant="primary"
              :to="`/${clientRoute || modelRoute}/${row.item.id}/edit`"
              :title="$t('buttons.edit')"
              v-show="rowActionPredicate('edit', row)"
              v-if="canEdit"
            >
              <i class="fe fe-edit"></i>
            </b-btn>
            <b-btn
              v-for="(rowAction, name) in rowActions"
              :key="name"
              size="sm"
              :variant="rowAction.variant"
              :title="rowAction.label"
              :href="rowAction.link ? rowAction.href(row.item) : ''"
              :target="rowAction.target || '_self'"
              @click="$emit('on-row-action', name, row.item)"
              v-show="rowActionPredicate(name, row)"
            >
              <i :class="rowAction.icon"></i>
            </b-btn>
            <b-btn
              size="sm"
              variant="danger"
              :title="$t('buttons.delete')"
              @click.stop="deleteRow(row.item)"
              v-show="rowActionPredicate('delete', row)"
              v-if="canDelete"
            >
              <i class="fe fe-trash"></i>
            </b-btn>
          </div>
        </template>
      </b-table>
    </div>
    <div class="d-flex">
      <b-form inline @submit.prevent="onBulkAction" v-if="Object.keys(allBulkActions).length">
        <div class="form-group">
          <b-form-select :options="allBulkActions" v-model="selectedBulkAction" class="mr-1" size="sm"></b-form-select>
          <b-btn type="submit" variant="danger" size="sm">{{ $t('buttons.validate') }}</b-btn>
          <span v-if="selected.length" class="ml-2">
            {{ $t('labels.datatables.selected', { count: selected.length }) }}
          </span>
        </div>
      </b-form>
      <div class="ml-auto d-flex">
        <b-form inline>
          <label class="mr-2">{{ $t('labels.datatables.rows_per_page') }}</label>
          <b-form-select
            :options="pageOptions"
            v-model="perPage"
            class="mr-4"
            @input="refresh"
            size="sm"
          ></b-form-select>
          <label class="text-secondary">
            {{ perPage * (currentPage - 1) + 1 }} - {{ perPage * currentPage }} {{ $t('labels.of') }} {{ totalRows }}
          </label>
        </b-form>
        <b-pagination
          :total-rows="totalRows"
          :per-page="perPage"
          v-model="currentPage"
          v-if="totalRows > perPage"
          class="mb-0 ml-4"
          @input="refresh"
          size="sm"
        ></b-pagination>
      </div>
    </div>
  </div>
</template>

<script>
import _ from 'lodash'

export default {
  name: 'Datatable',
  props: {
    canSearch: {
      type: Boolean,
      default: true
    },
    canExport: {
      type: Boolean,
      default: false
    },
    canMove: {
      type: Boolean,
      default: false
    },
    canEdit: {
      type: Boolean,
      default: true
    },
    canDelete: {
      type: Boolean,
      default: true
    },
    selectable: {
      type: Boolean,
      default: true
    },
    useUrlQuery: {
      type: Boolean,
      default: true
    },
    filters: {
      type: Object,
      default: () => {}
    },
    clientRoute: {
      type: String,
      default: null
    },
    modelRoute: {
      type: String,
      default: null
    },
    modelRouteQuery: {
      type: Object,
      default: () => {}
    },
    modelName: {
      type: String,
      default: null
    },
    rowActions: {
      type: Object,
      default: () => {}
    },
    bulkActions: {
      type: Object,
      default: () => {}
    },
    fields: {
      type: [Object, Array],
      default: null
    },
    sortBy: {
      type: String,
      default: null
    },
    sortDesc: {
      type: Boolean,
      default: false
    },
    defaultBulkAction: {
      type: String,
      default: 'destroy'
    },
    rowActionPredicate: {
      type: Function,
      default: () => true
    }
  },
  data() {
    return {
      currentPage: 1,
      perPage: 10,
      totalRows: 0,
      sortByData: this.sortBy,
      sortDescData: this.sortDesc,
      pageOptions: [5, 10, 15, 25, 50],
      searchQuery: null,
      items: [],
      selected: [],
      isReady: false,
      entityBulkActions: {},
      selectedBulkAction: this.defaultBulkAction,
      showFilters: false
    }
  },
  computed: {
    queryFilters() {
      return Object.assign(
        {
          page: this.currentPage,
          perPage: this.perPage,
          sortBy: this.sortByData,
          sortDesc: this.sortDescData,
          search: this.searchQuery
        },
        this.filters
      )
    },
    hasFilters() {
      return !!this.$slots.filters
    },
    toggleColumns() {
      if (Array.isArray(this.fields)) {
        return this.fields
          .filter((field) => {
            return field.toggle === true
          })
          .map((field) => {
            return field.key
          })
      }

      let keys = []
      for (let key in this.fields) {
        if (this.fields.hasOwnProperty(key) && this.fields[key].toggle) {
          keys.push(key)
        }
      }
      return keys
    },
    allBulkActions() {
      return Object.assign({}, this.bulkActions, this.entityBulkActions)
    },
    isEntityBulkAction() {
      return this.entityBulkActions[this.selectedBulkAction]
    }
  },
  watch: {
    filters: {
      handler() {
        this.refresh()
      },
      deep: true
    }
  },
  async created() {
    let { data } = await this.$http.get(
      this.$app.route('bulk.actions', {
        model: this.modelName
      })
    )

    this.entityBulkActions = Object.assign(data, {
      destroy: this.$t('labels.datatables.bulkDelete')
    })

    if (this.useUrlQuery) {
      this.updateFiltersFromRouteQuery()

      window.onpopstate = () => {
        this.updateFiltersFromRouteQuery()
        this.refresh()
      }
    }

    this.isReady = true

    this.refresh()
  },
  methods: {
    onRowSelected(items) {
      this.selected = items
    },
    onCloseFilters() {
      this.showFilters = false
    },
    updateFiltersFromRouteQuery() {
      if (this.$route.query['page']) {
        this.currentPage = this.$route.query['page']
      }

      if (this.$route.query['perPage']) {
        this.perPage = this.$route.query['perPage']
      }

      if (this.$route.query['sortBy']) {
        this.sortByData = this.$route.query['sortBy']
      }

      if (this.$route.query['sortDesc']) {
        this.sortDescData = this.$route.query['sortDesc'] === 'true'
      }

      if (this.$route.query['search']) {
        this.searchQuery = this.$route.query['search']
      }

      if (this.filters) {
        Object.keys(this.filters).forEach((key) => {
          if (key in this.$route.query) {
            this.filters[key] = this.$route.query[key]
          }
        })
      }
    },
    async dataLoadProvider() {
      if (!this.isReady) return

      if (this.useUrlQuery) {
        this.$router.push({ query: this.queryFilters }).catch((e) => {})
      }

      let { data } = await this.$http.get(
        this.$app.route(`${this.modelRoute}.index`, Object.assign({}, this.queryFilters, this.modelRouteQuery))
      )

      this.totalRows = data.total
      this.items = data.data

      return data.data
    },
    refresh() {
      if (this.$refs.datatable) {
        this.$refs.datatable.refresh()
      }
    },
    debounceInput: _.debounce(function() {
      this.refresh()
    }, 200),
    onExport() {
      window.location = this.$app.route(
        `${this.modelRoute}.index`,
        Object.assign(
          {
            search: this.searchQuery,
            export: true
          },
          this.filters
        )
      )
    },
    async deleteRow(id) {
      let result = await this.$confirm()

      if (result.value) {
        await this.$http.delete(
          this.$app.route(`${this.modelRoute}.destroy`, {
            id
          })
        )
        this.refresh()
      }
    },
    onToggle(id, attribute = 'active') {
      this.$http.post(
        this.$app.route('toggle', {
          model: this.modelName,
          id,
          attribute
        })
      )
    },
    async onMove(id, direction) {
      await this.$http.post(
        this.$app.route('move', {
          model: this.modelName,
          id,
          direction
        })
      )

      this.refresh()
    },
    async onBulkAction() {
      if (!this.isEntityBulkAction) {
        return this.$emit('on-bulk-action', this.selectedBulkAction, this.selected)
      }

      let result = await this.$confirm()

      if (result.value) {
        await this.$http.post(
          this.$app.route('bulk.process', {
            model: this.modelName,
            action: this.selectedBulkAction
          }),
          {
            ids: this.selected.map((item) => item.id)
          }
        )

        this.refresh()
      }
    }
  }
}
</script>

<style lang="scss">
.custom-filters__collapse {
  position: absolute;
  left: 0;
  top: 2rem;
  z-index: 1;
  width: 350px;
}

.table {
  td .actions {
    white-space: nowrap;
  }
}
</style>
