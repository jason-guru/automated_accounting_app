import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

export const store = new Vuex.Store({
    state: {
        dialogVisible: false,
        dialogClientIds: [],
        activeDeadline: '',
        activeLegend: '',
        filterValue: '',
        dateRangeFilterValue: {},
        dateRangeFilterViaButton: false,
    },
    mutations: {
        toggleDialog: (state, payload) => {
            state.dialogVisible = payload;
        },
        setClientIds: (state, payload) => {
            state.dialogClientIds = payload;
        },
        setActiveDeadline: (state, payload) => {
            state.activeDeadline = payload;
        },
        setActiveLegend: (state, payload) => {
            state.activeLegend = payload;
        },
        setFilter: (state, payload) => {
            state.filterValue = payload;
        },
        setDateRange: (state, payload)=> {
            state.dateRangeFilterValue = payload;
        },
        setDateRangeFilterViaButton: (state, payload) => {
            state.dateRangeFilterViaButton = payload;
        }
        
    }
});