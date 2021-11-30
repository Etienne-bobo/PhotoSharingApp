<template>
  <transition class="modal" name="slide-fade" mode="out-in">
    <div class="modal-backdrop" @keydown.esc="$emit('close')">
      <div class="modal">
        <div class="modal_header">
          <p id="modal_header__title">Search for albums</p>
          <button
            id="close_search_btn"
            class="text-gray-500 focus:outline-none"
            @click="$emit('close')"
          >
            close
          </button>
        </div>

        <div id="modal_search" class="max-w-7xl mx-auto w-full">
          <label for="modal_search_input"></label>
          <form @submit.prevent="results">
            <input
              id="modal_search_input"
              v-model="searchTerm"
              type="text"
              placeholder="Search album by name or description..."
            />
          </form>
          <p class="mt-2 text-gray-700">Press enter to search</p>
          <section v-if="searchResults.length != 0" class="mt-8">
            <div
              v-for="(result, index) in searchResults"
              :key="index"
              class="mb-4"
            >
              <inertia-link :href="route('album.edit', result.id)">
                <div class="border items-center flex px-4 py-8 hover:shadow-md">
                  <div class="mr-4">
                    <img
                      :src="result.image"
                      class="rounded-full h-16 w-16"
                      alt=""
                    />
                  </div>
                  <div>
                    <p class="font-semibold text-indigo-500">
                      {{ result.name }}
                    </p>
                    <p>{{ result.description }}</p>
                  </div>
                </div>
              </inertia-link>
            </div>
          </section>
          <section
            v-if="searchResults.length == 0 && errorMessage"
            class="flex justify-center text-red-500 mx-auto text-lg mt-6"
          >
            {{ errorMessage }}
          </section>
          <!-- <button
            v-if="anime"
            class="
              animate-ping
              mx-auto
              flex
              justify-center
              mt-8
              py-3
              px-6
              bg-indigo-500
              text-white
              rounded-lg
            "
          >
            searching...
          </button> -->
        </div>
      </div>
    </div>
  </transition>
</template>

<script>
export default {
  name: "SearchModal",
  data: () => ({
    searchTerm: "",
    searchResults: [],
    anime: false,
    errorMessage: "",
  }),
  // computed: {
  //   results() {
  //     return this.searchResults.data
  //   },
  // },
  // watch: {
  //   async searchTerm() {
  //     const searchTerm = this.searchTerm
  //     if (searchTerm.length < 3) return []
  //     const res = await ApiService.get('posts', {
  //       params: {
  //         title_contains: searchTerm,
  //       },
  //     })
  //     this.searchResults = res
  //   },
  // },
  methods: {
    close() {
      this.$emit("close");
    },
    async results() {
      try {
        this.anime = true;
        const searchTerm = this.searchTerm;
        if (searchTerm.length < 3) return [];
        await axios
          .get(`/search/${this.searchTerm}`)
          .then((res) => (this.searchResults = res.data));

        this.errorMessage = "No album found, Try another word";
        //this.searchResults = res.data
      } catch (e) {
        return e;
      }
    },
  },
};
</script>

<style lang="scss" scoped>
#modal_search {
  padding: 3em;
  hr {
    display: block;
    margin: 0.5em auto;
    border-style: inset;
    border-width: 1px;
    opacity: 0.2;
  }
  #modal_search_input {
    font-size: 2em;
    width: 100%;
    caret-color: darkgray;
    @apply bg-gray-100 text-gray-700 rounded-lg border px-4 py-4 shadow;
    &:focus {
      outline: none;
      border-bottom: 2px solid #3399ff;
    }
  }
  .result_title {
    @apply font-medium text-2xl text-gray-700;
  }
  .result_title:hover {
    @apply text-green-500;
  }
  .result_description {
    @apply text-gray-600 mt-2 mb-6;
  }
  @media screen and (max-width: 800px) {
    padding: 0.5em 0;
    #modal_search_input {
      padding: 0.5em 0.5em;
      font-size: 1.2em;
    }
    .result_title {
      @apply font-medium text-xl text-gray-700;
    }
    .result_description {
      @apply text-sm text-gray-600;
    }
  }
}
.search_card {
  padding-top: 1em;
}
/* Enter and leave animations can use different */
/* durations and timing functions.              */
.slide-fade-enter-active {
  transition: all 0.3s ease-in;
}
.slide-fade-leave-active {
  transition: all 0.3s ease-out;
}
.slide-fade-enter, .slide-fade-leave-to
        /* .slide-fade-leave-active below version 2.1.8 */ {
  transform: translateX(10px);
  opacity: 0;
}
#close_search_btn {
  cursor: pointer;
}
#modal_header__title {
  font-size: 18px;
  font-weight: bold;
  @apply text-gray-700;
}
.modal_header {
  display: flex;
  width: 100%;
  align-items: center;
  justify-items: center;
  justify-content: space-between;
}
.modal-backdrop {
  overflow: hidden;
  position: fixed;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  background-color: rgba(0, 0, 0, 0.3);
  display: flex;
  justify-content: center;
  align-items: center;
}
.modal {
  background-color: #fff;
  // box-shadow: 2px 2px 20px 1px;
  overflow-x: auto;
  display: flex;
  width: 100%;
  height: 100%;
  flex-direction: column;
  padding: 20px;
}
.modal-body {
  margin-top: 1em;
}
.btn-close {
  border: none;
  font-size: 20px;
  padding: 20px;
  cursor: pointer;
  font-weight: bold;
  color: #4aae9b;
  background: transparent;
}
</style>
