<template>
<span>
    <div class="form-group mt-4">
        <label for="" class="col-form-label">Select Client: <span class="text-danger">*</span></label>
        <select name="client_id" id="" class="form-control" v-model="selectedClient" @change="getReferenceNumber()">
            <option value="" disabled selected>Please select a client</option>
            <option v-if="clients.length == 0" value="" disabled selected><span class="text-danger"> No Clients found. Please create a client first.</span></option>
            <option v-else v-for="(client, key) in clients" :key="key" :value="client.id">{{client.company_name}}</option>
        </select>
    </div>
    <div class="form-group mt-4">
        <label for="" class="col-form-label">Select Reference: </label>
        <select name="reference_number_id" id="" class="form-control">
            <option value="" disabled selected>Please select a reference name:</option>
            <option v-if="referenceNumbers.length == 0" value="" disabled selected><span class="text-danger"> No Reference found. Please create a Reference first.</span></option>
            <option v-else v-for="(referenceNumber, key) in referenceNumbers" :key="key" :value="referenceNumber.id">{{referenceNumber.name}}</option>
        </select>
    </div>
    <div class="form-group mb-1">
        <label for="" class="col-form-label">Applicable deadlines:</label>
        <small class="text-dark"><br>Toogle the switch here to remove any deadlines that is not needed, in this reminder.</small>
    </div>
    <span v-if="deadlines.length > 0">
        <div class="table-responsive">
            <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Deadlines</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(deadline, indexSwitch) in deadlines" :key="indexSwitch">
                        <td>
                            {{deadline.name}}
                        </td>
                        <td>
                            <div class="form-group">
                                <label class="switch switch-label switch-pill switch-success mr-2">
                                <input class="switch-input" type="checkbox" @change="switchChanged(indexSwitch)" v-model="checked[indexSwitch]">
                                    <span class="switch-slider" data-checked="on" data-unchecked="off"></span>
                                </label>
                            </div>
                        </td>
                    </tr>
                    </tbody>
            </table>
        </div>
        
    </span>
    <span v-else class="text-danger">No Dealines found. Please create a deadline first in Master Settings</span>
    <div class="table-responsive mt-2">
        <table class="table table-bordered">
            <!-- Deadline loop -->
            <tr v-for="(deadline,index1) in deadlines" :key="index1" v-if="checked[index1]" class="w-100">
                <table class="table bg-light">
                    <tr>
                        <th>Deadline</th>
                        <th>Date &amp; Time</th>
                        <th>Recurrence</th>
                        <th>SMS</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>
                    <tr>
                        <td :rowspan="length[index1]">
                            {{deadline.name}}
                        </td>
                        <td>
                            <div class="input-group">
                                <input type="hidden" :name="'reminders_data['+index1+'][deadline_id]'" :value="deadline.id">
                                <input type="date" :name="'reminders_data['+index1+'][0][date]'" class="form-control col-md-5">
                                <input type="time" class="form-control" :name="'reminders_data['+index1+'][0][time]'" value="11:00">
                                <div class="input-group-append">
                                    <span class="input-group-text bg-danger" id="basic-addon2">Required</span>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <select :name="'reminders_data['+index1+'][0][recurring_id]'" id="" class="form-control">
                                <option value="" selected>Select recurrence</option>
                                <option :value="recur.id" v-for="(recur, recurKey) in recurrings" :key="recurKey">
                                    {{recur.name}}</option>
                                </select>
                            </div>
                        </td>
                        <td>
                            <label class="switch switch-label switch-pill switch-success mr-2" :for="'to-sms-'+(index1)+'-0'" >
                                <input class="switch-input" type="checkbox" :name="'reminders_data['+index1+'][0][send_sms]'" :id="'to-sms-'+(index1)+'-0'" checked>
                                    <span class="switch-slider" data-checked="on" data-unchecked="off"></span>
                            </label>
                        </td>
                        <td>
                            <label class="switch switch-label switch-pill switch-success mr-2" :for="'to-email-'+(index1)+'-0'">
                                <input class="switch-input" type="checkbox" :name="'reminders_data['+index1+'][0][send_email]'" :id="'to-email-'+(index1)+'-0'" checked>
                                    <span class="switch-slider" data-checked="on" data-unchecked="off"></span>
                            </label>
                        </td>
                        <td>
                            <button class="btn btn-primary" type="button" @click="addDateRow(index1)">Add More</button>
                        </td>
                    </tr>
                    <!-- add more loop -->
                    <tr id="reminder-date-tr" v-for="(row, index) in rows[index1]" :key="index" :innerIndex="index">
                        <td> 
                            <div class="input-group px-3">
                                <input type="date" :name="'reminders_data['+index1+']['+(index+1)+'][date]'" class="form-control" v-model="row.date">
                                <input type="hidden" :name="'reminders_data['+index1+'][deadline_id]'" :value="deadline.id">
                                <input type="time" class="form-control" :name="'reminders_data['+index1+']['+(index+1)+'][time]'" v-model="row.time">
                            </div>
                        </td>
                        <td>
                            <div class="form-group mt-3 px-2">
                                <select :name="'reminders_data['+index1+']['+(index+1)+'][recurring_id]'" id="" class="form-control " v-model="row.recurringId">
                                    <option value="" selected>Select recurrence</option>
                                    <option :value="recur.id" v-for="(recur, recurKey) in recurrings" :key="recurKey">
                                        {{recur.name}}</option>
                                </select>
                            </div>
                        </td>
                        <td>
                            <label class="switch switch-label switch-pill switch-success ml-2 mt-2" :for="'to-sms-'+(index1)+(index+1)" >
                                <input class="switch-input" type="checkbox" :name="'reminders_data['+index1+']['+(index+1)+'][send_sms]'" :id="'to-sms-'+(index1)+(index+1)" checked>
                                    <span class="switch-slider" data-checked="on" data-unchecked="off"></span>
                            </label>
                        </td>
                        <td>
                            <label class="switch switch-label switch-pill switch-success ml-2 mt-2" :for="'to-email'+(index1)+(index+1)">
                                <input class="switch-input" type="checkbox" :name="'reminders_data['+index1+']['+(index+1)+'][send_email]'" :id="'to-email'+(index1)+(index+1)" checked>
                                    <span class="switch-slider" data-checked="on" data-unchecked="off"></span>
                            </label>
                        </td>
                        <td>
                            <a v-on:click="removeElement(index, index1);" style="cursor: pointer" class="text-danger"><i class="fa fa-trash ml-4"></i> Remove</a>
                        </td>
                    </tr>
                </table>
            </tr>
        </table>
    </div>
    <input type="hidden" name="has_reminded" value="0">
    <div class="form-group"><button type="submit" class="btn btn-success pull-right">Save</button></div>
