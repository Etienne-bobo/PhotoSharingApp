<template>
    <div>
        <app-layout>
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
                  All available Albums
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
                  Top albums
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
                <div v-for="(album, index) in allAlbum" :key="index">
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
            </div>
          </div>
          <!-- product-grid - end -->
        </app-layout>
          </div>
</template>

<script>
import AppLayout from '../../Layouts/AppLayout.vue'
export default {
    props: ['allAlbum'],
    components: {AppLayout}
}
</script>