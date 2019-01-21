<template>
  <div class="view">

  </div>
</template>

<script>
export default {
  name: 'view',
  data () {
    return {
      url_key: '',
      data: {}
    }
  },
  mounted: {
    getStrawpoll: function() {
      this.axios
              .get('http://localhost:8000/api/strawpoll/view/' + this.url_key)
              .then(response => (
                              console.log(response)
                      )
              )
    }
  },
  methods: {
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>
