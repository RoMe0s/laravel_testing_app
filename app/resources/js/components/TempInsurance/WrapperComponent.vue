<template>
    <div>
        <b-card-body>
            <b-alert variant="danger" :show="carHasTooBigMileage">We can't insure your car.</b-alert>
            <first-page-component :saving-allowed="isLoaded" v-if="false === showSecondPage"></first-page-component>
            <second-page-component :saving-allowed="isLoaded" v-if="showSecondPage"></second-page-component>
        </b-card-body>
        <b-card-footer>
            <b-row>
                <b-col>
                    <b-button variant="primary" @click.prevent="showSecondPage = false" v-if="showSecondPage">
                        Previous
                    </b-button>
                </b-col>
                <b-col class="text-right">
                    <b-button variant="primary" @click.prevent="showSecondPage = true" v-if="false === showSecondPage">
                        Next
                    </b-button>
                    <b-button variant="success" v-if="showSecondPage" @click.prevent="quote()" :disabled="carHasTooBigMileage">
                        Get quote
                    </b-button>
                </b-col>
            </b-row>
        </b-card-footer>
    </div>
</template>
<script lang="js">
    import FirstPageComponent from '@components/TempInsurance/FirstPageComponent';
    import SecondPageComponent from '@components/TempInsurance/SecondPageComponent';
    import {mapGetters, mapActions} from 'vuex';
    import {Notification} from '@utils/notification';

    export default {
        components: {
            FirstPageComponent,
            SecondPageComponent,
        },
        data() {
            return {
                showSecondPage: false,
                isLoaded: false,
            };
        },
        computed: {
            ...mapGetters({
                mileage: 'tempInsurance/getMileage',
            }),
            carHasTooBigMileage: function () {
                return this.mileage && this.mileage > 100000;
            },
        },
        methods: {
            ...mapActions({
                fetchReferences: 'reference/fetchReferences',
                fetchTempInsurance: 'tempInsurance/fetchTempInsurance',
                quoteInsurance: 'insurance/quoteInsurance',
            }),
            async quote() {
                this.isLoaded = true;
                try {
                    await this.quoteInsurance();
                    this.showSecondPage = false;
                    Notification.showSuccessMessage('Successfully quoted!');
                } catch (e) {
                } finally {
                    this.$nextTick(() => this.isLoaded = false);
                }
            }
        },
        async created() {
            await this.fetchReferences();
            await this.fetchTempInsurance();
            this.isLoaded = true;
        }
    }
</script>
