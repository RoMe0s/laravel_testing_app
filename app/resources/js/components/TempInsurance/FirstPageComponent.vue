<template>
    <div>
        <b-form-group label="Case">
            <b-input type="text" :value="caseValue" @input="updateField('case', $event)"/>
        </b-form-group>
        <b-form-group label="Make">
            <b-select :value="referenceValue('make')" @input="updateReferenceField('make', $event)"
                      :options="referenceValuesFor('make')"></b-select>
        </b-form-group>
        <b-form-group label="Model">
            <b-select :value="referenceValue(referenceModelKey)"
                      @input="updateReferenceField(referenceModelKey, $event)"
                      :options="referenceValuesFor(referenceModelKey)"></b-select>
        </b-form-group>
        <b-form-group label="Mileage">
            <b-input type="number" :value="mileage" @input="updateField('mileage', $event)"/>
        </b-form-group>
        <b-form-group label="Bought at">
            <date-picker :value="boughtAt" :config="datePickerConfig"
                         @input="updateField('boughtAt', $event)"></date-picker>
        </b-form-group>
    </div>
</template>
<script lang="js">
    import {mapGetters, mapActions, mapMutations} from 'vuex';
    import {referenceMapper} from '@utils/referenceMapper';

    export default {
        props: {
            savingAllowed: {
                type: Boolean,
                required: true,
            }
        },
        data() {
            return {
                datePickerConfig: {
                    maxDate: new Date(),
                    format: 'YYYY-MM-DD',
                },
            };
        },
        computed: {
            ...mapGetters({
                references: 'reference/getReferences',
                referenceByKey: 'reference/getReferenceByKey',

                caseValue: 'tempInsurance/getCase',
                mileage: 'tempInsurance/getMileage',
                boughtAt: 'tempInsurance/getBoughtAt',
                referenceValue: 'tempInsurance/getReferenceValue',
                referenceValues: 'tempInsurance/getReferenceValues',
            }),
            referenceValuesFor: function () {
                return function (referenceKey) {
                    const reference = this.referenceByKey(referenceKey);

                    return reference ? referenceMapper.mapReferenceForSelect(reference) : [];
                }
            },
            referenceModelKey: function () {
                const reference = this.references.find(reference => /.*-model$/.test(reference.key));

                return reference ? reference.key : null;
            },
        },
        methods: {
            ...mapActions({
                filterReferences: 'reference/filterReferences',
                saveTempInsurance: 'tempInsurance/saveTempInsurance',
            }),
            ...mapMutations({
                setTempInsuranceField: 'tempInsurance/setTempInsuranceField',
                setTempInsuranceReferenceField: 'tempInsurance/setTempInsuranceReferenceField',
            }),
            async updateField(field, value) {
                this.setTempInsuranceField({field, value});

                if (this.savingAllowed) {
                    await this.saveTempInsurance();
                }
            },
            async updateReferenceField(referenceKey, value) {
                this.setTempInsuranceReferenceField({referenceKey, value});
                if (this.savingAllowed) {
                    await this.saveTempInsurance();
                }
                await this.filterReferences(this.referenceValues);
            }
        }
    }
</script>
