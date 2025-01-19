<template>
    <div class="blog">
        <div class="w-full mt-3 mb-3">
            <form class="max-w-sm mx-auto">
                <label for="categories" class="block mb-2 text-md font-medium text-gray-900 dark:text-white">
                    Select your favourite categories
                </label>
                <select @change="getAllCategories($event)" id="categories" v-model="selectedCategory" class="bg-gray-50 border border-gray-300 text-gray-900 text-md rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option value="">All Categories</option>
                    <option v-for="category in categories" :key="category" :value="category">
                        {{ category }}
                    </option>
                </select>
            </form>

        </div>

        <div class="w-full mt-3 mb-3">
            <form class="w-full mx-auto">
                <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
                <div class="relative">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                        </svg>
                    </div>
                    <input type="search" id="default-search" v-model="searchQuery" class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50" placeholder="Search Mockups, Logos..." required />
                </div>
            </form>
        </div>

        <div class="posts">
            <div
                v-for="post in posts"
                :key="post.id"
                class=""
            >
                <div class="max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                    <a href="#">
                        <img class="rounded-t-lg w-full h-auto" :src=post.image_url alt="Image" />
                    </a>

                    <div class="p-5">
                        <a href="#">
                            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{post.title}}</h5>
                        </a>
                        <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">{{post.description}}</p>
                        <a target="_blank" :href=post.url class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 dark:bg-blue-600 dark:hover:bg-blue-700">
                            Read more
                            <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                            </svg>
                        </a>
                    </div>
                </div>

            </div>
        </div>

        <div v-if="posts.length < 1">
            <div class="p-4 text-[16px] text-white text-center rounded-lg bg-orange-500" role="alert">
                <span class="text-red">Oooops!</span> We currently have no articles to show
            </div>
        </div>

        <nav v-if="posts.length > 0" class="w-full flex justify-center items-center mt-5" aria-label="Page navigation example">
            <ul class="flex items-center justify-center w-full h-10 text-base">
                <li>
                    <a href="#" class="flex items-center justify-center px-4 h-10 ms-0 leading-tight text-gray-500 bg-white border border-e-0 border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                        <span class="sr-only">Previous</span>
                        <svg class="w-3 h-3 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4"/>
                        </svg>
                    </a>
                </li>

                <div v-for="link in postObject.links">
                    <li v-if="link.url">
                        <a href="#" @click="handlePagination(link)" :aria-current="link.active? 'page' : ''" class="flex items-center justify-center px-4 h-10 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                            {{link.label.replace(' &raquo;', '').replace('&laquo; ', '')}}
                        </a>
                    </li>

                    <li v-else>
                        <a href="#" @click="handlePagination(link)" class="flex items-center justify-center px-4 h-10 ms-0 leading-tight text-gray-500 bg-white border border-e-0 border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                            <span class="sr-only">{{link.label.replace(' &raquo;', '').replace('&laquo; ', '')}}</span>
                        </a>
                    </li>
                </div>

                <li>
                    <a href="#" class="flex items-center justify-center px-4 h-10 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                        <span class="sr-only">Next</span>
                        <svg class="w-3 h-3 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                        </svg>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</template>

<script>
import {ref, onMounted, computed, watch} from 'vue';
import axios from 'axios';

export default {
    setup() {
        // Reactive references
        const posts = ref([]);
        const categories = ref([]);
        const searchQuery = ref('');
        const selectedCategory = ref('');
        const currentPage = ref(1);
        const postsPerPage = ref(9);
        const postObject = ref([]);

        // Fetch data on mount
        onMounted(async () => {
            try {
                const [postsResponse, categoriesResponse] = await Promise.all([
                    axios.get('http://localhost:8081/api/v1/articles?perPage=9'),
                    axios.get('http://localhost:8081/api/v1/categories'),
                ]);

                postObject.value = postsResponse.data;
                posts.value = postObject.value.items;
                categories.value = categoriesResponse.data;

                postsPerPage.value = posts.value.per_page;
                currentPage.value = posts.value.current_page;

            } catch (error) {
                console.error('Error fetching data:', error);
            }
        });

        const totalPages = computed(() => {
            const filtered = posts.value;
            return Math.ceil(filtered.length / postsPerPage.value);
        });

        watch(searchQuery, (newQuery) => {
            if (newQuery) {
                getFilteredArticles('', newQuery, '');
            }
        });

        watch(selectedCategory, (newQuery) => {
            if (newQuery) {
                getFilteredArticles('', '', newQuery);
            }
        });

        const getAllCategories = (event) => {
            const category = event.target.value;
            console.log(event.target);
            if (!category) {
                getFilteredArticles('', searchQuery.value, '');
            }
        }

        const handlePagination = (link) => {
            if (link.url) {
                const apiUrl = link.url+'&q='+searchQuery.value+'&category='+selectedCategory.value;
                getFilteredArticles(apiUrl);
            }
        }

        const getFilteredArticles = async (url, query, category) => {
            try {
                const apiUrl = url ? url : 'http://localhost:8081/api/v1/articles?perPage=9&q='+query+'&category='+category;
                console.log(apiUrl);
                const [postsResponse] = await Promise.all([
                    axios.get(apiUrl),
                ]);

                postObject.value = postsResponse.data;
                posts.value = postObject.value.items;
                postsPerPage.value = postsResponse.data.per_page;
                currentPage.value = postsResponse.data.current_page;
            } catch (error) {
                console.error('Error fetching data:', error);
            }
        }

        return {
            posts,
            categories,
            searchQuery,
            selectedCategory,
            currentPage,
            totalPages,
            postObject,
            getAllCategories,
            handlePagination
        };
    },
};
</script>

<style scoped>
.blog {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

.search-filter {
    display: flex;
    justify-content: space-between;
    margin-bottom: 20px;
}

.search-input,
.category-select {
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.posts {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 20px;
}

.post-card {
    border: 1px solid #ddd;
    border-radius: 10px;
    padding: 20px;
    background-color: #fff;
}

.post-card h3 {
    margin: 0 0 10px;
}

.category {
    display: inline-block;
    padding: 5px 10px;
    background-color: #f0f0f0;
    border-radius: 5px;
    margin-top: 10px;
}

.pagination {
    display: flex;
    justify-content: center;
    margin-top: 20px;
}

.pagination button {
    padding: 10px 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    background-color: #fff;
    cursor: pointer;
}

.pagination button:disabled {
    background-color: #f0f0f0;
    cursor: not-allowed;
}

.pagination span {
    padding: 10px 20px;
    align-self: center;
}
</style>
