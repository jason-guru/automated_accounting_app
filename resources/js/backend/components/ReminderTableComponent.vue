<template>
<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>
                    Deadline
                </th>
                <th>
                    Reminder Dates
                </th>
                <th>
                    Action
                </th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(deadline,index1) in deadlines" :key="index1">
                <td>{{deadline.name}}</td>
                <td>
                    <input type="hidden" name="deadline_id" :value="deadline.id">
                    <input type="date" name="remind_date[]" class="form-control col-md-5">
                    <table>
                        <tbody>
                            <tr id="reminder-date-tr" v-for="(row, index) in rows[index1]" :key="index">
                                <td> 
                                    <input type="date" name="remind_date[]" class="form-control mt-2">
                                </td>
                                <td>
                                    <a v-on:click="removeElement(index);" style="cursor: pointer" class="text-danger"><i class="fa fa-trash ml-2"></i></a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
                <td>
                    <button class="btn btn-primary" type="button" @click="addDateRow(index1)">Add More</button>
                </td>
            </tr>
        </tbody>
    </table>
</div>
</template>

<script>

export default {
    props: ['deadlines'],
    data: function(){
        return {
            rows: []
        }
    },
    beforeMount: function(){
        var deadlinesCount = this.deadlines.length;
        var self = this;
        for(var i = 0; i<deadlinesCount; i++){
            self.rows[i] = [];
        };
    },
    methods: {
        addDateRow: function(key){
            var elem = document.createElement('tr');
            this.rows[key].push({
                date: ""
            });
        },
        removeElement: function(ind){
            
            this.rows.splice(ind, 1);
        }
    },
}

</script>

<style scoped>
    tr#reminder-date-tr td{
        padding: 0 !important;
        vertical-align: middle !important;
        border-top: none !important;
    }
</style>
