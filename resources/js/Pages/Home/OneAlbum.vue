<template>
    <div>
        <app-layout>
            <v-app>
                <v-main>
                              <!-- product-grid - start -->
          <div class="bg-white py-6 sm:py-8 lg:py-12">
            <div class="max-w-screen-2xl px-4 md:px-8 mx-auto">
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
                  Photos in <span class="text-indigo-500">{{albumName}}</span> album
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
                Discover amazing photos in this album.
                </p>
              </div>
              <!-- text - end -->

              <div
                class="
                  grid
                  sm:grid-cols-2
                  lg:grid-cols-3
                  xl:grid-cols-4
                  gap-x-4
                  md:gap-x-6
                  gap-y-8
                "
              >
                <!-- product - start -->
                <div v-for="(photo, index) in oneAlbumPhotos" :key="index">
                  <a
                    :href="route('image.edit', photo.id)"
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
                      :src="photo.image"
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
                  </a>
                </div>
                <!-- product - end -->
              </div>
            </div>
          </div>
          <!-- product-grid - end -->

                </v-main>
            </v-app>
        </app-layout>
    </div>
</template>
<script>
import AppLayout from '../../Layouts/AppLayout.vue'
export default {
    components:{AppLayout},
    props: ['oneAlbumPhotos', 'albumName']
}
</script>