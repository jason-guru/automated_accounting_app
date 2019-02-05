<script>
import { Bar } from 'vue-chartjs'

export default {
  props: {
    chartData: {
      type: Object,
      required: true
    },
    options: {
      type: Object,
      required: true
    }
  },
  extends: Bar,
  mounted () {
    this.renderChart(this.chartData, this.options)
  }
}
</script>