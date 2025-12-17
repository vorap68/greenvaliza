<template>
    <div class="card" style="width:auto;">
        <div class="card-body">
            <div class="card-text" v-html="formattedHtml"></div>
        </div>
    </div>
</template>

<script>
import { defineComponent } from 'vue';
import axios from 'axios';
import beautify from 'js-beautify';

export default defineComponent({
    name: 'AdviceShow',

    data() {
        return {
            advicepost: {},
            formattedHtml: '',
        }
    },

    mounted() {
        this.GetAdvicePost();
    },

    methods: {
        async GetAdvicePost() {
            try {
                const response = await axios.get('/api/admin/mybook/' + this.$route.query.slug);
                if (!response.data) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                } this.advicepost = response.data.data;
                this.formattedHtml = beautify.html(this.advicepost.content, {
                    indent_size: 4,
                    wrap_line_length: 80,
                });
                console.log(this.advicepost.content);
            } catch (error) {
                console.error('Error fetching travel post:', error);
            }
        }
    }
});
</script>
<style>
p.ab {
    text-align: justify;
    font-family: serif;
    font-size: medium;
    font-weight: 400;
    margin-right: 4%;
    margin-left: 4%;
    line-height: 1.2;
    font-size: 20px;
    color: #333333;
}

p.ab2 {
    text-align: right;
    font-weight: bold;
    font-style: italic;
    margin-right: 3%;
    margin-left: 3%;
}

p.name {
    font-size: x-large;
    font-family: cursive;
    font-weight: 700;
    text-align: center;
    color: #BC8F8F
}

p.name2 {
    font-size: large;
    font-family: cursive;
    font-weight: 600;
    text-align: center;
    color: #DAA520
}
</style>