<template>
  <div>
    <b-row>
      <b-col xl="9">
        <b-card>
          <h3 class="card-title" slot="header">{{ $route.meta.label }}</h3>
          <FormGroup label-for="title">
            <InputType name="title" v-model="model.title"></InputType>
          </FormGroup>
          <FormGroup label-for="slug" description="Laissez vide pour reprendre le titre de l'article">
            <InputType name="slug" v-model="model.slug"></InputType>
          </FormGroup>
          <FormGroup>
            <a href="javascript:void(0)" v-b-toggle.collapseSummary>Ecrire un résumé</a>
            <b-collapse id="collapseSummary" class="mt-2">
              <b-form-textarea
                name="summary"
                :rows="5"
                :placeholder="$t('attributes.summary')"
                v-model="model.summary"
              ></b-form-textarea>
              <b-form-text>
                Description rapide du sujet de la page ou article, repris dans les partages de réseaux sociaux,
                également utilisé en tant que meta description. Si vide, le corps tronqué sera utilisé par défaut.
              </b-form-text>
            </b-collapse>
          </FormGroup>
          <FormGroup>
            <RichTextEditor name="body" v-model="model.body"></RichTextEditor>
          </FormGroup>
        </b-card>
      </b-col>
      <b-col xl="3">
        <div role="tablist">
          <b-card no-body>
            <b-card-header header-tag="header" role="tab">
              <h5 class="card-title">
                <a href="javascript:void(0)" v-b-toggle.collapseOne>
                  {{ $t('labels.publication') }}
                </a>
              </h5>
            </b-card-header>
            <b-collapse id="collapseOne" visible role="tabpanel">
              <b-card-body>
                <b-form-group v-if="model.status">
                  <label>
                    {{ $t('attributes.status') }} :
                    <b-badge :variant="model.status_badge">{{ model.status_label }}</b-badge>
                  </label>
                </b-form-group>
                <FormGroup :label="$t('attributes.author')" label-for="user" v-if="$store.state.user.is_admin">
                  <Autocomplete
                    name="user"
                    v-model="model.user_id"
                    :placeholder="$t('labels.search_user')"
                    label="name"
                    model-route="users"
                  >
                  </Autocomplete>
                </FormGroup>
                <FormGroup
                  :label="$t('attributes.publication_date')"
                  label-for="publication-date"
                >
                  <DateTimePicker name="publication_date" v-model="model.publication_date"></DateTimePicker>
                </FormGroup>

                <FormGroup v-if="model.type === 'post'">
                  <Checkbox name="is_pinned" v-model="model.is_pinned" switch>
                    {{ $t('attributes.is_pinned') }}
                  </Checkbox>
                </FormGroup>

                <div class="d-flex justify-content-between">
                  <b-btn size="sm" variant="danger" @click="$emit('delete')" v-if="isEdit">
                    {{ $t('buttons.delete') }}
                  </b-btn>
                  <b-dropdown
                    split
                    size="sm"
                    :disabled="pending"
                    :text="$t(`buttons.${actionText}`)"
                    :variant="scheduling ? 'warning' : 'success'"
                    @click="onPublish"
                  >
                    <b-dropdown-item @click="onSaveAsDraft">{{ $t('buttons.draft') }} </b-dropdown-item>
                  </b-dropdown>
                </div>
              </b-card-body>
            </b-collapse>
          </b-card>
          <b-card no-body>
            <b-card-header header-tag="header" role="tab">
              <h5 class="card-title">
                <a href="javascript:void(0)" v-b-toggle.collapseImage>
                  {{ $t('attributes.featured_image') }}
                </a>
              </h5>
            </b-card-header>
            <b-collapse id="collapseImage" visible role="tabpanel">
              <b-card-body>
                <ImageType
                  name="featured_image_file"
                  layout="card"
                  accept=".jpg, .jpeg, .png"
                  v-model="model.featured_image_file"
                  :file-url="model.featured_image"
                  :delete.sync="model.featured_image_delete"
                ></ImageType>
              </b-card-body>
            </b-collapse>
          </b-card>
          <b-card no-body v-if="model.type === 'post'">
            <b-card-header header-tag="header" role="tab">
              <h5 class="card-title">
                <a href="javascript:void(0)" v-b-toggle.collapseTags>
                  {{ $t('attributes.tags') }}
                </a>
              </h5>
            </b-card-header>
            <b-collapse id="collapseTags" visible role="tabpanel">
              <b-card-body>
                <FormGroup label-for="tags">
                  <Autocomplete
                    name="tags"
                    v-model="model.tags"
                    :placeholder="$t('labels.add_tags')"
                    label="name"
                    model-route="tags"
                    :multiple="true"
                    :tags="true"
                  >
                  </Autocomplete>
                </FormGroup>
              </b-card-body>
            </b-collapse>
          </b-card>
        </div>
      </b-col>
    </b-row>
  </div>
</template>

<script>
import form from '@/mixins/form'

export default {
  name: 'PostForm',
  mixins: [form],
  props: {
    isEdit: {
      type: Boolean,
      default: false
    },
    pending: {
      type: Boolean,
      default: false
    }
  },
  computed: {
    scheduling() {
      return Date.parse(this.model.publication_date) > Date.now()
    },
    actionText() {
      if (this.scheduling) return 'schedule'
      return this.model.status === 'published' ? 'update' : 'publish'
    }
  },
  methods: {
    onSaveAsDraft() {
      this.model.status = 'draft'
      this.onSubmit()
    },
    onPublish() {
      this.model.status = 'published'
      this.onSubmit()
    },
    onSubmit() {
      this.$emit('submit')
    }
  }
}
</script>
