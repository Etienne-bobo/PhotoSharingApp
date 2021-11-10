<template>
  <div>
    <app-layout>
      <!-- product-grid - start -->
      <v-app>
        <div class="bg-white py-6 sm:py-8 lg:py-12">
          <div class="max-w-screen-xl px-4 md:px-8 mx-auto">
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
                All Albums created by
              </h2>
              <v-flex v-if="OneUser" class="mt-6">
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
                      :src="OneUser.profile_photo_url"
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

                    {{ OneUser.name }}
                    <span v-if="user && user.id != OneUser.id">
                      <v-btn
                        @click="followUser"
                        color="success"
                        v-if="!status"
                        class="ml-8"
                        >Follow</v-btn
                      >
                      <v-btn
                        @click="followUser"
                        color="orange"
                        class="ml-8"
                        v-else
                      >
                        Unfollow</v-btn
                      >
                    </span>
                  </p>
                  <p class="text--mini mt-3">
                    <span>Email:</span> {{ OneUser.email }}
                  </p>
                </div>
              </v-flex>
              <p
                class="
                  max-w-screen-md
                  text-gray-500
                  md:text-lg
                  text-center
                  mx-auto
                  mt-4
                "
              >
                Top albums
              </p>
            </div>
            <!-- text - end -->

            <div
              class="
                grid
                sm:grid-cols-2
                lg:grid-cols-3
                gap-x-4
                md:gap-x-6
                gap-y-8
              "
              v-if="userAlbums.length != 0"
            >
              <!-- product - start -->
              <div v-for="(album, index) in userAlbums" :key="index">
                <a
                  :href="route('album.edit', album.id)"
                  class="
                    group
                    h-96
                    block
                    bg-gray-100
                    rounded-lg
                    overflow-hidden
                    shadow-lg
                    relative
                    mb-2
                    lg:mb-3
                  "
                >
                  <img
                    :src="album.image"
                    loading="lazy"
                    alt="Photo by Austin Wade"
                    class="
                      w-full
                      h-full
                      object-cover object-center
                      group-hover:scale-110
                      transition
                      duration-200
                    "
                  />

                  <div class="flex gap-2 absolute left-0 bottom-2">
                    <span
                      class="
                        bg-green-500
                        text-white text-sm
                        font-semibold
                        tracking-wider
                        uppercase
                        rounded-r-lg
                        px-3
                        py-1.5
                      "
                      >{{ album.name }}</span
                    >
                  </div>
                </a>
              </div>
              <!-- product - end -->
            </div>
            <div v-else class="text-center pt-8 mx-auto">
              <span> No album availaible...<br /> </span>
              <v-img src="../../../../images/no-data.jpg"></v-img>
            </div>
          </div>
        </div>
      </v-app>
      <!-- product-grid - end -->
    </app-layout>
  </div>
</template>

<script>
import AppLayout from "../../Layouts/AppLayout.vue";
export default {
  props: ["userAlbums", "OneUser", "follows", "user"],
  components: { AppLayout },
  data() {
    return {
      status: this.follows,
    };
  },
  methods: {
    async followUser() {
      try {
        await axios.post("/follow", { userId: this.OneUser.id });
        this.status = !this.status;
      } catch (e) {
        return e;
      }
    },
  },
};
</script>