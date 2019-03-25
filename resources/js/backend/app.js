import '@coreui/coreui'
import Vue from 'vue';
import ElementUI from 'element-ui';
import Vuelidate from 'vuelidate'
import 'element-ui/lib/theme-chalk/index.css';
import { store } from './store/store';
require('@chenfengyuan/datepicker/dist/datepicker.min.css');
import locale from 'element-ui/lib/locale/lang/en'

import helpers from 'helping-monk'; //please check out this npm library for some of my helper functions

window.Vue = Vue;
Vue.use(ElementUI, { locale });
Vue.use(helpers);
Vue.use(Vuelidate);
Vue.prototype.settings = (key) => {
    return _.get(window.stg, key, key);
};

Vue.component('clientDeadline', require('./components/ClientDeadlineComponent.vue'));
Vue.component('business-info', require('./components/BusinessInfoComponent.vue'));
Vue.component('non-api-business-info', require('./components/NonApiBusinessInfoComponent.vue'));
Vue.component('reminder-form', require('./components/ReminderFormComponent.vue'));
Vue.component('env-editor', require('./components/EnvEditor.vue'));
Vue.component('bar-chart-container', require('./components/charts/BarChartContainer.vue'));
Vue.component('filter-component', require('./components/FilterComponent'));

export const eventBus = new Vue();

const app = new Vue({
    validations: {},
    el: '#back-app',
    store,
    beforeMount: function(){
    },
    methods: {
        companyTypeChanged: function(e){
            eventBus.$emit('type', e.target.value);
        }
    }
});


