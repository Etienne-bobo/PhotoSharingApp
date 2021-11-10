<template>
  <div>
    <AppLayout>
      <v-app>
        <v-main>
          <div class="max-w-7xl mx-auto px-4">
            <v-progress-linear
              :active="loading"
              :indeterminate="loading"
              absolute
              top
              color="deep-purple accent-4"
            ></v-progress-linear>
            <div v-if="$page.flash.message" class="text-center">
              <v-snackbar v-model="snackbar" :multi-line="multiLine" top>
                <p class="text-sm">{{ $page.flash.message }}</p>

                <template v-slot:action="{ attrs }">
                  <v-btn
                    color="red"
                    text
                    v-bind="attrs"
                    @click="snackbar = false"
                  >
                    Close
                  </v-btn>
                </template>
              </v-snackbar>
            </div>
            <v-flex class="mt-6">
              <div class="mt-6 py-8 rounded-md px-4 w-full bg-gray-200">
                <p
                  class="
                    flex
                    items-center
                    text-2xl text-indigo-500
                    font-weight-bold
                  "
                >
                  <img
                    :src="album.image"
                    alt="Photo by Fakurian Design"
                    class="
                      mr-4
                      w-16
                      h-16
                      rounded-full
                      object-cover object-center
                      inset-0
                    "
                  />

                  {{ album.name
                  }}<span v-if="album.currentUser"
                    ><v-icon
                      v-if="album.user_id == album.currentUser.id"
                      class="ml-6"
                      @click="dialog = true"
                      color="primary_dark"
                      >mdi-pencil</v-icon
                    ></span
                  >
                </p>
                <p class="text--mini">
                  <span>Description:</span> {{ album.description }}
                </p>
                <span v-for="category in album.category" :key="category.id">
                  <p class="text--mini">
                    <span>Category:</span> {{ category.name }}
                  </p>
                </span>
              </div>
            </v-flex>
            <v-row justify="center">
              <v-dialog v-model="dialog" persistent max-width="600px">
                <v-card>
                  <v-card-title>album </v-card-title>
                  <v-card-text>
                    <v-container>
                      <v-form
                        ref="form"
                        class="mt-6"
                        v-model="valid"
                        lazy-validation
                      >
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
                          v-for="category in album.category"
                          :key="category.id"
                          :items="categories"
                          v-model="form.category = category.id"
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
                              class="
                                text-overline
                                grey--text
                                text--darken-3
                                mx-2
                              "
                            >
                              +{{ files.length - 2 }} File(s)
                            </span>
                          </template>
                        </v-file-input>
                      </v-form>
                    </v-container>
                    <small>*indicates required field</small>
                  </v-card-text>
                  <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="blue darken-1" text @click="dialog = false">
                      Close
                    </v-btn>
                    <v-btn color="blue darken-1" text @click="update">
                      Update
                    </v-btn>
                  </v-card-actions>
                </v-card>
              </v-dialog>
            </v-row>
            <v-row justify="center">
              <v-dialog
                v-model="confirmationDialog"
                persistent
                max-width="600px"
              >
                <v-card>
                  <v-card-title> Delete this album </v-card-title>
                  <v-card-text>
                    <p>
                      This action will remove definitively
                      <b>{{ album.name }}</b> album
                    </p>
                  </v-card-text>
                  <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                      color="blue darken-1"
                      text
                      @click="confirmationDialog = false"
                    >
                      Close
                    </v-btn>
                    <v-btn
                      color="red"
                      class="white--text"
                      @click="destroy(album)"
                    >
                      Delete
                    </v-btn>
                  </v-card-actions>
                </v-card>
              </v-dialog>
            </v-row>
            <span v-if="album.currentUser">
              <div
                v-if="album.user_id == album.currentUser.id"
                class="flex justify-end mr-3"
              >
                <inertia-link :href="route('image.create', album.id)">
                  <v-btn class="mx-2 mb-5" fab dark color="primary">
                    <v-icon dark> mdi-plus </v-icon>
                  </v-btn>
                </inertia-link>
                <v-btn
                  @click="confirmationDialog = true"
                  fab
                  color="red white--text"
                >
                  <v-icon dark> mdi-delete </v-icon>
                </v-btn>
              </div>
            </span>
            <!-- <v-row no-gutters v-if="album.questions.length != 0">
          <v-col
            v-for="(question, id) in album.questions"
            :key="id"
            cols="12"
            sm="4"
          >
            <v-card class="mx-auto mb-6" max-width="344">
              <v-card-text>
                <p class="text-md text--primary">
                  {{ question.question }}
                </p>
              </v-card-text>
              <v-card-actions>
                <inertia-link :href="route('question.edit', question.id)">
                  <v-btn text color="teal white--text"> View </v-btn>
                </inertia-link>
              </v-card-actions>
            </v-card>
          </v-col>
        </v-row> -->
            <div class="mt-8 font-semibold mt-4">Galery</div>

            <div
              class="
                grid grid-cols-2
                sm:grid-cols-3
                gap-4
                md:gap-6
                xl:gap-8
                mt-8
              "
              v-if="album.images.length != 0"
            >
              <!-- image - start -->
              <span
                v-for="(image, id) in album.images"
                :key="id"
                class="
                  group
                  h-48
                  md:h-72
                  lg:h-96
                  flex
                  justify-end
                  items-end
                  bg-gray-100
                  overflow-hidden
                  rounded-lg
                  shadow-lg
                  relative
                "
              >
                <inertia-link :href="route('image.edit', image.id)">
                  <img
                    :src="image.image"
                    loading="lazy"
                    alt="Photo by Minh Pham"
                    class="
                      w-full
                      h-full
                      object-cover object-center
                      absolute
                      inset-0
                      transform
                      group-hover:scale-110
                      transition
                      duration-200
                    "
                  />

                  <div
                    class="
                      bg-gradient-to-t
                      from-gray-800
                      via-transparent
                      to-transparent
                      opacity-50
                      absolute
                      inset-0
                      pointer-events-none
                    "
                  ></div>
                </inertia-link>
              </span>
              <!-- image - end -->
            </div>
            <div v-else class="text-center pt-8 mx-auto">
              <span>
                No image availaible in this album.<br />
                Click add button to add one .
              </span>
              <v-img src="../../../../images/no-data.jpg"></v-img>
            </div>
          </div>
        </v-main>
      </v-app>
    </AppLayout>
  </div>
