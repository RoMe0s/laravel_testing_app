import {Http} from '@utils/http';
import {Notification} from '@utils/notification';

export const TempInsuranceActions = {
    fetchTempInsurance: async ({commit}) => {
        try {
            const {data} = await Http.get('/temp-insurances');

            commit('setTempInsurance', {caseValue: data.case, ...data});
        } catch (e) {
            commit('resetTempInsurance');
        }
    },
    saveTempInsurance: async ({commit, getters}) => {
        try {
            const {data} = await Http.post('/temp-insurances', getters.getTempInsuranceForSubmit);

            commit('setTempInsurance', {caseValue: data.case, ...data});
        } catch (e) {
            Notification.showBadResponseMessages(e.response.data);
        }
    },
    updateTempInsurancePicture: async ({commit}, picture) => {
        const formData = new FormData();
        formData.append('picture', picture);

        try {
            const {data} = await Http.post('/temp-insurances/update-picture', formData, {
                headers: {
                    'content-type': 'multipart/form-data',
                }
            });

            commit('setTempInsurance', {caseValue: data.case, ...data});
        } catch (e) {
            Notification.showBadResponseMessages(e.response.data);
        }
    }
};
