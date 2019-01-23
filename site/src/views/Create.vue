<template>
  <div class="container">

    <div class="row">
      <div class="col-lg-8">
        <div class="input-group">
          <input type="text" class="form-control" v-model="data.name"/>
        </div>
      </div>
    </div>

    <div class="row">
      <auto-input
          :data="data.options"
          :btn-action="removeInput"
          :new-input-event="true"
      />
    </div>

    <div class="row">
      <button @click="createStrawpoll">create</button>
    </div>


  </div>
</template>

<script>
import autoInput from '../components/AutoInputField.vue'

export default {
  name: 'Create',
  data () {
    return {
      data: {
        name: '',
        options: [{name:""}]
      },
      info: ''
    }
  },
  methods: {
    createStrawpoll: function() {
      this.axios
        .post('http://localhost:8002/api/strawpoll/create',
          JSON.stringify(this.data)
        )
        .then(response => (
             this.$router.push('/view/'+response.data.url_key)
          )
        )
    },
    removeInput: function(index) {
      this.data.options.splice(index, 1);
    }
  },
  components: {
    autoInput
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>
