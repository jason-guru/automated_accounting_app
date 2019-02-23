<template>
    <div>
        <el-table
            v-loading="loading"
            :data="clientsData"
            style="width: 100%">
            <el-table-column type="expand">
                <template slot-scope="props">
                    <p v-for="(deadline, index) in props.row.deadlines" :key="index" @click="handleDeadlineEdit(deadline.pivot, deadline.name, deadline.code)" class="deadline-types">{{deadline.name}}</p>
                </template>
            </el-table-column>
            <el-table-column
            label="Company Name"
            prop="company_name">
            </el-table-column>
            <el-table-column
            label="Company Type"
            prop="company_type.name">
            </el-table-column>
        </el-table>
        <el-dialog
            :title="dialogTitle"
            :visible.sync="dialogVisible"
            width="30%"
            >
            <el-form ref="deadlineForm" :model="deadlineForm" label-width="120px">
                <el-form-item label="From" 
                :rules = "[
                    { type: 'date', required: true, message: 'Please pick a date', trigger: 'change' },
                ]">
                    <el-date-picker type="date" placeholder="Pick a date" v-model="deadlineForm.from" style="width: 100%;" :disabled="disableInputField"></el-date-picker>
                </el-form-item>
                <el-form-item label="To" 
                :rules = "[
                    { type: 'date', required: true, message: 'Please pick a date', trigger: 'change' },
                ]"
                >
                    <el-date-picker type="date" placeholder="Pick a date" v-model="deadlineForm.to" style="width: 100%;" :disabled="disableInputField"></el-date-picker>
                </el-form-item>
                <el-form-item label="Due On"
                :rules = "[
                    { type: 'date', required: true, message: 'Please pick a date', trigger: 'change' },
                ]"
                >
                    <el-date-picker type="date" placeholder="Pick a date" v-model="deadlineForm.due_on" style="width: 100%;" :disabled="disableInputField"></el-date-picker>
                </el-form-item>
            </el-form>
            <span slot="footer" class="dialog-footer">
                <el-button @click="dialogVisible = false">Cancel</el-button>
                <el-button type="primary" @click="handleSubmit('deadlineForm')" :disabled="disableInputField">Confirm</el-button>
            </span>
        </el-dialog>

    </div>
</template>
<script>
export default {
    props: [
        'clients'
    ],
    data() {
        return {
            clientsData: [],
            loading: false,
            dialogVisible: false,
            dialogTitle: "",
            disableInputField: false,
            deadlineForm: {
                from: null,
                to: null,
                due_on: null,
                client_id: null,
                deadline_id: null
            },
            rules: {
                from: [
                    { required: true, message: 'Please input from date', trigger: 'blur' },
                ],
                to: [
                    { required: true, message: 'Please input to date', trigger: 'blur' },
                ],
                due_on: [
                    { required: true, message: 'Please input Due on date', trigger: 'blur' },
                ],
            }
        }
    },
    beforeMount(){
        this.fetchClients();
    },
    methods: {
        handleDeadlineEdit: function(pivotData, title, code){
            this.deadlineForm.client_id = pivotData.client_id;
            this.deadlineForm.deadline_id = pivotData.deadline_id;
            this.deadlineForm.from = pivotData.from;
            this.deadlineForm.to = pivotData.to;
            this.deadlineForm.due_on = pivotData.due_on;
            if(code === 'AA' || code === 'CS'){
                this.disableInputField = true;
            }else{
                this.disableInputField = false;
            }
            this.dialogVisible = true;
            this.dialogTitle = title + ' Information';
        },
        handleSubmit: function(formName){
            this.$refs[formName].validate((valid) => {
                console.log(formName);
                if(valid){
                    var self = this;
                    var prepFromDate = new Date(self.deadlineForm.from);
                    var convertedFromDate = prepFromDate.toISOString().substring(0,10);
                    this.deadlineForm.from = convertedFromDate;

                    var prepToDate = new Date(self.deadlineForm.to);
                    var convertedToDate = prepToDate.toISOString().substring(0,10);
                    this.deadlineForm.to = convertedToDate;

                    var prepDueOnDate = new Date(self.deadlineForm.due_on);
                    var convertedDueOnDate = prepDueOnDate.toISOString().substring(0,10);
                    this.deadlineForm.due_on = convertedDueOnDate;

                    this.dialogVisible = false;
                    axios.post('/admin/client/deadline', this.deadlineForm).then(response => {
                        this.fetchClients();
                        this.success(response.data.message);
                    }).catch(error => {
                        this.error(error.response.data);
                    })
                }else {
                    return false;
                }
            });
            
        },
        fetchClients: function(){
            this.loading = true;
            var self = this;
            axios.get('/admin/client/deadline/fetch').then(response => {
                this.loading = false;
                self.clientsData = response.data.clients;
            }).catch(error => {

            })
        },
        success(message) {
        this.$message({
            showClose: true,
            message: message,
            type: 'success'
        });
        },

        warning(message) {
        this.$message({
            duration: 0,
            showClose: true,
            message: message,
            type: 'warning'
        });
        },

        error(message) {
        this.$message({
            duration: 0,
            showClose: true,
            message: message,
            type: 'error'
        });
        },
    }
}
</script>
<style scoped>
    .deadline-types{
        cursor: pointer;
        color: #2DC3E8;
    }
    .deadline-types:hover{
        text-decoration: underline
    }
</style>

