<template>
    <div class="card">
        <div class="card-header">
            Business Info
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group" v-if="!individualType">
                        <label for="">Business Start Date</label>
                        <input name="business_start_date" id="" class="form-control" data-toggle="datepicker" v-model="dateOfCreation">
                    </div>
                    <div class="form-group" v-if="!individualType">
                        <label for="">Book Start Date</label>
                        <input data-toggle="datepicker" name="book_start_date" id="" class="form-control" v-model="bookStartDate">
                    </div>
                    <div class="form-group" v-if="!individualType">
                        <label for="">Year End Date</label>
                        <input data-toggle="datepicker" name="year_end_date" id="" class="form-control" v-model="yearEndDate">
                    </div>
                    <div class="form-group" v-if="!individualType && showAll">
                    <label for="">Company Reg No.</label>
                        <input type="text" name="company_reg_number" id="" class="form-control" v-model="companyNumber">
                    </div>
                    <div class="form-group">
                        <label for="">UTR Number</label>
                        <input type="text" name="utr_number" id="" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">UTR</label>
                        <input type="text" name="utr" id="" class="form-control">
                    </div>
                    
                </div>
                <div class="col-md-6">
                    <div class="form-group" v-if="!individualType">
                        <label for="">Vat Submit Type</label>
                        <select name="vat_submit_type_id" id="" class="form-control">
                            <option :value="vatSubmitType.id" v-for="(vatSubmitType, key) in vatSubmitTypes" :key="key">{{vatSubmitType.name}}</option>
                        </select>
                    </div>
                    <div class="form-group" v-if="!individualType">
                        <label for="">VAT Registration Number</label>
                        <input type="text" name="vat_reg_number" id="" class="form-control">
                    </div>
                    <div class="form-group" v-if="!individualType">
                        <label for="">VAT Registration Date</label>
                        <input data-toggle="datepicker" name="vat_reg_date" id="" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">Social Media</label>
                        <input type="text" name="social_media" id="" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">Last Bookkeeping Done</label>
                        <input data-toggle="datepicker" name="last_bookkeeping_done" id="" class="form-control" v-model="lastBookkeepingDone">
                    </div>
                    <div class="form-group" v-if="!individualType">
                        <label for="">Vat Scheme</label> 
                        <select name="vat_scheme_id" id="" class="form-control">
                            <option :value="vatScheme.id" v-for="(vatScheme, key) in vatSchemes" :key="key">{{vatScheme.name}}</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import moment from 'moment';
import { eventBus } from "../app";
export default {
    props: ['clientData', 'companyTypes', 'vatSchemes', 'vatSubmitTypes'],
    data: function(){
        return{
            dateOfCreation: "",
            selectedCompanyTypeId: "",
            individualType: false,
            showAll: true,
            companyNumber: this.clientData.company_number,
            bookStartDate: "",
            yearEndDate: "",
            lastBookkeepingDone: ""
        }
    },
    beforeMount(){
        this.dateOfCreation = moment(this.clientData.date_of_creation).format('DD-MM-YYYY');
        this.bookStartDate = moment(this.clientData.accounts.next_accounts.period_start_on).format('DD-MM-YYYY');
        this.yearEndDate = moment(this.clientData.accounts.next_accounts.period_end_on).format('DD-MM-YYYY');
        this.lastBookkeepingDone = moment(this.clientData.accounts.next_made_up_to).format('DD-MM-YYYY');
        var self = this;
        eventBus.$on('type', function(val){
            self.companyTypeChanged(val);
        });
    },
    methods: {
        companyTypeChanged: function(val){
            if(val == 6){
                this.individualType = true;
            }else if(val != 6){
                this.individualType = false;
            }
            if(val == 1 || val == 5){
                this.showAll = true;
            }else{
                this.showAll = false;
            }
        }
    }
}
</script>

<style>

</style>
