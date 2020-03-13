import {Http} from '@utils/http';
import {Notification} from '@utils/notification';

export const InsuranceActions = {
    quoteInsurance: async ({commit, rootGetters}) => {
        try {
            await Http.post('/insurances', rootGetters['tempInsurance/getTempInsuranceForSubmit']);

            commit('tempInsurance/resetTempInsurance', null, {root: true});
        } catch (e) {
            Notification.showBadResponseMessages(e.response.data);

            throw e;
        }
    }
};
