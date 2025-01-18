<template>
    <div class="blog">
        <div class="w-full mt-3 mb-3">
            <form class="max-w-sm mx-auto">
                <label for="categories" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    Select your favourite categories
                </label>
                <select id="categories" v-model="selectedCategory" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
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
                    <button type="submit" class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-4 py-2">Search</button>
                </div>
            </form>
        </div>

        <div class="posts">
            <div
                v-for="post in filteredPosts"
                :key="post.id"
                class=""
            >
                <div class="max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                    <a href="#">
                        <img class="rounded-t-lg" src="https://flowbite.com/docs/images/blog/image-1.jpg" alt="" />
                    </a>
                    <div class="p-5">
                        <a href="#">
                            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Noteworthy technology acquisitions 2021</h5>
                        </a>
                        <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">Here are the biggest enterprise technology acquisitions of 2021 so far, in reverse chronological order.</p>
                        <a href="#" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 dark:bg-blue-600 dark:hover:bg-blue-700">
                            Read more
                            <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                            </svg>
                        </a>
                    </div>
                </div>

            </div>
        </div>

        <div class="pagination">
            <button
                :disabled="currentPage === 1"
                @click="currentPage--"
            >
                Prev
            </button>
            <span>{{ currentPage }}</span>
            <button
                :disabled="currentPage === totalPages"
                @click="currentPage++"
            >
                Next
            </button>
        </div>
    </div>
</template>

<script>
import { ref, onMounted, computed } from 'vue';
import axios from 'axios';

export default {
    setup() {
        // Reactive references
        const posts = ref([]);
        const categories = ref([]);
        const searchQuery = ref('');
        const selectedCategory = ref('');
        const currentPage = ref(1);
        const postsPerPage = 3;

        // Fetch data on mount
        onMounted(async () => {
            try {
                const [postsResponse, categoriesResponse] = await Promise.all([
                    axios.get('https://your-api-url.com/posts'),
                    axios.get('https://your-api-url.com/categories'),
                ]);
                posts.value = postsResponse.data;
                categories.value = categoriesResponse.data;
            } catch (error) {
                console.error('Error fetching data:', error);
            }
        });

        // Computed properties for filtered posts and total pages
        const filteredPosts = computed(() => {
            let filtered = posts.value;

            // Search functionality
            if (searchQuery.value) {
                filtered = filtered.filter(post =>
                    post.title.toLowerCase().includes(searchQuery.value.toLowerCase())
                );
            }

            // Filter by category
            if (selectedCategory.value) {
                filtered = filtered.filter(post => post.category.name === selectedCategory.value);
            }

            const start = (currentPage.value - 1) * postsPerPage;
            const end = currentPage.value * postsPerPage;
            return filtered.slice(start, end);
        });

        const totalPages = computed(() => {
            const filtered = filteredPosts.value;
            return Math.ceil(filtered.length / postsPerPage);
        });

        return {
            posts,
            categories,
            searchQuery,
            selectedCategory,
            currentPage,
            filteredPosts,
            totalPages,
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
