<template>
  <page>
    <header-cta slot="hero"></header-cta>

    <div class="bg-white text-gray-700">
      <div class="container max-w-2xl mx-auto">
        <h1 class="text-2xl font-bold">Contact</h1>
        <form @submit.prevent="onSubmit" class="border-b py-8">
          <alert
            v-if="alert"
            :type="alert.type"
            :title="alert.title"
            :message="alert.message"
          ></alert>

          <label class="block">
            <span class="">Name</span>
            <input
              v-model="form.name"
              v-validate="'name'"
              class="form-input mt-1 block w-full"
              placeholder="Jane Doe"
            />
            <form-invalid-feedback name="name"></form-invalid-feedback>
          </label>

          <label class="block mt-4">
            <span class="">Email</span>
            <input
              v-model="form.email"
              v-validate="'email'"
              class="form-input mt-1 block w-full"
              placeholder="jane.doe@example.com"
            />
            <form-invalid-feedback name="email"></form-invalid-feedback>
          </label>

          <div class="mt-4">
            <span class="">Account Type</span>
            <div class="mt-2">
              <label class="inline-flex items-center">
                <input
                  v-model="form.type"
                  type="radio"
                  class="form-radio"
                  name="accountType"
                  value="personal"
                />
                <span class="ml-2">Personal</span>
              </label>
              <label class="inline-flex items-center ml-6">
                <input
                  v-model="form.type"
                  type="radio"
                  class="form-radio"
                  name="accountType"
                  value="business"
                />
                <span class="ml-2">Business</span>
              </label>
            </div>
          </div>

          <label class="block mt-4">
            <span class="">Requested Limit</span>
            <select
              v-model="form.requestLimit"
              v-validate="'request_limit'"
              class="form-select mt-1 block w-full"
            >
              <option value="">Select limit</option>
              <option value="1000">$1,000</option>
              <option value="5000">$5,000</option>
              <option value="10000">$10,000</option>
              <option value="25000">$25,000</option>
            </select>
            <form-invalid-feedback name="request_limit"></form-invalid-feedback>
          </label>

          <label class="block mt-4">
            <span class="">Address</span>
            <input
              v-model="form.address"
              class="form-input mt-1 block w-full"
              placeholder="Jane Doe"
            />
          </label>

          <div class="flex flex-wrap -mx-3 mt-4">
            <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
              <label class="block">
                <span class="">City</span>
                <input
                  v-model="form.city"
                  class="form-input mt-1 block w-full"
                  placeholder="Jane Doe"
                />
              </label>
            </div>
            <div class="w-full md:w-1/3 px-3">
              <label class="block">
                <span class="">Zip</span>
                <input
                  v-model="form.zip"
                  class="form-input mt-1 block w-full"
                  placeholder="Jane Doe"
                />
              </label>
            </div>
            <div class="w-full md:w-1/3 px-3">
              <label class="block">
                <span class="">Phone</span>
                <input
                  v-model="form.phone"
                  class="form-input mt-1 block w-full"
                  placeholder="Jane Doe"
                />
              </label>
            </div>
          </div>

          <label class="block mt-4">
            <span class="">Message</span>
            <textarea
              v-model="form.message"
              v-validate="'message'"
              :rows="5"
              class="form-input mt-1 block w-full"
              placeholder="Message"
            />
            <form-invalid-feedback name="message"></form-invalid-feedback>
          </label>

          <div class="flex mt-4">
            <label class="flex items-center">
              <input type="checkbox" class="form-checkbox" required />
              <span class="ml-2"
                >I agree to the
                <nuxt-link to="/privacy"
                  ><span class="underline">privacy policy</span></nuxt-link
                ></span
              >
            </label>
          </div>

          <div class="mt-4">
            This site is protected by reCAPTCHA,
            <a
              href="https://policies.google.com/privacy"
              target="_blank"
              class="text-pink-700"
              >Privacy Policy</a
            >
            and
            <a
              href="https://policies.google.com/terms"
              target="_blank"
              class="text-pink-700"
              >Terms of Service</a
            >
            apply.
            <form-invalid-feedback
              name="g-recaptcha-response"
            ></form-invalid-feedback>
          </div>

          <button
            :disabled="pending"
            type="submit"
            class="gradient text-white mx-auto lg:mx-0 hover:underline bg-white font-bold rounded-full my-6 py-4 px-8 shadow-lg"
          >
            Submit
          </button>
        </form>
      </div>
    </div>

    <footer-cta slot="footer"></footer-cta>
  </page>
</template>

<script>
import { mapMutations } from 'vuex'
import HeaderCta from '~/components/call-to-actions/HeaderCta'
import FooterCta from '~/components/call-to-actions/FooterCta'
import Alert from '~/components/Alert'

export default {
  name: 'ContactPage',
  components: {
    HeaderCta,
    FooterCta,
    Alert
  },
  data() {
    return {
      form: {
        name: '',
        email: '',
        type: 'personal',
        requestLimit: '',
        address: '',
        city: '',
        zip: '',
        phone: '',
        message: ''
      },
      alert: null,
      pending: false
    }
  },
  methods: {
    ...mapMutations({
      setErrors: 'form/setErrors',
      clearErrors: 'form/clearErrors'
    }),
    reset() {
      this.form = {
        name: '',
        email: '',
        type: 'personal',
        requestLimit: '',
        address: '',
        city: '',
        zip: '',
        phone: '',
        message: ''
      }
    },
    async onSubmit() {
      this.pending = true

      try {
        const { message } = await this.$submissionApi.contact({
          ...this.form,
          gRecaptchaResponse: await this.$recaptcha.execute('contact')
        })

        this.alert = {
          type: 'success',
          title: 'Success',
          message
        }

        this.clearErrors()
        this.reset()
        this.pending = false
      } catch (e) {
        if (e instanceof Response) {
          const json = await e.json()

          this.alert = {
            type: 'error',
            title: 'Failed',
            message: json.message
          }

          this.setErrors(json.errors)
        }
        this.pending = false
      }
    }
  }
}
</script>
