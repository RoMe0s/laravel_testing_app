export const ReferenceGetters = {
    getReferences: state => state.references,
    getReferenceByKey: state => referenceKey => {
        const reference = state.references.find(reference => reference.key === referenceKey);

        return reference ? reference : null;
    },
};
