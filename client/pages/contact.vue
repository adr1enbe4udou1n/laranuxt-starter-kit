<template>
  <page>
    <header-cta slot="hero"></header-cta>

    <div class="bg-white text-gray-700">
      <div class="container max-w-2xl mx-auto">
        <h1 class="text-2xl font-bold">Contact</h1>
        <form class="border-b py-8" @submit.prevent="onSubmit">
          <alert
            v-if="alert"
            :type="alert.type"
            title="Validation du formulaire"
            :message="alert.message"
          ></alert>

          <label class="block">
            <span class="">Name</span>
            <input
              v-model="form.name"
              class="form-input mt-1 block w-full"
              placeholder="Jane Doe"
              required
            />
          </label>

          <label class="block mt-4">
            <span class="">Email</span>
            <input
              v-model="form.email"
              class="form-input mt-1 block w-full"
              placeholder="jane.doe@example.com"
              required
            />
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
              class="form-select mt-1 block w-full"
              required
            >
              <option value="">Select limit</option>
              <option value="1000">$1,000</option>
              <option value="5000">$5,000</option>
              <option value="10000">$10,000</option>
              <option value="25000">$25,000</option>
            </select>
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
              class="form-input mt-1 block w-full"
              placeholder="Message"
              :rows="5"
              required
            />
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
          </div>

          <button
            type="submit"
            class="gradient text-white mx-auto lg:mx-0 hover:underline bg-white font-bold rounded-full my-6 py-4 px-8 shadow-lg"
            :disabled="pending"
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
    async onSubmit() {
      this.pending = true

      try {
        const { message } = await this.$contactApi.sendContact({
          ...this.form,
          gRecaptchaResponse: await this.$recaptcha.execute('contact')
        })

        this.alert = {
          type: 'success',
          message
        }

        this.pending = false
      } catch (e) {
        if (e instanceof Response) {
          this.alert = {
            type: 'error',
            message: e.json().message
          }
        }
        this.pending = false
      }
    }
  }
}
</script>
