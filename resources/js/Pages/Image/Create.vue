
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
              <v-alert
                class="py-6 mb-16"
                border="top"
                colored-border
                type="info"
                elevation="2"
              >
                Upload Images
              </v-alert>

              <v-form ref="form" class="mt-6" v-model="valid" lazy-validation>
                <v-file-input
                  v-model="files"
                  multiple
                  color="deep-purple accent-4"
                  accept="image/*"
                  counter
                  filled
                  @change="onUpload"
                  placeholder="Select your files"
                  show-size
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
                  :disabled="!valid || files.length == 0"
                  color="primary"
                  class="mr-4 w-full px-16 mt-4 py-8"
                  @click.prevent="store"
                >
                  Upload
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
      size: "",
      files: [],
      loading: false,
      form: this.$inertia.form({
        album_id: "",
        images: null,
      }),
    };
  },
  props: ["album_id"],
  mounted() {
    this.form.album_id = this.album_id;
  },
  components: { AppLayout },
  methods: {
    validate() {
      this.$refs.form.validate();
    },
    onUpload() {
      this.form.images = this.files;
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
        this.form.post("/image/store");
        this.snackbar = true;
      }
    },
  },
};
</script>
