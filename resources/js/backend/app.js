import '@coreui/coreui'
import Vue from 'vue';
import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';
import { store } from './store/store';
require('@chenfengyuan/datepicker/dist/datepicker.min.css');
import locale from 'element-ui/lib/locale/lang/en'
import Vuelidate from 'vuelidate'

window.Vue = Vue;

Vue.prototype.settings = (key) => {
    return _.get(window.stg, key, key);
};

Vue.use(Vuelidate);
Vue.use(ElementUI, { locale });


Vue.component('business-info', require('./components/BusinessInfoComponent.vue'));
Vue.component('non-api-business-info', require('./components/NonApiBusinessInfoComponent.vue'));
Vue.component('reminder-form', require('./components/ReminderFormComponent.vue'));
Vue.component('env-editor', require('./components/EnvEditor.vue'));
Vue.component('bar-chart-container', require('./components/charts/BarChartContainer.vue'));

export const eventBus = new Vue();

const app = new Vue({
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


