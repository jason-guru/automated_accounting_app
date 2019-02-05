<template>
    <bar-chart
      v-if="loaded"
      :chart-data="chartdata"
      :options="options"/>
</template>

<script>
import BarChart from './BarChart.vue'

export default {
  name: 'BarChartContainer',
  props: {
    url: {
      type: String,
      required: true
    }
  },
  data: () => ({
    loaded: false,
    chartdata: {
        datasets: [
          {
            label: 'Due',
            backgroundColor: '#f87979',
            data: [40, 50]
          },
          {
            label: 'Overdue',
            backgroundColor: 'red',
            data: [30, 10]
          }
        ]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        },
      title: {
            display: true,
            text: 'Deadlines:- Limited Company'
        }
    }
  }),
  async mounted () {
    this.loaded = false
    var self = this;
      try {
        await fetch(this.url)
        .then(response => response.json())
        .then((data) => {
            self.chartdata = data.chartdata;
            }
          )
        this.loaded = true
      } catch (e) {
        console.error(e)
      }
  },
  components: { BarChart }
}
</script>