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

                <div class="col-lg-3 col-md-6 col-12">
                    <div class="small-box text-bg-success">
                        <div class="inner">
                            <h3>{{ travel_table_count }}</h3>
                            <p>Кол-во таблиц </p>
                            <p>"Мои путешествия"</p>
                        </div>

                    </div>
                </div>
            </div>

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
            travel_table_count: 0,
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
                this.travel_table_count = responce.data.travel_tables;
            } catch (error) {
                console.error('Error fetching post count:', error);
            }
        },

    }
}
</script>