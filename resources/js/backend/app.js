import '@coreui/coreui'
import Vue from 'vue';
require('@chenfengyuan/datepicker/dist/datepicker.min.css');

window.Vue = Vue;

// settings
Vue.prototype.settings = (key) => {
    return _.get(window.stg, key, key);
};

Vue.component('business-info', require('./components/BusinessInfoComponent.vue'));
Vue.component('non-api-business-info', require('./components/NonApiBusinessInfoComponent.vue'));
Vue.component('reminder-form', require('./components/ReminderFormComponent.vue'));
Vue.component('env-editor', require('./components/EnvEditor.vue'));
Vue.component('bar-chart-container', require('./components/charts/BarChartContainer.vue'));

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


