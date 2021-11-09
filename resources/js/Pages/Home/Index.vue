<template>
  <div>
    <app-layout>
      <v-app>
        <v-main>
          <div class="mx-auto max-w-7xl">
            <div
              class="
                bg-gray-100
                pt-4
                rounded-md
                pb-6
                max-w-7xl
                mx-auto
                sm:pb-8
                lg:pb-12
              "
            >
              <section class="max-w-screen-2xl mt-8 px-4 md:px-8 mx-auto">
                <div class="flex flex-wrap justify-between mb-8 md:mb-16">
                  <div
                    class="
                      w-full
                      lg:w-1/3
                      flex flex-col
                      justify-center
                      lg:pt-48 lg:pb-24
                      mb-6
                      sm:mb-12
                      lg:mb-0
                    "
                  >
                    <h1
                      class="
                        text-indigo-500 text-4xl
                        sm:text-5xl
                        md:text-4xl
                        font-semibold
                        mb-4
                        md:mb-8
                      "
                    >
                      Share memories
                    </h1>

                    <p
                      class="max-w-md text-gray-500 xl:text-lg leading-relaxed"
                    >
                      Share your memories with all people around the world.
                    </p>
                  </div>

                  <div class="w-full lg:w-2/3 flex mb-12 md:mb-16">
                    <div
                      class="
                        bg-gray-100
                        rounded-lg
                        shadow-lg
                        overflow-hidden
                        relative
                        z-10
                        top-12
                        md:top-16
                        left-12
                        md:left-16
                        -ml-12
                        lg:ml-0
                      "
                    >
                      <img
                        src="https://images.unsplash.com/photo-1542340916-951bb72c8f74?auto=format&q=75&fit=crop&w=550&h=550"
                        loading="lazy"
                        alt="Photo by Kaung Htet"
                        class="w-full h-full object-cover object-center"
                      />
                    </div>

                    <div
                      class="bg-gray-100 rounded-lg shadow-lg overflow-hidden"
                    >
                      <img
                        src="https://images.unsplash.com/photo-1586295166487-b265f7e83a7f?auto=format&q=75&fit=crop&w=550&h=550"
                        loading="lazy"
                        alt="Photo by Manny Moreno"
                        class="w-full h-full object-cover object-center"
                      />
                    </div>
                  </div>
                </div>
              </section>
            </div>
            <!-- hero - end -->

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
                    Popular Albums
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
                  <div v-for="(album, index) in albums" :key="index">
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

            <!-- call to action - start -->
            <div class="bg-white py-6 sm:py-8 lg:py-12">
              <div class="max-w-screen-2xl px-4 md:px-8 mx-auto">
                <div
                  class="
                    md:h-80
                    flex flex-col
                    sm:flex-row
                    bg-gray-900
                    rounded-lg
                    overflow-hidden
                  "
                >
                  <!-- content - start -->
                  <div
                    class="w-full sm:w-1/2 lg:w-2/5 flex flex-col p-4 sm:p-8"
                  >
                    <h2
                      class="
                        text-white text-xl
                        md:text-2xl
                        lg:text-4xl
                        font-bold
                        mb-4
                      "
                    >
                      Discover<br />More albums.
                    </h2>

                    <p class="max-w-md text-gray-400 mb-8">
                      Get in touch with other in just one click
                    </p>

                    <div class="mt-auto">
                      <a
                        :href="route('all.album')"
                        class="
                          inline-block
                          bg-white
                          hover:bg-gray-100
                          active:bg-gray-200
                          focus-visible:ring
                          ring-indigo-300
                          text-gray-800 text-sm
                          md:text-base
                          font-semibold
                          text-center
                          rounded-lg
                          outline-none
                          transition
                          duration-100
                          px-8
                          py-3
                        "
                        >View now</a
                      >
                    </div>
                  </div>
                  <!-- content - end -->

                  <!-- image - start -->
                  <div
                    class="
                      w-full
                      sm:w-1/2
                      lg:w-3/5
                      h-48
                      sm:h-auto
                      order-first
                      sm:order-none
                      bg-gray-700
                    "
                  >
                    <img
                      src="https://images.unsplash.com/photo-1505846951821-e25bacf2eccd?auto=format&q=75&fit=crop&crop=top&w=1000&h=500"
                      loading="lazy"
                      alt="Photo by Dom Hill"
                      class="w-full h-full object-cover object-center"
                    />
                  </div>
                  <!-- image - end -->
                </div>
              </div>
            </div>
            <!-- call to action - end -->
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
                    Recent Photos
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
                    Photos recently added
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
                  <div v-for="(image, index) in images" :key="index">
                    <a
                      :href="route('image.edit', image.id)"
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
                        :src="image.image"
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
                          >{{ image.name }}</span
                        >
                      </div>
                    </a>
                  </div>
                  <!-- product - end -->
                </div>
              </div>
            </div>
            <!-- product-grid - end -->

            <!-- footer - end -->
          </div>
        </v-main>
      </v-app>
    </app-layout>
  </div>
</template>
<script>
import AppLayout from "../../Layouts/AppLayout.vue";
export default {
  components: { AppLayout },
  props: ["albums", "images"],
};
</script>