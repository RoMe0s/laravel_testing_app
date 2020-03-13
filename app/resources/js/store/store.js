import Vue from 'vue';

import Vuex from 'vuex';
Vue.use(Vuex);

import {Reference} from '@store/reference';
import {TempInsurance} from '@store/temp_insurance';
import {Insurance} from '@store/insurance';

export const Store = new Vuex.Store({
    modules: {
        reference: Reference,
        tempInsurance: TempInsurance,
        insurance: Insurance,
    }
});
