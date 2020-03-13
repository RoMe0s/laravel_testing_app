export const TempInsuranceMutations = {
    setTempInsurance: (state, {caseValue, make, model, mileage, bought_at, picture, reference_values}) => {
        state.case = caseValue;
        state.make = make;
        state.model = model;
        state.mileage = mileage;
        state.boughtAt = bought_at;
        state.picture = picture;

        state.referenceValues = {};

        reference_values.forEach(referenceValue => {
            state.referenceValues[referenceValue.reference.key] = referenceValue.id;
        })
    },
    resetTempInsurance: state => {
        state.case = null;
        state.make = null;
        state.model = null;
        state.mileage = null;
        state.boughtAt = null;
        state.picture = null;
        state.referenceValues = {};
    },
    setTempInsuranceField: (state, {field, value}) => state[field] = value,
    setTempInsuranceReferenceField: (state, {referenceKey, value}) => state.referenceValues[referenceKey] = value,
};