</span>
</template>

<script>

export default {
    props: ['deadlines', 'clients', 'recurrings'],
    data: function(){
        return {
            rows: [],
            checked: [],
            referenceNumbers: {},
            selectedClient: "",
            sendSMS: "checked",
            sendEmail: "checked",
            sendSmsValue: 1,
            sendEmailValue: 1,
            length: []
        }
    },
    beforeMount: function(){
        var deadlinesCount = this.deadlines.length;
        var self = this;
        for(var i = 0; i<deadlinesCount; i++){
            self.$set(self.rows, i, []);
            self.$set(self.checked, i, true);
            self.$set(self.length, i, 1);
        };
    },
    methods: {
        addDateRow: function(key){
            var elem = document.createElement('tr');
            this.rows[key].push({
                date: '',
                time: '11:00',
                recurringId: ''
            });
            this.length[key] = this.rows[key].length+1;
        },
        removeElement: function(index, index1){
            this.rows[index1].splice(this.index, 1);
        },
        switchChanged: function(indexSwitch){
            console.log(this.checked[indexSwitch]);
            if(this.checked[indexSwitch] == false){
                
            }else{
                this.deadlines.splice(indexSwitch,0);
            }
        },
        getReferenceNumber: function(){
            this.clients.forEach(client => {
                if(client.id === this.selectedClient){
                    this.referenceNumbers = client.reference_numbers;
                }
            });
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
