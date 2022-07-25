<template>
    <nav class="navbar navbar-expand-lg navbar-white justify-content-center">
        <div class=" justify-content-center" id="navbarText">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                   <router-link class="nav-link" to="/samples">Шаблоны</router-link>
                </li>
                <li class="nav-item">
                    <router-link class="nav-link" to="/protocols">Протоколы</router-link>
                </li>
            </ul>
        </div>
    </nav>
</template>

<script>
export default {
    name: "Menu"
}
</script>

<style scoped>

</style>
