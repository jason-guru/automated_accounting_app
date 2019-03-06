<template>
    <el-dropdown @command="handleCommand">
        <el-button type="primary">
            Filter<i class="el-icon-arrow-down el-icon--right"></i>
        </el-button>
        <el-dropdown-menu slot="dropdown">
            <el-dropdown-item v-for="(value, index) in values" :key="index" :command="value">{{value}}</el-dropdown-item>
        </el-dropdown-menu>
    </el-dropdown>
</template>

<script>
export default {
    props: {
        values:{
            type: Array,
            required: true
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
