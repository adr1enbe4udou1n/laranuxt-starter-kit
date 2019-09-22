<template>
  <div>
    <vue-ckeditor
      :value="value"
      :config="config"
      @input="onInput"
      @blur="onBlur($event)"
      @focus="onFocus($event)"
      @contentDom="onContentDom($event)"
      @dialogDefinition="onDialogDefinition($event)"
      @fileUploadRequest="onFileUploadRequest($event)"
      @fileUploadResponse="onFileUploadResponse($event)"
    ></vue-ckeditor>
  </div>
</template>

<script>
import VueCkeditor from 'vue-ckeditor2'

export default {
  name: 'RichTextEditor',
  components: { VueCkeditor },
  props: {
    value: {
      type: String,
      default: null
    }
  },
  data() {
    return {
      config: {
        extraPlugins: ['autogrow', 'image2', 'embedbase', 'embed', 'horizontalrule'],
        removePlugins: ['elementspath', 'image', 'resize'],
        toolbar: [
          [
            'Format',
            'Styles',
            'Bold',
            'Italic',
            '-',
            'NumberedList',
            'BulletedList',
            'Blockquote',
            '-',
            'Link',
            'Unlink',
            '-',
            'Image',
            'Embed',
            'HorizontalRule',
            '-',
            'Undo',
            'Redo',
            '-',
            'Maximize',
            'Source'
          ]
        ],
        uploadUrl: this.$app.route('upload'),
        filebrowserBrowseUrl: '/elfinder/ckeditor',
        embed_provider: '//ckeditor.iframe.ly/api/oembed?url={url}&callback={callback}',
        contentsCss: ['/ckeditor/default.css', '/ckeditor/contents.css'],
        stylesSet: [
          { name: 'Primary color', element: 'span', attributes: { class: 'text-primary' } },
          { name: 'Secondary color', element: 'span', attributes: { class: 'text-secondary' } },
          { name: 'Deleted Text', element: 'del' },
          { name: 'Inserted Text', element: 'ins' },
          { name: 'Marker', element: 'span', attributes: { class: 'marker' } },
          { name: 'Code', element: 'code' },
          { name: 'Cited Work', element: 'cite' }
        ],
        autoGrow_onStartup: true,
        autoGrow_minHeight: 300
      }
    }
  },
  methods: {
    onInput(data) {
      this.$emit('input', data)
    },
    onBlur(evt) {},
    onFocus(evt) {},
    onContentDom(evt) {},
    onDialogDefinition(evt) {},
    onFileUploadRequest(evt) {},
    onFileUploadResponse(evt) {}
  }
}
</script>
