<template>
    <nav class="breadcrumb">
        <a href="/" class="crumb ">Главная</a>
        <span class="crumb active">›</span>
        <a :href="'/' + parentSlug" class="crumb ">{{ parentTitle }}</a>
        <span class="crumb ">›</span>
        <span class="crumb active">{{ currentTitle }}</span>
    </nav>

</template>
<script>
export default {
    name: 'BreadCrumb',
    props: {
        parentSlug: {
            type: String,
            required: true
        },
        parentTitle: {
            type: String,
            required: true
        },
        currentTitle: {
            type: String,
            required: true
        }
    }
};
</script>

<style scoped>
.breadcrumb {
    display: flex;
    justify-content: center;
    /* центрирование */
    align-items: center;
    gap: 6px;
    /* расстояние между частями */
    margin: 20px 0;
    font-family: "Trebuchet MS", Verdana, Arial, sans-serif;
    font-size: 18px
}

.crumb {
    text-decoration: none;
    color: #3c434a;
}

/* эффект при наведении только для ссылок (не активной) */
.crumb:not(.active):hover {
    color: #0c0a66;
    /* синий — как на старом WP */
    cursor: pointer;
}

.crumb.active {
    font-weight: bold;
}
</style>
