<template>
  <div>
    <div
      class="input-wrapper position-relative"
      :class="{
        dropup: openDirection === 'up',
        dropright: openDirection === 'right',
        dropleft: openDirection === 'left'
      }"
    >
      <b-input-group>
        <input
          type="text"
          :id="getId"
          :name="name"
          :class="[
            'form-control',
            `form-control-${size}`,
            {
              'is-invalid': state === 'invalid'
            }
          ]"
          :placeholder="placeholder"
          v-model="search"
          :autocomplete="autocomplete"
          @focus="showItems = true"
          @keydown.enter.prevent="onAddTag(search)"
          @input="onSearch"
        />
        <b-input-group-append>
          <b-input-group-text style="cursor: pointer" @click="reset">
            <i class="fe fe-x-circle"></i>
          </b-input-group-text>
        </b-input-group-append>
      </b-input-group>
      <div class="dropdown-menu d-block" v-if="showItems && mutableItems.length">
        <a
          href="#"
          class="dropdown-item"
          v-for="(item, index) in mutableItems"
          :key="index"
          @click.prevent="onAdd(item)"
        >
          <slot name="result" :item="item">{{ getLabel(item) }}</slot>
        </a>
      </div>
    </div>
    <div class="tags mt-2" v-if="multiple && selectedItems.length">
      <div class="tag" v-for="(item, index) in selectedItems" :key="index">
        <slot name="tag" :item="item">{{ getLabel(item) }}</slot>
        <button type="button" class="tag-addon" @click.prevent="onDelete(item)">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    </div>
    <b-form-invalid-feedback v-if="invalidFeedback" :class="{ 'd-block': !!invalidFeedback }">
      {{ invalidFeedback }}
    </b-form-invalid-feedback>
    <b-form-text v-if="description">{{ description }}</b-form-text>
  </div>
</template>

<script>
import field from '@/mixins/field'
import _ from 'lodash'

export default {
  name: 'Autocomplete',
  mixins: [field],
  props: {
    value: {
      type: [Number, String, Array],
      default: () => []
    },
    size: {
      type: String,
      default: null
    },
    placeholder: {
      type: String,
      default: null
    },
    autocomplete: {
      type: String,
      default: 'off'
    },
    description: {
      type: String,
      default: ''
    },
    label: {
      type: [String, Function],
      required: true
    },
    column: {
      type: String,
      default: null
    },
    direction: {
      type: String,
      default: 'asc'
    },
    trackBy: {
      type: String,
      default: 'id'
    },
    items: {
      type: Array,
      default: () => []
    },
    openDirection: {
      type: String,
      default: null
    },
    multiple: {
      type: Boolean,
      default: false
    },
    tags: {
      type: Boolean,
      default: false
    },
    maxResult: {
      type: Number,
      default: 10
    },
    modelRoute: {
      type: String,
      default: null
    },
    modelRouteQuery: {
      type: Object,
      default: () => {}
    }
  },
  data() {
    return {
      selectedItem: null,
      selectedItems: [],
      mutableItems: this.items,
      showItems: false,
      search: null
    }
  },
  watch: {
    selectedItem(newValue) {
      this.search = ''
      this.$emit('change', newValue)
      this.$emit('input', newValue ? newValue[this.trackBy] : null)

      if (!_.isEmpty(newValue)) {
        this.search = this.getLabel(newValue)
      }
    },
    selectedItems(newValue) {
      this.$emit('change', newValue)
      this.$emit(
        'input',
        this.tags
          ? newValue
          : newValue.map((item) => {
              return item[this.trackBy]
            })
      )
    },
    value: {
      async handler(newValue) {
        if (this.tags) {
          this.selectedItems = newValue || []
          return
        }

        if (this.multiple) {
          if (newValue.length && typeof newValue[0] === 'object') {
            this.selectedItems = newValue
          }
          return
        }

        if (newValue === null) {
          this.selectedItem = null
          return
        }

        if (this.modelRoute === null) {
          return
        }

        let { data } = await this.$http.get(
          this.$app.route(`${this.modelRoute}.show`, {
            id: newValue
          })
        )

        this.selectedItem = data
      },
      immediate: true
    },
    items(newValue) {
      this.mutableItems = newValue
    },
    search() {
      if (this.search === '' && !this.multiple) {
        this.selectedItem = null
      }
    }
  },
  mounted() {
    document.addEventListener('click', (e) => {
      if (this.$el.contains(e.target)) return

      this.showItems = false
    })
  },
  methods: {
    async onSearch() {
      if (this.search === '') {
        return
      }

      if (this.modelRoute === null) {
        return
      }

      let { data } = await this.$http.get(
        this.$app.route(
          `${this.modelRoute}.index`,
          Object.assign(
            {
              page: 1,
              perPage: this.maxResult,
              column: this.column || this.label,
              direction: this.direction,
              search: this.search
            },
            this.modelRouteQuery
          )
        )
      )

      this.mutableItems = data.data
    },
    getLabel(item) {
      if (typeof item === 'string') {
        return item
      }
      if (typeof this.label === 'function') {
        return this.label(item)
      }
      return item[this.label]
    },
    onDelete(item) {
      this.selectedItems = this.selectedItems.filter((i) => {
        return i !== item
      })
    },
    onAddTag(tag) {
      if (this.tags) {
        let existingItem = this.selectedItems.filter((i) => {
          return tag === i
        })

        if (!existingItem.length) {
          this.selectedItems.push(tag)
        }
        this.clearInput()
      }
    },
    onAdd(item) {
      if (this.tags) {
        this.onAddTag(item[this.label])
        return
      }
      if (this.multiple) {
        let existingItem = this.selectedItems.filter((i) => {
          return i[this.trackBy] === item[this.trackBy]
        })

        if (!existingItem.length) {
          this.selectedItems.push(item)
        }
        this.clearInput()
        return
      }

      this.selectedItem = item
      this.clearInput()
    },
    reset() {
      if (!this.multiple) {
        this.selectedItem = null
      }
      this.clearInput()
    },
    clearInput() {
      this.search = ''
      this.showItems = false
    }
  }
}
</script>

<style lang="scss">
.tag {
  font-size: 0.8rem;
  color: #000;
  background-color: #e9ecef;
  border-radius: 3px;
  padding: 0 0.5rem;
  line-height: 2em;
  display: inline-flex;
  cursor: default;
  font-weight: 400;
  user-select: none;
}

.tag-addon {
  display: inline-block;
  padding: 0 0.5rem;
  color: inherit;
  text-decoration: none;
  background: rgba(#000, 0.06);
  margin: 0 -0.5rem 0 0.5rem;
  text-align: center;
  min-width: 1.5rem;
  border: 0;
  transition: 0.3s color, 0.3s background;

  &:last-child {
    border-top-right-radius: 3px;
    border-bottom-right-radius: 3px;
  }

  i {
    vertical-align: middle;
    margin: 0 -0.25rem;
  }

  &:hover {
    background: rgba(#000, 0.16);
    color: inherit;
  }
}

.tags {
  margin-bottom: -0.5rem;
  font-size: 0;

  > .tag {
    margin-bottom: 0.5rem;

    &:not(:last-child) {
      margin-right: 0.5rem;
    }
  }
}
</style>
