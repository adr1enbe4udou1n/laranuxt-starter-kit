<template>
  <div>
    <b-row v-if="canEdit">
      <b-col md="4" class="mb-3">
        <b-form inline @submit.prevent="onAssociate" autocomplete="off">
          <label class="form-label mr-2">{{ searchLabel }}</label>
          <Autocomplete
            :name="modelName"
            v-model="modelId"
            :placeholder="searchPlaceholder"
            :label="modelLabel"
            :model-route="modelRoute"
            class="mr-2"
            size="sm"
          ></Autocomplete>
          <b-btn type="submit" variant="success" size="sm"> {{ $t('buttons.associate') }} </b-btn>
        </b-form>
      </b-col>
    </b-row>
    <div style="overflow-x: auto">
      <b-table
        ref="datatable"
        striped
        bordered
        show-empty
        stacked="xl"
        no-local-sorting
        :empty-text="$t('labels.no_results')"
        :empty-filtered-text="$t('labels.no_matched_results')"
        :items="dataLoadProvider"
        :fields="fields"
        :sort-by="sortBy"
        :sort-desc="sortDesc"
      >
        <template v-for="slot in Object.keys($scopedSlots)" v-slot:[slot]="scope">
          <slot :name="slot" v-bind="scope"></slot>
        </template>
        <template v-slot:cell(actions)="row">
          <div class="actions">
            <b-btn
              size="sm"
              variant="danger"
              v-b-tooltip.hover
              :title="$t('buttons.dissociate')"
              @click.stop="deleteRow(row.item.id)"
            >
              <i class="fe fe-trash"></i>
            </b-btn>
          </div>
        </template>
      </b-table>
    </div>
    <b-pagination
      :total-rows="totalRows"
      :per-page="perPage"
      v-model="currentPage"
      v-if="canPaginate && totalRows > perPage"
      class="justify-content-center"
      @input="onContextChanged"
    ></b-pagination>
  </div>
</template>

<script>
export default {
  name: 'RelationshipTable',
  props: {
    searchLabel: {
      type: String,
      default: null
    },
    searchPlaceholder: {
      type: String,
      default: null
    },
    modelLabel: {
      type: String,
      default: null
    },
    modelName: {
      type: String,
      default: null
    },
    modelRoute: {
      type: String,
      default: null
    },
    canEdit: {
      type: Boolean,
      default: true
    },
    canPaginate: {
      type: Boolean,
      default: true
    },
    filters: {
      type: Object,
      default: null
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
    perPage: {
      type: Number,
      default: 5
    },
    relatedModelName: {
      type: String,
      default: null
    },
    relatedModelId: {
      type: Number,
      default: null
    },
    pivot: {
      type: Boolean,
      default: false
    }
  },
  data() {
    return {
      modelId: null,
      currentPage: 1,
      totalRows: 0,
      items: []
    }
  },
  watch: {
    relatedModelId() {
      this.onContextChanged()
    }
  },
  methods: {
    async onAssociate() {
      await this.$http.post(
        this.$app.route(`relationships.${this.pivot ? 'attach' : 'associate'}`, {
          model: this.modelName,
          id: this.modelId,
          related: this.relatedModelName,
          related_id: this.relatedModelId
        })
      )

      this.modelId = null
      this.onContextChanged()
    },
    async dataLoadProvider(ctx) {
      let { data } = await this.$http.get(
        this.$app.route(`${this.modelRoute}.index`, {
          page: this.currentPage,
          perPage: this.perPage,
          column: ctx.sortBy,
          direction: ctx.sortDesc ? 'desc' : 'asc',
          [`${this.relatedModelName}_id`]: this.relatedModelId
        })
      )

      this.totalRows = data.total
      this.items = data.data
      return data.data
    },
    onContextChanged() {
      return this.$refs.datatable.refresh()
    },
    async deleteRow(id) {
      let result = await this.$confirm()

      if (result.value) {
        await this.$http.post(
          this.$app.route(`relationships.${this.pivot ? 'detach' : 'dissociate'}`, {
            model: this.modelName,
            id,
            related: this.relatedModelName,
            ...(this.pivot && {
              related_id: this.relatedModelId
            })
          })
        )
        this.onContextChanged()
      }
    }
  }
}
</script>
