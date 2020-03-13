import {Http} from '@utils/http';

export const ReferenceActions = {
    fetchReferences: async ({commit}) => {
        try {
            const {data: {data}} = await Http.get('/references');

            commit('setReferences', data);
        } catch (e) {
            commit('setReferences', []);
        }
    },
    filterReferences: async ({commit}, usedReferenceValues) => {
        try {
            const {data: {data}} = await Http.post('/references/filter', {
                reference_values: usedReferenceValues,
            });

            commit('setReferences', data);
        } catch (e) {
            commit('setReferences', []);
        }
    }
};
