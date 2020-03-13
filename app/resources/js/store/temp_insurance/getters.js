export const TempInsuranceGetters = {
    getCase: state => state.case,
    getMake: state => state.make,
    getModel: state => state.model,
    getMileage: state => state.mileage,
    getBoughtAt: state => state.boughtAt,
    getPicture: state => state.picture,
    getReferenceValues: state => state.referenceValues,
    getReferenceValue: state => referenceKey => state.referenceValues[referenceKey],
    getTempInsuranceForSubmit: state => {
        return {
            case: state.case,
            mileage: state.mileage,
            bought_at: state.boughtAt,
            picture: state.picture,
            reference_values: state.referenceValues,
        };
    }
};
