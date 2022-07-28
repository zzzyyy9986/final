<template>
  <form @submit.prevent="addPattern" >
    <div class="form-group row mb-2">
      <div class="col-md-8">
        <multiselect
            v-model="value"
            :options="options"
            :track-by="'id'"
            :allow-empty="true"
            :label="'text'"
            :searchable="true"
            :show-labels="false"
            placeholder="Выберите родительский шаблон">
          <template slot="option" slot-scope="props">
            <div class="d-flex justify-content-between">
              <div class="option__desc">
                <span class="option__small">{{ props.option.text }}</span>
              </div>
            </div>
          </template>
          <template slot="noOptions">
            <div class="d-flex justify-content-between">
              <div class="option__desc">
                <span class="option__small">Добавьте корневой элемент(введите его в следующем поле)</span>
              </div>
            </div>
          </template>
          <template slot="noResult">
            <div class="d-flex justify-content-between">
              <div class="option__desc">
                <span class="option__small">Ничего не найдено. Убедитель в правильности данных</span>
              </div>
            </div>
          </template>
        </multiselect>
      </div>
      <div class="col-md-4 ">
        <button type="button" :disabled="!value?.id" class="btn btn-danger" @click="deleteSample(value.id)">
          Удалить
        </button>
        <button type="button" :disabled="!value?.id" class="btn btn-warning" @click="selectSample">
          Редактировать
        </button>
      </div>
    </div>
    <div class="form-group mb-2">
                <textarea v-model="text" type="text" class="form-control" id="sample"
                          placeholder="Введите шаблон" required></textarea>
    </div>
    <div class="text-end">
      <button type="submit" class="btn btn-primary ">Добавить</button>
    </div>


    <modal-q>
      <template v-slot:header>Редактирование шаблона</template>
      <template v-slot:body>
        <form @submit.prevent="updateSample">
          <textarea class="form-control" v-model="updateForm.text"></textarea>
          <div class="text-end mt-2">
            <button type="submit" class="btn btn-warning">Сохранить</button>
          </div>
        </form>
      </template>
    </modal-q>


  </form>
</template>

<script>
import Multiselect from 'vue-multiselect'
import ModalQ from "../Modal";

export default {
  name: "index.vue",
  components: {ModalQ, Multiselect},
  computed: {
    samples: function () {
      return this.$store.getters.getSamples
    },
    options: function () {
      let ar = []
      if(!this.samples?.length) return []
      this.samples.forEach(el => {
        this.next(el, ar)
      })
      return ar
    },
    isSamplesLoaded: function () {
      return this.$store.getters.isSamplesLoaded
    },
    currentModal: function () {
      return this.$store.getters.getCurrentModal
    }
  },
  data: () => {
    return {
      text: "",
      parentId: '',
      value: "",
      showModal: false,
      updateForm: {
        text: "",
        id: ""
      },
      modal: ""
    }
  },
  methods: {
    addPattern() {
      axios.post("/addSample", {
        text: this.text,
        parentId: this.value.id
      }).then((resp) => {
        this.$store.dispatch("loadSamples")
        this.text = ""
        this.$store.commit("setSuccessMsg", "Успешно добавили шаблон")
      })
          .catch((error) => {
            if (error.response) {
              let msg = Object.keys(error.response.data.errors).map((key, index, ar) => ar[key]).join("")
              this.$store.commit("setErrorMsg", Object.values(error.response.data.errors).map(el => el[0]).join(";"))
            }
          })
    },
    next(el, ar) {
      if (el.children.length) {
        ar.push({
          id: el["id"],
          text: el["text"]
        })
        el.children.forEach(sub => {
          this.next(sub, ar)
        })
      } else {
        ar.push({
          id: el["id"],
          text: el["text"]
        })
      }
    },
    deleteSample(id) {
      if (!confirm("Вы уверены? Буду удалены и все дочерние шаблоны")) return
      axios.get("/deleteSample/" + id)
          .then(resp => {
            this.$store.dispatch("loadSamples")
            this.$store.commit("setSuccessMsg", "Успешно удалили шаблон")
            this.value = ""
          })
    },
    selectSample() {
      this.updateForm = Object.assign({}, this.value)
      this.currentModal.show();
    },
    updateSample() {
      axios.post("/updateSample", this.updateForm)
          .then((res) => {
            this.closeModal()
            this.value.text = this.updateForm.text
            this.$store.dispatch("loadSamples")
            this.$store.commit("setSuccessMsg", "Успешно обновили шаблон")

          })
    },
    closeModal() {
      this.currentModal.hide();
      setTimeout(() => {
        console.log(this.currentModal)
      }, 1000)
    }

  },
}
</script>

<style scoped>

</style>
