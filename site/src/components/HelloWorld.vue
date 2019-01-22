<template>
  <div class="hello">
    <input v-model="data.name"><br>

    <table class="table">
      <thead>
      <tr>
        <td><strong>Options</strong></td>
        <td></td>
      </tr>
      </thead>
      <tbody>
        <tr v-for="(option, index) in data.options" v-bind:key="index">
          <td><input type="text" v-model="option.name" @keydown.enter="addRow"></td>
          <td>
            <a v-on:click="removeElement(index);" style="cursor: pointer">Remove</a>
          </td>
        </tr>
      </tbody>
    </table>
    <div>
      <button class="button btn-primary" @click="addRow">Add option</button>
    </div><br>
    <button @click="createStrawpoll">create</button>
  </div>
</template>

<script>
export default {
  name: 'HelloWorld',
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
        .post('http://localhost:8001/api/strawpoll/create',
          JSON.stringify(this.data)
        )
        .then(response => (
             this.$router.push('/view/'+response.data.url_key)
          )
        )
    },
    addRow: function() {
      this.data.options.push({
        name: ""
      });
    },
    removeElement: function(index) {
      this.data.options.splice(index, 1);
    },
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>
