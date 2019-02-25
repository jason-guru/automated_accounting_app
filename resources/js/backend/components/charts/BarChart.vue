<script>
import { Bar } from 'vue-chartjs'

export default {
  props: {
    chartData: {
      type: Object,
      required: true
    },
  },
  data: () => ({
    dialogVisible: false,
    options: {}
  }), 
  extends: Bar,
  mounted () {
    var self = this;
    this.options = {
      responsive: true,
      maintainAspectRatio: false,
      scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true,
                    stepSize: 1
                }
            }]
        },
      title: {
            display: true,
            text: 'Deadlines'
        },
      onClick: function(e){
        self.barClick(e)
      }
    };
    this.renderChart(this.chartData, this.options)
  },
  methods: {
    barClick: function(e){
      var activeBar = this.$data._chart.getElementAtEvent(e)[0];
      var clientIds = [];
      this.dialogVisible = true;
      if(activeBar != undefined){
        var path = activeBar._chart.data.clientIds;
        if(activeBar._model.datasetLabel === "Due"){
          switch(activeBar._model.label){
            case "CS":
              clientIds = path.csDue;
            break;

            case "AA":
            clientIds = path.aaDue;
            break;

            case 'VAT':
            clientIds = path.vatDue;
            break;

            case 'PAYE':
            clientIds = path.payeDue;
            break;

            case 'CIS':
            clientIds = path.cisDue;
            break;
          }
        }else if(activeBar._model.datasetLabel === "Overdue"){
          switch(activeBar._model.label){
            case "CS":
              clientIds = path.csOverDue;
            break;

            case "AA":
            clientIds = path.aaOverDue;
            break;

            case 'VAT':
            clientIds = path.vatOverDue;
            break;

            case 'PAYE':
            clientIds = path.payeOverDue;
            break;

            case 'CIS':
            clientIds = path.cisOverDue;
            break;
          }
          
        }
        this.$store.commit('toggleDialog', true);
        this.$store.commit('setClientIds', clientIds);
        this.$store.commit('setActiveDeadline', activeBar._model.label);
        this.$store.commit('setActiveLegend', activeBar._model.datasetLabel);
      }
    }
  },
}
</script>