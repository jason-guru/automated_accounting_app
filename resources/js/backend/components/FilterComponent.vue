<template>
<span>
    <div class="row">
        <div class="col-md-2">
            <el-dropdown @command="handleCommand">
                <el-button type="success">
                    Sort By<i class="el-icon-arrow-down el-icon--right"></i>
                </el-button>
                <el-dropdown-menu slot="dropdown">
                    <el-dropdown-item v-for="(value, index) in values" :key="index" :command="value">{{value}}</el-dropdown-item>
                </el-dropdown-menu>
            </el-dropdown>
        </div>
        <div class="col-md-8">
           <el-form ref="dateRangeForm" label-width="160px">
               <el-form-item label="Filter By Date Range">
                    <el-row :gutter="3">
                        <el-col :span="7" >
                            <el-date-picker type="date" placeholder="From" v-model="dateRangeFilter.from" style="width: 100%;"></el-date-picker>
                        </el-col>
                        <el-col :span="7">
                            <el-date-picker placeholder="To" v-model="dateRangeFilter.to" style="width: 100%;"></el-date-picker>
                        </el-col>
                        <el-col :span="7">
                            <el-button @click="handleDateRangeFilter()">Submit</el-button>
                        </el-col>
                    </el-row>
               </el-form-item>
           </el-form>
        </div>
        <div class="col-md-2">
            <p class="pull-right text-uppercase"><strong>{{filterName}}</strong></p>
        </div>
    </div>
    <hr>
</span>
</template>

<script>
export default {
    props: {
        values:{
            type: Array,
            required: true
        }
       
    },
    data() {
        return {
            dateRangeFilter: {
                'from': '',
                'to': ''
            }
        }
    },
    updated(){
        
    },
    computed:{
        filterName : function(){
            return this.$store.state.filterValue;
        }
    },
    methods:{
        handleCommand(command){
            this.$store.commit('setFilter', command);
        },
        handleDateRangeFilter(){
            this.dateRangeFilter.from = this.elementUiDateConvert(this.dateRangeFilter.from);
            this.dateRangeFilter.to = this.elementUiDateConvert(this.dateRangeFilter.to);
            this.$store.commit('setDateRange', this.dateRangeFilter)
        }
    }
}
</script>

<style>

</style>
