<template>
    <div class="card text-center  bg-primary">
        <div class="card-body">
            <h5 class="card-title" :class=" alertColor ">{{ title }}</h5>
            <p class="card-text" :class=" alertColor ">{{ text }}</p>
        </div>
    </div>
</template>

<script>
export default {
    name: "Login",
    props: {
        title: {
            type: String,
            default: ''
        },
        text: {
            type: String,
            default: ''
        },
        alertColor: {
            type: String,
            default: 'text-white'
        }
    }
}
</script>
