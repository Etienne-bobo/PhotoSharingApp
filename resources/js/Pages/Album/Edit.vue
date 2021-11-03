<template>
  <v-app>
    <AppLayout>
      <div class="max-w-7xl mx-auto">
        <v-main>
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
          <v-container>
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
                  }}<span
                    ><v-icon
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
            <div class="flex justify-end mr-3">
              <!-- <inertia-link :href="route('question.create')"> -->
              <v-btn class="mx-2 mb-5" fab dark color="primary">
                <v-icon dark> mdi-plus </v-icon>
              </v-btn>
              <v-btn
                @click="confirmationDialog = true"
                fab
                color="red white--text"
              >
                <v-icon dark> mdi-delete </v-icon>
              </v-btn>
              <!-- </inertia-link> -->
            </div>
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
            <div class="text-center mx-auto">
              <span>
                No image availaible in this album.<br />
                Click add button to add one .
              </span>
              <v-img src="../../../../images/no-data.jpg"></v-img>
            </div>
          </v-container>
        </v-main>
      </div>
    </AppLayout>
  </v-app>
</template>
<script>
import AppLayout from "../../Layouts/AppLayout";
export default {
  name: "edit",
  components: {
    AppLayout,
  },
  props: ["album"],
  remember: "form",
  data() {
    return {
      dialog: false,
      confirmationDialog: false,
      valid: true,
      sending: false,
      multiLine: true,
      snackbar: true,
      form: {
        name: this.album.name,
        description: this.album.description,
      },
      nameRules: [(v) => !!v || "Name is required"],
      minutesRules: [(v) => !!v || "Duration of the album is required"],
      descriptionRules: [(v) => !!v || "Description is required"],
    };
  },
  methods: {
    reset() {
      this.$refs.form.reset();
    },
    resetValidation() {
      this.$refs.form.resetValidation();
    },
    update: function () {
      if (this.$refs.form.validate()) {
        this.$inertia.put(
          this.route("album.update", this.album.id),
          this.form,
          {
            onStart: () => (this.sending = true),
            onFinish: () => (this.sending = false),
          }
        );
      }
      this.dialog = false;
    },
    destroy(album) {
      album._method = "DELETE";
      this.$inertia.post("/album/" + album.id, album);
      this.confirmationDialog = false;
    },
  },
};
</script>