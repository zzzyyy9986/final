<template>
    <div class="row" v-if="isSamplesLoaded">
        <form class="col-md-8" @submit.prevent="save">
            <div class="form-group mb-2">
                <input type="text" class="form-control" placeholder="Введите описание"
                       @focus="setSelectedFormItem('description')"
                       v-model="form.description"
                       required
                >
            </div>
            <div class="form-group mb-2">
                <input type="text" class="form-control" placeholder="Введите рекомендации"
                       @focus="setSelectedFormItem('recommendation')"
                       v-model="form.recommendation"
                       required>
            </div>
            <div class="form-group mb-2">
                <input type="text" class="form-control" placeholder="Введите заключение"
                       @focus="setSelectedFormItem('conclusion')"
                       v-model="form.conclusion"
                       required>
            </div>
            <div class="text-end">
                <button type="submit" class="btn btn-primary">Добавить</button>
            </div>
        </form>
        <div class="col-md-4" v-if="samples.length">
            <tree-view id="my-tree" :initial-model="samples" :model-defaults="modelDefaults">
                <template v-slot:text="{ model, customClasses }">
                    <span class="mb-2" @dblclick="selectSample(model.text)">{{ model.text }}</span>
                </template>
            </tree-view>
        </div>
    </div>
</template>

<script>
import TreeView from "@grapoza/vue-tree"
import Multiselect from 'vue-multiselect'

export default {
    name: "index",
    components: { TreeView, Multiselect},
    computed: {
        samples: function () {
            return this.$store.getters.getSamples
        },
        isSamplesLoaded: function () {
            return this.$store.getters.isSamplesLoaded
        }
    },
    data: () => {
        return {
            value: '',
            modelDefaults: {
                idProperty: 'id',
                labelProperty: 'text',
                state: {
                    expanded: true
                }
            },
            form: {
                description: "",
                recommendation: "",
                conclusion: ""
            },
            selectedItem: ""
        }
    },
    methods: {
        selectSample(text) {
            if (this.selectedItem === ''){
                this.$store.commit("setInfoMsg","Выберите поле")
                return

            }
            this.form[this.selectedItem] = text;
        },
        getChildren(el) {
            return el?.children
        },
        setSelectedFormItem(item) {
            this.selectedItem = item
        },
        save() {
           axios.post("/addProtocol",this.form)
            .then(msg => {
                this.$store.commit("setSuccessMsg","Успешно добавили протокол")
                Object.keys(this.form).forEach(key => {
                    this.form[key] = ""
                })

            })
        }
    },
    mounted() {
        this.selectedItem = ''
    }
}
</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
<style scoped>

</style>
