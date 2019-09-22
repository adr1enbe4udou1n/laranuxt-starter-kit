<template>
  <AppHeaderDropdown right class="px-4">
    <template slot="header">
      <span class="d-md-down-none"> {{ $store.state.user.name }} </span>
    </template>
    <template slot="dropdown">
      <b-dropdown-item to="/profile"> <i class="fe fe-user"></i>{{ $t('navs.profile') }} </b-dropdown-item>
      <b-dropdown-item href="javascript:void(0)" @click="$emit('logout')">
        <i class="fe fe-lock"></i>{{ $t('navs.logout') }}
      </b-dropdown-item>
    </template>
  </AppHeaderDropdown>
</template>

<script>
import { HeaderDropdown as AppHeaderDropdown } from '@coreui/vue'

export default {
  name: 'DefaultHeaderDropdownAccount',
  components: {
    AppHeaderDropdown
  }
}
</script>
