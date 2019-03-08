<template>
<span>
    <el-dropdown @command="handleCommand">
        <el-button type="success">
            Sort By<i class="el-icon-arrow-down el-icon--right"></i>
        </el-button>
        <el-dropdown-menu slot="dropdown">
            <el-dropdown-item v-for="(value, index) in values" :key="index" :command="value">{{value}}</el-dropdown-item>
        </el-dropdown-menu>
    </el-dropdown>
    <p class="pull-right text-uppercase"><strong>{{filterName}}</strong></p>
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
    computed:{
        filterName : function(){
            return this.$store.state.filterValue;
        }
    },
    methods:{
        handleCommand(command){
            this.$store.commit('setFilter', command);
        }
    }
}
</script>

<style>

</style>
