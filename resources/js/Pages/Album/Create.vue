
<template>
  <v-app>
    <v-main>
      <div align="center">
        <v-container>
          <v-alert border="top" colored-border type="info" elevation="2">
            Create Albun
          </v-alert>
          <v-form ref="form" class="mt-6" v-model="valid" lazy-validation>
            <v-text-field
              v-model="form.name"
              :rules="nameRules"
              label="Name"
              required
              filled
            ></v-text-field>
            <v-textarea
              v-model="form.description"
              :rules="descriptionRules"
              auto-grow
              filled
              color="deep-purple"
              label="Description"
              rows="1"
            ></v-textarea>
            <v-select
              :items="categories"
              v-model="form.category"
              name="category"
              :rules="categoryRules"
              item-value="id"
              class="mb-5"
              item-text="name"
              label="Select album category"
            />

            <v-file-input
              v-model="files"
              color="deep-purple accent-4"
              accept="image/*"
              counter
              filled
              @change="onUpload"
              placeholder="Select your files"
              :show-size="1000"
            >
              <template v-slot:selection="{ index, text }">
                <v-chip
                  v-if="index < 2"
                  color="deep-purple accent-4"
                  dark
                  label
                  small
                >
                  {{ text }}
                </v-chip>

                <span
                  v-else-if="index === 2"
                  class="text-overline grey--text text--darken-3 mx-2"
                >
                  +{{ files.length - 2 }} File(s)
                </span>
              </template>
            </v-file-input>
            <v-btn
              :disabled="!valid"
              color="primary"
              class="mr-4 w-full px-16 mt-4 py-8"
              @click.prevent="store"
            >
              Create
            </v-btn>
          </v-form>
        </v-container>
      </div>
    </v-main>
  </v-app>
</template>
<script>
export default {
  data() {
    return {
      valid: true,
      files: [],
      form: this.$inertia.form({
        name: "",
        description: "",
        image: null,
        category: "",
      }),
      // rules: [
      //   (value) =>
      //     !value ||
      //     value.size < 2000000 ||
      //     "Avatar size should be less than 2 MB!",
      // ],
      categoryRules: [(v) => !!v || "Quiz is required"],
      nameRules: [(v) => !!v || "Name is required"],
      descriptionRules: [(v) => !!v || "Description is required"],
    };
  },
  props: ["categories"],

  methods: {
    validate() {
      this.$refs.form.validate();
    },
    onUpload() {
      this.form.image = this.files;
    },

    reset() {
      this.$refs.form.reset();
    },
    resetValidation() {
      this.$refs.form.resetValidation();
    },
    store: function () {
      if (this.$refs.form.validate()) {
        this.form.post("/album");
        this.snackbar = true;
      }
    },
  },
};
</script>
<style scoped>
div {
  max-width: 650px;
  margin: auto;
  margin-top: 20px;
}
</style>