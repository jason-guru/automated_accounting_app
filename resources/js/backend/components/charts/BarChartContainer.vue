<template>
<span v-loading="fullLoading">
  <bar-chart
    v-if="loaded"
    :chart-data="chartdata"/>

    <el-dialog
    :title="dialogTitle"
    :visible.sync="dialogVisible"
    width="90%"
    @closed="handleClose"
    >
    <form action="" method="post" @submit.prevent="handleReminder">
      <span>
        <table class="table table-bordered">
          <tr>
            <th>Company Name</th>
            <th>From</th>
            <th>To</th>
            <th  v-if="activeLegend === 'Due'">Due On</th>
            <th v-if="activeLegend === 'Overdue'">Overdue</th>
            <th>Sms</th>
            <th>Email</th>
            <th>Remind Date</th>
            <th>Remind Time</th>
            <th>Recurance</th>
          </tr>
          <tr v-show="loading">
            <td colspan="10" align="center">
              Loading please wait <i class="fa fa-spinner fa-spin"></i>
            </td>
          </tr>
          <tr v-for="(company, index) in companyData" :key="index" >
            <td>{{company.company_name}}</td>
            <td>
              <span v-if="activeDeadline === 'AA'">
                {{company.aa_from}}
              </span>
              <span v-if="activeDeadline === 'CS'">
                {{company.cs_from}}
              </span>
              <span v-else-if="activeDeadline==='VAT'">
                {{company.vat_from}}
              </span>
              <span v-else-if="activeDeadline==='PAYE'">
                {{company.paye_from}}
              </span>
               <span v-else-if="activeDeadline==='CIS'">
                {{company.cis_from}}
              </span>
            </td>
            <td>
              <span v-if="activeDeadline === 'AA'">
                {{company.aa_to}}
              </span>
              <span v-else-if="activeDeadline === 'CS'">
                {{company.cs_to}}
              </span>
              <span v-else-if="activeDeadline==='VAT'">
                {{company.vat_to}}
              </span>
               <span v-else-if="activeDeadline==='PAYE'">
                {{company.paye_to}}
              </span>
               <span v-else-if="activeDeadline==='CIS'">
                {{company.cis_to}}
              </span>
            </td>
            <td v-if="activeLegend === 'Due'">
              <span v-if="activeDeadline === 'CS'">
                {{company.cs_due}}
              </span>
              <span v-else-if="activeDeadline === 'AA'">
                {{company.aa_due}}
              </span>
              <span v-else-if="activeDeadline === 'VAT'">
                {{company.vat_due}}
              </span>
               <span v-else-if="activeDeadline === 'PAYE'">
                {{company.paye_due}}
              </span>
              <span v-else-if="activeDeadline === 'CIS'">
                {{company.cis_due}}
              </span>
            </td>
            <td v-if="activeLegend === 'Overdue'">
              <span v-if="activeDeadline === 'CS'">
                {{ company.cs_overdue}}
              </span>
              <span v-else-if="activeDeadline === 'AA'">
                {{company.aa_overdue}}
              </span>
              <span v-else-if="activeDeadline === 'VAT'">
                {{company.vat_overdue}}
              </span>
              <span v-else-if="activeDeadline === 'PAYE'">
                {{company.paye_overdue}}
              </span>
              <span v-else-if="activeDeadline === 'CIS'">
                {{company.cis_overdue}}
              </span>
            </td>
            <td>
              <el-switch v-model="company.send_sms">
              </el-switch>
            </td>
            <td>
              <el-switch v-model="company.send_email">
              </el-switch>
            </td>
            <td>
              <input type="date" class="form-control" required v-model="company.remind_date">
            </td>
            <td>
              <input type="time" class="form-control" required v-model="company.schedule_time">
            </td>
            <td>
              <select name="" id="" class="form-control" v-model="company.recurring_id">
                <option 
                v-for="(recurring, index) in recurrings"
                :key="index"
                :value="recurring.value">
                  {{recurring.label}}
                </option>
              </select>
            </td>
          </tr>
        </table>
      </span>
      
      <span slot="footer" class="dialog-footer">
        <button type="button" class="btn btn-light" @click="dialogVisible = false">Cancel</button>
        <button type="submit" class="btn btn-success" :disabled="loading">Confirm</button>
      </span>
    </form>
    </el-dialog>
</span>
</template>

