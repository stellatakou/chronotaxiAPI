<template>
  <v-app>
    <v-navigation-drawer></v-navigation-drawer>
    <v-content>
      <router-link tag="li" to="/home">Home</router-link>
      <router-view></router-view>
    </v-content>
    <v-footer app></v-footer>
  </v-app>
</template>

<script>
export default {};
</script>