</template>
<script>
import AppLayout from "../../Layouts/AppLayout";
export default {
  name: "edit",
  components: {
    AppLayout,
  },
  props: ["album", "categories"],
  data() {
    return {
      dialog: false,
      loading: false,
      zIndex: 0,
      confirmationDialog: false,
      valid: true,
      files: [],
      sending: false,
      multiLine: true,
      snackbar: true,
      form: this.$inertia.form({
        _method: "PUT",
        name: this.album.name,
        description: this.album.description,
        category: "",
        image: null,
      }),
      nameRules: [(v) => !!v || "Name is required"],
      descriptionRules: [(v) => !!v || "Description is required"],
      categoryRules: [(v) => !!v || "Category is required"],
    };
  },
  methods: {
    reset() {
      this.$refs.form.reset();
    },
    resetValidation() {
      this.$refs.form.resetValidation();
    },
    onUpload() {
      this.form.image = this.files;
    },
    async update() {
      this.dialog = false;
      this.loading = true;
      try {
        if (this.$refs.form.validate()) {
          await this.form.post(
            this.route("album.update", this.album.id),
            this.form,
            {
              onStart: () => (this.sending = true),
              onFinish: () => (this.sending = false),
            }
          );
          this.loading = false;
        }
      } catch (e) {
        return e;
      }
    },
    destroy(album) {
      album._method = "DELETE";
      this.$inertia.post("/album/" + album.id, album);
      this.confirmationDialog = false;
    },
  },
};
</script>