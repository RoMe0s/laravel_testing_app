import {ReferenceState} from "@store/reference/state";
import {ReferenceGetters} from "@store/reference/getters";
import {ReferenceMutations} from "@store/reference/mutations";
import {ReferenceActions} from "@store/reference/actions";

export const Reference = {
    namespaced: true,
    state: ReferenceState,
    getters: ReferenceGetters,
    mutations: ReferenceMutations,
    actions: ReferenceActions,
};
