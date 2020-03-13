<template>
    <div>
        <b-form-group v-for="reference in referencesList" :key="reference.key" :label="reference.name">
            <b-select :value="referenceValue(reference.key)" @input="updateReferenceField(reference.key, $event)"
                      :options="referenceValuesFor(reference.key)"></b-select>
        </b-form-group>
        <b-form-group v-if="picture" label="Uploaded picture">
            <b-img :src="picture" fluid-grow></b-img>
        </b-form-group>
        <b-form-group label="Upload new picture">
            <b-form-file @input="updatePicture" accept="image/*"></b-form-file>
        </b-form-group>
    </div>
</template>
<script lang="js">
    import {mapGetters, mapMutations, mapActions} from 'vuex';
    import {referenceMapper} from '@utils/referenceMapper';

    export default {
        props: {
            savingAllowed: {
                type: Boolean,
                required: true,
            }
        },
        computed: {
            ...mapGetters({
                references: 'reference/getReferences',
                referenceByKey: 'reference/getReferenceByKey',

                picture: 'tempInsurance/getPicture',
                referenceValue: 'tempInsurance/getReferenceValue',
                referenceValues: 'tempInsurance/getReferenceValues',
            }),
            referenceValuesFor: function () {
                return function (referenceKey) {
                    const reference = this.referenceByKey(referenceKey);

                    return reference ? referenceMapper.mapReferenceForSelect(reference) : [];
                }
            },
            referencesList: function () {
                return this.references.filter(reference => {
                    return false === ('make' === reference.key || /.*-model$/.test(reference.key));
                });
            },
        },
        methods: {
            ...mapActions({
                filterReferences: 'reference/filterReferences',
                saveTempInsurance: 'tempInsurance/saveTempInsurance',
                updateTempInsurancePicture: 'tempInsurance/updateTempInsurancePicture',
            }),
            ...mapMutations({
                setTempInsuranceReferenceField: 'tempInsurance/setTempInsuranceReferenceField',
            }),
            async updateReferenceField(referenceKey, value) {
                this.setTempInsuranceReferenceField({referenceKey, value});
                if (this.savingAllowed) {
                    await this.saveTempInsurance();
                }
                await this.filterReferences(this.referenceValues);
            },
            async updatePicture(picture) {
                await this.updateTempInsurancePicture(picture);
            },
        }
    }
</script>
