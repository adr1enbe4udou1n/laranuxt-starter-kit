export function model(entity) {
  return {
    props: {
      id: {
        type: String,
        default: null
      }
    },
    data() {
      return {
        model: {},
        pending: false
      }
    },
    created() {
      if (this.$route.meta.model) {
        this.$applyProps(this.$route.meta.model, this.model)
      }
    },
    methods: {
      onSuccess() {
        this.$router.back()
      },
      async onSubmit() {
        this.pending = true

        let type = 'store'
        let params = {}
        let data = this.$app.objectToFormData(this.model)

        if (this.id !== null) {
          type = 'update'
          params.id = this.id
          data.append('_method', 'PATCH')
        }

        try {
          let response = await this.$http.post(this.$app.route(`${entity}.${type}`, params), data)
          this.onSuccess(response.data)

          this.$bus.$emit('form-errors', {})
        } catch (e) {}

        this.pending = false
      },
      async onDelete() {
        let result = await this.$confirm()

        if (result.value) {
          await this.$http.delete(
            this.$app.route(`${entity}.destroy`, {
              id: this.id
            })
          )

          this.onSuccess()
        }
      }
    }
  }
}
