<template>
  <ol v-if="hasErrors(name)" class="text-red-500 text-xs italic mt-3">
    <li v-for="(message, index) in errorMessages(name)" :key="index">
      {{ message }}
    </li>
  </ol>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
  props: {
    name: {
      type: String,
      required: true
    }
  },
  computed: {
    ...mapGetters({
      hasErrors: 'form/hasErrors',
      errorMessages: 'form/errorMessages'
    })
  }
}
</script>