<script>
import BarChart from './BarChart.vue';
import { required, minLength, between } from 'vuelidate/lib/validators'

export default {
  name: 'BarChartContainer',
  props: {
    url: {
      type: String,
      required: true
    }
  },
  data: () => ({
    recurrings:[
      {
        label: 'daily',
        value: 1
      },
      {
        label: 'weekly',
        value: 2
      },
      {
        label: 'monthly',
        value: 3
      },
      {
        label: 'half-yearly',
        value: 4
      },
      {
        label: 'yearly',
        value: 5
      },
    ],
    remindDateEmpty: true,
    scheduleTimeEmpty: true,
    recurringEmpty: true,
    fullLoading: false,
    activeDeadline: '',
    activeLegend: '',
    search: '',
    loading: false,
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
    companyData: [],
    validations: {
      remind_date: {
        required
      }
    }
  }),
  computed:{
    dialogTitle: function(){
      return this.activeDeadline + ' '+this.activeLegend; 
    },
    dialogVisible: {
      get(){
        if(this.$store.state.dialogVisible){
          this.fetchClients();
        }
        return this.$store.state.dialogVisible;
      },
      set(val){
        this.$store.commit('toggleDialog', val);
      }
    },
    clientIds: function(){
      return this.$store.state.dialogClientIds;
    },
    filterValue() {
      return this.$store.state.filterValue;
    },
    dateRangeFilterValue(){
      return this.$store.state.dateRangeFilterValue;
    }
  },
  watch:{
    async filterValue(val){
      var self = this;
      this.loaded = false;
      this.fullLoading = true;
      try {
        await fetch(this.url+'?q='+val)
        .then(response => response.json())
        .then((data) => {
            self.chartdata = data.chartdata;
            }
          )
        this.fullLoading = false;
        this.loaded = true
      } catch (e) {
        console.error(e)
    }
    },
     dateRangeFilterValue: {
        handler: async function (val){
        // Don't relaod if button hasn't been clicked
        if(this.$store.state.dateRangeFilterViaButton){
          if(val.from != null && val.to != null){
            var self = this;
            this.loaded = false;
            this.fullLoading = true;
            try {
              await fetch(this.url+'?dateRange='+JSON.stringify(val))
              .then(response => response.json())
              .then((data) => {
                  self.chartdata = data.chartdata;
                  
                  }
                )
              this.fullLoading = false;
              this.loaded = true
            } catch (error) {
                console.log(error);
            }
          }
        }
      },
      deep: true
    }
  },
  async mounted () {
    var self = this;
    this.loaded = false;
    this.fullLoading = true;
    try {
      await fetch(this.url)
      .then(response => response.json())
      .then((data) => {
          self.chartdata = data.chartdata;
          }
        )
      this.fullLoading = false;
      this.loaded = true
    } catch (e) {
      console.error(e)
    }
  },
  methods:{
    fetchClients(){
      var self = this;
      this.loading = true;
        axios.post('/api/deadline/clients/fetch', this.clientIds).then(response => {
          self.activeDeadline = self.$store.state.activeDeadline;
          self.activeLegend = self.$store.state.activeLegend;
          axios.post('/api/deadline/clients/prepare', response.data).then(response => {
            self.companyData = response.data;
          })
          self.loading = false;
        }).catch(err => {
           
        });
    },
    handleClose(){
      this.activeLegend = '';
      this.activeDeadline='';
      this.companyData = [];
    },
    handleReminder(e){
      e.preventDefault();
      var self = this;
      this.companyData.forEach(function(element){
        switch(self.activeDeadline){
        case 'CS':
        element.deadline_id = 1;
        break; 

        case 'AA':
        element.deadline_id = 2;
        break; 

        case 'VAT':
        element.deadline_id = 3;
        break; 

        case 'PAYE':
        element.deadline_id = 4;
        break; 

        case 'CIS':
        element.deadline_id = 5;
        break; 
      }
      });

      var reminder = [];
        this.companyData.forEach(function(element){
          reminder.push(JSON.stringify(element))
      });
      axios.post('/api/reminders', reminder).then(response => {
        self.dialogVisible = false;
        this.success('Reminder Set Successfully');
      })
    },
    success(message) {
      this.$message({
          showClose: true,
          message: message,
          type: 'success'
      });
    },
  },
  components: { BarChart }
}
</script>