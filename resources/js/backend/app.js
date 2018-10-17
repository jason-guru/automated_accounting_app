import '@coreui/coreui'
import Vue from 'vue';

window.Vue = Vue;
Vue.component('business-info', require('./components/BusinessInfoComponent.vue'));
Vue.component('non-api-business-info', require('./components/NonApiBusinessInfoComponent.vue'));
export const eventBus = new Vue();

const app = new Vue({
    el: '#search-result',
    methods: {
        companyTypeChanged: function(e){
            eventBus.$emit('type', e.target.value);
        }
    }
});