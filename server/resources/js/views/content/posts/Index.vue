<template>
  <div class="animated fadeIn">
    <b-card>
      <template slot="header">
        <h3 class="card-title">{{ $route.meta.label }}</h3>
      </template>
      <Datatable
        ref="datatable"
        model-route="posts"
        model-name="post"
        :fields="fields"
        sort-by="created_at"
        :sort-desc="true"
        :model-route-query="{ type: 'post' }"
        :row-actions="{
          preview: {
            variant: 'success',
            label: this.$t('labels.view'),
            icon: 'fe fe-eye',
            link: true,
            target: '_blank',
            href: (item) => item.url
          }
        }"
      >
        <template slot="actions">
          <b-btn to="/posts/create" variant="success" size="sm"> {{ $t('titles.posts.create') }} </b-btn>
        </template>
        <template v-slot:cell(featured_image)="row">
          <router-link :to="`/posts/${row.item.id}/edit`">
            <ImageCache size="ap" v-if="row.value" :src="row.value" fluid thumbnail></ImageCache>
          </router-link>
        </template>
        <template v-slot:cell(title)="row">
          <router-link :to="`/posts/${row.item.id}/edit`" v-text="row.value"></router-link>
        </template>
        <template v-slot:cell(status)="row">
          <b-badge :variant="row.item.status_badge">{{ row.item.status_label }}</b-badge>
        </template>
        <template v-slot:cell(user)="row">
          {{ row.value ? row.value.name : '' }}
        </template>
      </Datatable>
    </b-card>
  </div>
</template>

<script>
export default {
  name: 'PostList',
  data() {
    return {
      fields: [
        {
          key: 'featured_image',
          label: this.$t('attributes.image')
        },
        {
          key: 'title',
          label: this.$t('attributes.title'),
          sortable: true
        },
        {
          key: 'status',
          label: this.$t('attributes.status')
        },
        {
          key: 'is_pinned',
          label: this.$t('attributes.is_pinned'),
          class: 'text-center',
          toggle: true
        },
        {
          key: 'user',
          label: this.$t('attributes.author')
        },
        {
          key: 'publication_date',
          label: this.$t('attributes.publication_date'),
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
      ]
    }
  }
}
</script>
