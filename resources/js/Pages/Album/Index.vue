<template>
  <v-app>
    <app-layout>
      <div v-if="$page.flash.message" class="text-center">
        <v-snackbar v-model="snackbar" :multi-line="multiLine" top>
          <p class="text-sm">{{ $page.flash.message }}</p>

          <template v-slot:action="{ attrs }">
            <v-btn color="red" text v-bind="attrs" @click="snackbar = false">
              Close
            </v-btn>
          </template>
        </v-snackbar>
      </div>
      <div class="max-w-7xl pt-6 px-4 mx-auto">
        <v-main>
          <div class="flex">
            <span class="font-semibold">
              <v-btn class="bg-white" color="white" elevation="0">Albums</v-btn>
            </span>
            <span align="right" class="mb-8 flex justify-end">
              <inertia-link :href="route('album.create')">
                <v-btn class="mx-2" fab dark color="primary">
                  <v-icon dark> mdi-plus </v-icon>
                </v-btn>
              </inertia-link>
            </span>
          </div>
          <div no-gutters v-if="albums.length != 0">
            <div class="bg-white py-6 sm:py-8 lg:py-12">
              <div class="w-full px-4 mx-auto">
                <!-- text - start -->
                <div class="mb-10 md:mb-16">
                  <h2
                    class="
                      text-gray-800 text-2xl
                      lg:text-3xl
                      font-bold
                      text-center
                      mb-4
                      md:mb-6
                    "
                  >
                    Gallery
                  </h2>

                  <p
                    class="
                      max-w-screen-md
                      text-gray-500
                      md:text-lg
                      text-center
                      mx-auto
                    "
                  >
                    This is a section of some simple filler text, also known as
                    placeholder text. It shares some characteristics of a real
                    written text but is random or otherwise generated.
                  </p>
                </div>
                <!-- text - end -->

                <div
                  class="
                    grid grid-cols-2
                    sm:grid-cols-3
                    gap-4
                    md:gap-6
                    xl:gap-8
                  "
                >
                  <!-- image - start -->
                  <a
                    href="#"
                    v-for="(album, index) in albums"
                    :key="index"
                    class="
                      group
                      h-48
                      md:h-96
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
                    <img
                      :src="album.image"
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

                    <span
                      class="
                        inline-block
                        text-white text-xs
                        md:text-sm
                        border border-gray-500
                        rounded-lg
                        backdrop-blur
                        relative
                        px-2
                        md:px-3
                        py-1
                        mr-3
                        mb-3
                      "
                      >{{ album.name }}</span
                    >
                  </a>
                  <!-- image - end -->
                </div>
              </div>
            </div>
          </div>

          <v-row v-else class="text-center mx-auto">
            <div align="center" class="mx-2">
              <v-alert border="right" colored-border type="error" elevation="2">
                Album list is empty.<br />
                Click add button to add one .
              </v-alert>
              <v-skeleton-loader
                v-bind="attrs"
                type="date-picker"
              ></v-skeleton-loader>
            </div>
          </v-row>
        </v-main>
      </div>
    </app-layout>
  </v-app>
</template>
<script>
import AppLayout from "../../Layouts/AppLayout.vue";
export default {
  name: "index",
  props: ["albums"],
  data() {
    return {
      confirmationDialog: false,
      multiLine: true,
      snackbar: true,
      attrs: {
        class: "mb-6",
        boilerplate: false,
        elevation: 2,
      },
    };
  },
  components: {
    AppLayout,
  },
  methods: {
    //     edit: function (data) {
    //       this.form = Object.assign({}, data);
    //     },
    //     destroy(album) {
    //       if (
    //         !confirm(
    //           "This action will delete definitively this album. Do want to continue ?"
    //         )
    //       )
    //         return;
    //       album._method = "DELETE";
    //       this.$inertia.post("/album/" + album.id, album);
    //       this.confirmationDialog = false;
    //     },
  },
};
</script>

