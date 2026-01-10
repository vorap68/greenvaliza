<template>
    <div class="app-content-header">
        <!--begin::Container-->
        <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Главная</h3>
                </div>

            </div>
            <!--end::Row-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::App Content Header-->
    <!--begin::App Content-->
    <div class="app-content">
        <!--begin::Container-->
        <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
                <!--begin::Col-->
                <div class="col-lg-3 col-md-6 col-12">
                    <!--begin::Small Box Widget 1-->
                    <div class="small-box text-bg-primary">
                        <div class="inner">
                            <h3>{{ travel_post_count }}</h3>
                            <p>Кол-во постов </p>
                            <p>"Мои путешествия"</p>
                        </div>


                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-12">
                    <div class="small-box text-bg-secondary ">
                        <div class="inner">
                            <h3>{{ guide_post_count }}</h3>
                            <p>Кол-во постов </p>
                            <p>"Путеводители"</p>
                        </div>


                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-12">
                    <div class="small-box text-bg-info">
                        <div class="inner">
                            <h3>{{ advice_post_count }}</h3>
                            <p>Кол-во постов</p>
                            <p> "Советы и полезности"</p>
                        </div>

                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-12">
                    <div class="small-box text-bg-success">
                        <div class="inner">
                            <h3>{{ mybook_count }}</h3>
                            <p>Кол-во постов </p>
                            <p>"Я и мои книги"</p>
                        </div>

                    </div>
                </div>
            </div>

            <!-- <div class="col-lg-3 col-6">
                <div class="small-box text-bg-warning">
                    <div class="inner">
                        <h3>44</h3>
                        <p>User Registrations</p>
                    </div>
                    <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path
                            d="M6.25 6.375a4.125 4.125 0 118.25 0 4.125 4.125 0 01-8.25 0zM3.25 19.125a7.125 7.125 0 0114.25 0v.003l-.001.119a.75.75 0 01-.363.63 13.067 13.067 0 01-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 01-.364-.63l-.001-.122zM19.75 7.5a.75.75 0 00-1.5 0v2.25H16a.75.75 0 000 1.5h2.25v2.25a.75.75 0 001.5 0v-2.25H22a.75.75 0 000-1.5h-2.25V7.5z">
                        </path>
                    </svg>
                </div>
            </div> -->


        </div>
    </div>

</template>
<script>
import { defineComponent } from 'vue';
import axios from 'axios';

export default {
    name: 'Main',

    data() {
        return {
            travel_post_count: 0,
            guide_post_count: 0,
            advice_post_count: 0,
            mybook_count: 0,
        }
    },

    mounted() {
        console.log('Main component mounted.');
        this.CountPosts();

    },

    methods: {
        async CountPosts() {
            try {
                const responce = await axios.get('/api/admin/header/count');
                if (!responce.data) {
                    throw new Error(`HTTP error! status: ${responce.status}`);
                }
                console.log('Post count responce:', responce.data);
                this.travel_post_count = responce.data.posts;
                this.guide_post_count = responce.data.guides;
                this.advice_post_count = responce.data.advices;
                this.mybook_count = responce.data.mybooks;
            } catch (error) {
                console.error('Error fetching post count:', error);
            }
        },

    }
}
</script>