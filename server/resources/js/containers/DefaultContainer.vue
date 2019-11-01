<template>
  <div class="app">
    <AppHeader fixed>
      <SidebarToggler class="d-lg-none" display="md" mobile></SidebarToggler>
      <b-link class="navbar-brand" to="/dashboard">
        <img class="navbar-brand-full" src="/brand/logo.svg" width="150" height="33" alt="My Company" />
        <img class="navbar-brand-minimized" src="/brand/logo-mini.svg" width="40" height="40" alt="My Company" />
      </b-link>
      <SidebarToggler class="d-md-down-none" display="lg"></SidebarToggler>
      <b-navbar-nav class="ml-auto">
        <DefaultHeaderDropdownAccount @logout="logout"></DefaultHeaderDropdownAccount>
      </b-navbar-nav>
    </AppHeader>
    <div class="app-body">
      <AppSidebar fixed>
        <SidebarHeader></SidebarHeader> <SidebarForm></SidebarForm>
        <SidebarNav :nav-items="nav"></SidebarNav>
        <SidebarFooter></SidebarFooter> <SidebarMinimizer></SidebarMinimizer>
      </AppSidebar>
      <main class="main">
        <b-alert variant="warning" class="alert-top mb-0" :show="$app.is_impersonation">
          <span
            v-html="
              $t('alerts.login_as', {
                name: $store.state.user.name
              })
            "
          ></span>
          <a href="javascript:void(0)" @click="logout">{{ $app.usurper_name }}</a>
        </b-alert>
        <Breadcrumb :list="list"></Breadcrumb>
        <div class="container-fluid"><router-view></router-view></div>
      </main>
    </div>
    <TheFooter>
      <!-- footer -->
      <div>
        <span>&copy; {{ new Date().getFullYear() }} {{ $app.name }}.</span>
      </div>
      <div class="ml-auto">
        <i class="fe fe-code"></i> with <i class="fe fe-heart"></i> by <a href="https://www.useweb.fr">My Company</a>
      </div>
    </TheFooter>
  </div>
</template>

<script>
import { createNav } from '@/_nav'
import { mapActions } from 'vuex'
import {
  Header as AppHeader,
  SidebarToggler,
  Sidebar as AppSidebar,
  SidebarFooter,
  SidebarForm,
  SidebarHeader,
  SidebarMinimizer,
  SidebarNav,
  Footer as TheFooter,
  Breadcrumb
} from '@coreui/vue'
import DefaultHeaderDropdownAccount from './DefaultHeaderDropdownAccount'

export default {
  name: 'DefaultContainer',
  components: {
    DefaultHeaderDropdownAccount,
    AppHeader,
    AppSidebar,
    TheFooter,
    Breadcrumb,
    SidebarForm,
    SidebarFooter,
    SidebarToggler,
    SidebarHeader,
    SidebarNav,
    SidebarMinimizer
  },
  data() {
    return {
      nav: createNav(this.$router, this.$i18n)
    }
  },
  computed: {
    name() {
      return this.$route.name
    },
    list() {
      return this.$route.matched.filter((route) => route.name || route.meta.label)
    }
  },
  methods: {
    ...mapActions(['logout'])
  }
}
</script>
