import '@coreui/coreui'
import Vue from 'vue';

window.Vue = Vue;

const app = new Vue({
    el: '#search-result',
    data: {
        hideCompanyRegNumber: "",
        companyType: "",
        noCompanyNumberDisplay: "",
        noDisplayforIndividual:"",
        companyNumber: companyNumber
    },
    methods: {
        companyTypeChanged: function(e){
            this.companyType = e.target.value;
            if(this.companyType == 2 || this.companyType == 3 || this.companyType == 4 || this.companyType == 7){
                this.noCompanyNumberDisplay = "d-none";
                this.noDisplayforIndividual ="";
                this.companyNumber = "";
            }else if(this.companyType == 1 || this.companyType == 5){
                this.noCompanyNumberDisplay = "";
                this.noDisplayforIndividual ="";
                this.companyNumber = companyNumber;
            }else if(this.companyType == 6){
                this.noDisplayforIndividual ="d-none";
                this.noCompanyNumberDisplay = "d-none";
                this.companyNumber = "";
            }
            
        }
    }
});