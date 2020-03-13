export const referenceMapper = {
    mapReferenceForSelect: reference => reference.values.map(referenceValue => {
        return {value: referenceValue.id, text: referenceValue.value};
    }),
};
