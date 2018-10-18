<template>
<span>
    <div class="form-group mt-4">
        <label for="" class=" col-form-label">Select Client: <span class="text-danger">*</span></label>
        <select name="client_id" id="" class="form-control">
            <option v-for="(client, key) in clients" :key="key" :value="client.id">{{client.company_name}}</option>
        </select>
    </div>
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
                        <div class="input-group mb-3">
                            <input type="date" name="remind_date[]" class="form-control col-md-5">
                            <div class="input-group-append">
                                <span class="input-group-text" id="basic-addon2">Required</span>
                            </div>
                            </div>
                        <table>
                            <tbody>
                                <tr id="reminder-date-tr" v-for="(row, index) in rows[index1]" :key="index" :innerIndex="index">
                                    <td> 
                                        <input type="date" name="remind_date[]" class="form-control mt-2" v-model="row.date">
                                    </td>
                                    <td>
                                        <a v-on:click="removeElement(index, index1);" style="cursor: pointer" class="text-danger"><i class="fa fa-trash ml-2"></i></a>
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
    <input type="hidden" name="has_reminded" value="0">
    <div class="form-group"><button type="submit" class="btn btn-success pull-right">Save</button></div>
</span>
</template>

<script>

export default {
    props: ['deadlines', 'clients'],
    data: function(){
        return {
            rows: [],
        }
    },
    beforeMount: function(){
        var deadlinesCount = this.deadlines.length;
        var self = this;
        for(var i = 0; i<deadlinesCount; i++){
            self.$set(self.rows, i, [])
        };
    },
    methods: {
        addDateRow: function(key){
            var elem = document.createElement('tr');
            this.rows[key].push({
                date: ''
            });
        },
        removeElement: function(index, index1){
            this.rows[index1].splice(this.index, 1);
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
