import '@coreui/coreui'
import Vue from 'vue';
import _ from '@chenfengyuan/datepicker';
require('@chenfengyuan/datepicker/dist/datepicker.min.css');

window.Vue = Vue;

Vue.component('business-info', require('./components/BusinessInfoComponent.vue'));
Vue.component('non-api-business-info', require('./components/NonApiBusinessInfoComponent.vue'));
Vue.component('reminder-form', require('./components/ReminderFormComponent.vue'));

export const eventBus = new Vue();

const app = new Vue({
    el: '#back-app',
    beforeMount: function(){
    },
    methods: {
        companyTypeChanged: function(e){
            eventBus.$emit('type', e.target.value);
        }
    }
});


