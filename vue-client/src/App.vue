<script setup>
import { ref, computed } from 'vue'
import PageNotFound from './components/NotFound.vue'
import Home from './components/Home.vue'
import PropertySearch from './components/property/PropertySearch.vue'
import HeaderNavigation from './components/layout/HeaderNavigation.vue'
import "bootstrap/dist/css/bootstrap.min.css"


const routes = {
    '/': Home,
    '/home': Home,
    '/property-search': PropertySearch,
}

const currentPath = ref(window.location.hash)

window.addEventListener('hashchange', () => {
    currentPath.value = window.location.hash
})

const currentView = computed(() => {
    return routes[currentPath.value.slice(1) || '/'] || PageNotFound
})
</script>

<template>
    <HeaderNavigation/>
    <component :is="currentView" />
</template>

