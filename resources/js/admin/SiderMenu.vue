<template>
    <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">

        <!--begin::Sidebar Brand-->
        <div class="sidebar-brand">
            <!--begin::Brand Link-->
            <a href="./index.html" class="brand-link">

                <span class="brand-text fw-light">Админ Панель</span></a>

        </div>
        <div class="sidebar-wrapper">
            <nav class="mt-2">
                <ul class="nav sidebar-menu flex-column" role="navigation" id="navigation">
                    <li class="nav-item">

                        <router-link :to="{ name: 'adminMain' }"
                            class="nav-link {{ request() -> routeIs('admin') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-box-seam-fill"></i>
                            <p>Главная</p>
                        </router-link>

                    </li>

                    <!-- Меню Статьи -->
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center" data-bs-toggle="collapse" href="#postMenu"
                            role="button" aria-expanded="{{ request()->routeIs('post.*') ? 'true' : 'false' }}"
                            aria-controls="postMenu">
                            <i class="nav-icon bi bi-speedometer"></i>
                            <p class="mb-0 flex-grow-1">Посты</p>
                            <i class="bi bi-chevron-down ms-auto"></i>
                        </a>
                        <div class="collapse ps-3 {{ request()->routeIs('post.*') ? 'show' : '' }}" id="postMenu"
                            data-bs-parent="#navigation">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <router-link :to="{ name: 'travelPosts' }" class="nav-link">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>Мои путешествия</p>
                                    </router-link>

                                    <router-link :to="{ name: 'PostAdminIndex', params: { category: 'advice' } }"
                                        class="nav-link">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>Советы и полезности</p>
                                    </router-link>
                                    <router-link :to="{ name: 'PostAdminIndex', params: { category: 'guide' } }"
                                        class="nav-link">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>Путеводители</p>
                                    </router-link>
                                    <router-link :to="{ name: 'PostAdminIndex', params: { category: 'mybook' } }"
                                        class="nav-link">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>Я и мои книги</p>
                                    </router-link>
                                    <router-link :to="{ name: 'travelTables' }" class="nav-link">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>Посты-таблицы </p>
                                    </router-link>
                                </li>

                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center" data-bs-toggle="collapse" href="#postCardMenu"
                            role="button" aria-expanded="{{ request()->routeIs('post.*') ? 'true' : 'false' }}"
                            aria-controls="postCardMenu">
                            <i class="nav-icon bi bi-speedometer"></i>
                            <p class="mb-0 flex-grow-1">Окна в категориях</p>
                            <i class="bi bi-chevron-down ms-auto"></i>
                        </a>
                        <div class="collapse ps-3 {{ request()->routeIs('post.*') ? 'show' : '' }}" id="postCardMenu"
                            data-bs-parent="#navigation">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <router-link :to="{ name: 'postCardMenu', params: { category_name: 'travel' } }"
                                        class="nav-link">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>Мои путешествия</p>
                                    </router-link>

                                    <router-link :to="{ name: 'postCardMenu', params: { category_name: 'advice' } }"
                                        class="nav-link">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>Советы и полезности</p>
                                    </router-link>
                                    <router-link :to="{ name: 'postCardMenu', params: { category_name: 'guide' } }"
                                        class="nav-link">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>Путеводители</p>
                                    </router-link>
                                    <router-link :to="{ name: 'postCardMenu', params: { category_name: 'mybook' } }"
                                        class="nav-link">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>Я и мои книги</p>
                                    </router-link>
                                </li>

                            </ul>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center" data-bs-toggle="collapse" href="#adding"
                            role="button" aria-expanded="{{ request()->routeIs('post.*') ? 'true' : 'false' }}"
                            aria-controls="adding">
                            <i class="nav-icon bi bi-speedometer"></i>
                            <p class="mb-0 flex-grow-1">Добавить</p>
                            <i class="bi bi-chevron-down ms-auto"></i>
                        </a>
                        <div class="collapse ps-3 {{ request()->routeIs('post.*') ? 'show' : '' }}" id="adding"
                            data-bs-parent="#navigation">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <router-link :to="{ name: 'AddingPostSingle' }" class="nav-link">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>Пост-single</p>
                                    </router-link>
                                </li>
                                <li class="nav-item">
                                    <router-link :to="{ name: 'AddingPostTable' }" class="nav-link">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>Пост-таблица</p>
                                    </router-link>
                                </li>
                                <li class="nav-item">
                                    <router-link :to="{ name: 'AddingPostForTable' }" class="nav-link">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>Пост-для-таблицы</p>
                                    </router-link>
                                </li>

                                <li class="nav-item">
                                    <router-link :to="{ name: 'AddingImage' }" class="nav-link">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>Фото</p>
                                    </router-link>
                                </li>

                            </ul>
                        </div>
                    </li>

                    <!-- Меню Фото -->
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center" data-bs-toggle="collapse" href="#postImageMenu"
                            role="button" aria-expanded="{{ request()->routeIs('postImage.*') ? 'true' : 'false' }}"
                            aria-controls="postImageMenu">
                            <i class="nav-icon bi bi-speedometer"></i>
                            <p class="mb-0 flex-grow-1">Фото</p>
                            <i class="bi bi-chevron-down ms-auto"></i>
                        </a>
                        <div class="collapse ps-3 {{ request()->routeIs('postImage.*') ? 'show' : '' }}"
                            id="postImageMenu" data-bs-parent="#navigation">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <router-link :to="{ name: 'CategoryImages' }" class="nav-link">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>Категории</p>
                                    </router-link>
                                </li>
                                <li class="nav-item">
                                    <router-link :to="{ name: 'CardImages' }" class="nav-link">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>Заставки меню</p>
                                    </router-link>
                                </li>
                                <li class="nav-item">
                                    <router-link :to="{ name: 'ImageSearch' }" class="nav-link">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>Поиск изображения</p>
                                    </router-link>
                                </li>
                            </ul>

                        </div>
                    </li>

                </ul>
            </nav>
        </div>
        <!--end::Sidebar Wrapper-->
    </aside>
</template>
<script>
import { defineComponent } from 'vue';
export default defineComponent({
    name: 'SiderMenu',
})
</script>