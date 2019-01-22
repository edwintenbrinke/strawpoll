<template>
  <div class="container">

      <!-- Page Heading -->
      <h1 class="my-4">{{data.name}}
      </h1>

      <!-- Project One -->
      <div class="row">
        <div class="col-md-7">
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
                <a v-on:click="vote(index);" style="cursor: pointer">Vote</a> {{option.votes}}
              </td>
            </tr>
            </tbody>
          </table>
        </div>
        <div class="col-md-5">
          <GChart
            type="PieChart"
            :data="chartData"
            :options="chartOptions"
          />
        </div>
      </div>


  </div>
</template>

<script>
export default {
  name: 'viewStrawpoll',
  data () {
    return {
      url_key: '',
      data: {},
      chartData: [],
      chartOptions: {
        chart: {
          title: 'Company Performance',
          subtitle: 'Sales, Expenses, and Profit: 2014-2017',
        }
      }
    }
  },
  watch: {
    data: function(data) {
      //make data digestable for google charts
      this.chartData = [];
      this.chartData.push(['Task', 'Votes']);
      data.options.forEach(function(e){
        this.chartData.push([e.name, e.votes])
              }

      ,this);
    }
  },
  created: function() {
      this.axios
        .get('http://localhost:8001/api/strawpoll/view/' + this.$route.params.url_key)
        .then(response => (
            this.data = response.data
          )
        )

  },
  methods: {
      vote: function(index) {
        this.axios
          .post('http://localhost:8001/api/strawpoll/vote/' + this.data.options[index].id)
          .then(response => (
                  this.data = response.data
              )
          )
      }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>
