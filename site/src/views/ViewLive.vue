<template>
  <div class="container">

      <!-- Page Heading -->
      <h1 class="my-4">{{data.name}}
      </h1>

      <!-- Project One -->
      <div class="row">
          <div class="col-md-7">
              <auto-input
                      :btn-action="sendMessage"
                      :data="data.options"
                      :btn-action-taken="true"
                      :btn-class="'btn btn-primary'"
                      :btn-name="'Vote'"
              />

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
  import autoInput from '../components/AutoInputField'
export default {
  name: 'viewStrawpoll',
  data () {
    return {
      url_key: '',
      data: {
          name: '',
          options: []
      },
      chartData: [],
      chartOptions: {
          title: 'Company Performance',
          subtitle: 'Sales, Expenses, and Profit: 2014-2017',
          'height':400,
      },
        message: '',
        chat: {}
    }
  },
  watch: {
    data: function(data) {
        console.log(data,1 );
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
      this.conn = new WebSocket('ws://localhost:8090');

      this.conn.onopen = function(e) {
          console.info("Connection established succesfully");
      };

      this.conn.onmessage = this.onMessage;

      this.conn.onerror = function(e){
          alert("Error: something went wrong with the socket.");
      };

      this.axios
          .get('http://localhost:8002/api/strawpoll/view/' + this.$route.params.url_key)
          .then(response => (this.data = response.data))
  },
    methods: {
        vote: function(index) {
            this.axios
                .post('http://localhost:8002/api/strawpoll/vote/' + this.data.options[index].id)
                .then(response => (this.data = response.data))
        },
        sendMessage: function(index) {
            this.conn.send(this.data.options[index].id);
            this.message = '';
        },
        onMessage: function(data) {
            this.data = JSON.parse(data.data);
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
