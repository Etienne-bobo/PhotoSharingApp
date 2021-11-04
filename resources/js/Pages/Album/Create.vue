
<template>
  <v-app>
    <AppLayout>
      <v-main>
        <v-progress-linear
          :active="loading"
          :indeterminate="loading"
          absolute
          top
          color="deep-purple accent-4"
        ></v-progress-linear>
        <div class="max-w-2xl mx-auto">
          <v-container>
            <v-card flat class="mt-8">
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
                  :rules="imageRules"
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
            </v-card>
          </v-container>
        </div>
      </v-main>
    </AppLayout>
  </v-app>
</template>
<script>
import AppLayout from "../../Layouts/AppLayout.vue";
export default {
  data() {
    return {
      valid: true,
      files: [],
      loading: false,
      form: this.$inertia.form({
        name: "",
        description: "",
        image: null,
        category: "",
      }),
      imageRules: [
        (v) => !!v || "Image is required",

        (value) =>
          !value ||
          value.size < 5000000 ||
          "Image is required and should be less than 5 MB!",
      ],
      categoryRules: [(v) => !!v || "Category is required"],
      nameRules: [(v) => !!v || "Name is required"],
      descriptionRules: [(v) => !!v || "Description is required"],
    };
  },
  components: { AppLayout },
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
    store() {
      if (this.$refs.form.validate()) {
        this.loading = true;

        this.form.post("/album");
        this.snackbar = true;
      }
    },
  },
};
</script>
