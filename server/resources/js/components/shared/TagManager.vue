<template>
  <b-card>
    <template slot="header">
      <h3 class="card-title">{{ $route.meta.label }}</h3>
    </template>
    <Datatable
      model-route="tags"
      model-name="tag"
      :fields="fields"
      sort-by="order_column"
      :can-export="false"
      :can-move="true"
      ref="datatable"
      :model-route-query="{ type }"
      :can-edit="false"
    >
      <template slot="actions">
        <b-form @submit.prevent="onStore" inline>
          <b-input-group>
            <b-form-input
              name="name"
              v-model="newTag"
              size="sm"
              class="ml-1"
              :placeholder="$t('labels.add_tags')"
            ></b-form-input>
            <b-input-group-append>
              <b-btn size="sm" variant="success" type="submit">{{ $t('buttons.add') }}</b-btn>
            </b-input-group-append>
          </b-input-group>
        </b-form>
      </template>
      <template v-slot:cell(name)="row">
        <form @submit.prevent="onUpdate" v-if="row.item.id === tag.id" class="form-inline">
          <b-input-group>
            <b-form-input name="name" v-model="tag.name" size="sm"></b-form-input>
            <b-input-group-append>
              <b-btn size="sm" variant="success" type="submit">{{ $t('buttons.edit') }}</b-btn>
              <b-btn size="sm" variant="danger" @click.prevent="resetEdit">{{ $t('buttons.cancel') }}</b-btn>
            </b-input-group-append>
          </b-input-group>
        </form>
        <template v-else>
          <a
            href="javascript:void(0)"
            v-b-tooltip.hover
            :title="$t('buttons.edit')"
            class="mr-1"
            @click.prevent="onEdit(row.item.id, row.item.name)"
          >
            {{ row.value }}
          </a>
        </template>
      </template>
    </Datatable>
  </b-card>
</template>

<script>
export default {
  name: 'TagManager',
  props: {
    type: {
      type: String,
      default: null
    }
  },
  data() {
    return {
      fields: [
        {
          key: 'name',
          label: this.$t('attributes.name'),
          sortable: true
        },
        {
          key: 'order_column',
          label: this.$t('attributes.order_column'),
          class: 'text-right',
          sortable: true
        },
        {
          key: 'posts_count',
          label: this.$t('attributes.posts_count'),
          class: 'text-right',
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
      newTag: null,
      tag: {
        id: null,
        name: null
      }
    }
  },
  methods: {
    resetEdit() {
      this.tag = {
        id: null,
        name: null
      }
    },
    onEdit(id, name) {
      this.tag = {
        id,
        name
      }
    },
    async onStore() {
      await this.$http.post(this.$app.route('tags.store'), {
        name: this.newTag,
        type: this.type
      })

      this.newTag = null
      this.$refs.datatable.refresh()
    },
    async onUpdate() {
      await this.$http.patch(
        this.$app.route('tags.update', {
          id: this.tag.id
        }),
        {
          name: this.tag.name
        }
      )

      this.resetEdit()
      this.$refs.datatable.refresh()
    }
  }
}
</script>
