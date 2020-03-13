import {TempInsuranceState} from "@store/temp_insurance/state";
import {TempInsuranceGetters} from "@store/temp_insurance/getters";
import {TempInsuranceMutations} from "@store/temp_insurance/mutations";
import {TempInsuranceActions} from "@store/temp_insurance/actions";

export const TempInsurance = {
    namespaced: true,
    state: TempInsuranceState,
    getters: TempInsuranceGetters,
    mutations: TempInsuranceMutations,
    actions: TempInsuranceActions,
};
