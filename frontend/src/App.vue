<template>
  <div>
      <MainView/>
  </div>
</template>

<script>
import MainView from './components/MainView.vue'

export default {
  name: 'App',
  components: {
    MainView
  }
}
</script>

<style>
  @import './assets/css/main.css';
  @import './assets/css/materialize.min.css';
</style>
