<template>
  <div class="min-h-screen">
    <nav class="bg-white border-gray-100">
      <!-- Primary Navigation Menu -->
      <div class="max-w-7xl mx-auto py-1 px-4 lg:px-0">
        <div class="flex justify-between h-16">
          <div class="flex">
            <!-- Logo -->
            <div class="flex-shrink-0 flex items-center">
              <inertia-link class="flex" href="/">
                <jet-application-mark class="block h-9 w-auto" />
                <span class="mt-2 font-semibold ml-3 text-indigo-500"
                  >Share Karen</span
                >
              </inertia-link>
            </div>

            <!-- Navigation Links -->
            <ul class="flex items-center justify-end">
              <a
                class="
                  inline-flex
                  py-3
                  px-5
                  rounded-md
                  items-center
                  text-sm
                  font-medium
                  focus:outline-none
                  cursor-pointer
                  text-gray-800
                  border
                  hover:bg-gray-300
                "
                @click="showModal"
              >
                <svg
                  width="24"
                  height="24"
                  viewBox="0 0 24 24"
                  fill="none"
                  class="text-gray-500"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    d="M18.677 19.607L12.962 13.891C10.4196 15.6985 6.91642 15.2564 4.90285 12.8739C2.88929 10.4915 3.03714 6.96361 5.24298 4.75802C7.44824 2.55147 10.9765 2.40298 13.3594 4.41644C15.7422 6.42989 16.1846 9.93347 14.377 12.476L20.092 18.192L18.678 19.606L18.677 19.607ZM9.48498 5.00001C7.58868 4.99958 5.95267 6.3307 5.56745 8.18745C5.18224 10.0442 6.15369 11.9163 7.89366 12.6703C9.63362 13.4242 11.6639 12.8529 12.7552 11.3021C13.8466 9.75129 13.699 7.64734 12.402 6.26402L13.007 6.86402L12.325 6.18402L12.313 6.17202C11.5648 5.4192 10.5464 4.99715 9.48498 5.00001Z"
                    fill="#2E3A59"
                  ></path>
                </svg>

                <i class="text-sm sm:text-base">Search</i>
              </a>
            </ul>

            <div
              v-if="!$page.user"
              class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex"
            >
              <a
                :href="route('login')"
                class="
                  inline-flex
                  bg-indigo-500
                  my-3
                  px-6
                  items-center
                  border-transparent
                  text-sm
                  font-medium
                  leading-5
                  text-white
                  rounded-md
                  transition
                  duration-150
                  ease-in-out
                "
              >
                Login
              </a>
              <a
                :href="route('register')"
                class="
                  inline-flex
                  items-center
                  px-1
                  pt-1
                  border-b-2 border-transparent
                  text-sm
                  font-medium
                  leading-5
                  text-gray-500
                  hover:text-gray-700 hover:border-gray-300
                  focus:outline-none focus:text-gray-700 focus:border-gray-300
                  transition
                  duration-150
                  ease-in-out
                "
              >
                Register
              </a>
            </div>
            <div v-else class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
              <jet-nav-link
                :href="route('dashboard')"
                :active="route().current('dashboard')"
              >
                Dashboard
              </jet-nav-link>
              <jet-nav-link
                :href="route('album.index')"
                :active="route().current('album.index')"
              >
                My Album
              </jet-nav-link>
            </div>
          </div>

          <!-- Settings Dropdown -->
          <div v-if="$page.user" class="hidden sm:flex sm:items-center sm:ml-6">
            <div class="ml-3 relative">
              <jet-dropdown align="right" width="48">
                <template #trigger>
                  <button
                    v-if="$page.jetstream.managesProfilePhotos"
                    class="
                      flex
                      text-sm
                      border-2 border-transparent
                      rounded-full
                      focus:outline-none focus:border-gray-300
                      transition
                      duration-150
                      ease-in-out
                    "
                  >
                    <img
                      class="h-8 w-8 rounded-full object-cover"
                      :src="$page.user.profile_photo_url"
                      :alt="$page.user.name"
                    />
                  </button>

                  <button
                    v-else
                    class="
                      flex
                      items-center
                      text-sm
                      font-medium
                      text-gray-500
                      hover:text-gray-700 hover:border-gray-300
                      focus:outline-none
                      focus:text-gray-700
                      focus:border-gray-300
                      transition
                      duration-150
                      ease-in-out
                    "
                  >
                    <div>{{ $page.user.name }}</div>

                    <div class="ml-1">
                      <svg
                        class="fill-current h-4 w-4"
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20"
                      >
                        <path
                          fill-rule="evenodd"
                          d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                          clip-rule="evenodd"
                        />
                      </svg>
                    </div>
                  </button>
                </template>

                <template #content>
                  <!-- Account Management -->
                  <div class="block px-4 py-2 text-xs text-gray-400">
                    Manage Account
                  </div>

                  <jet-dropdown-link :href="route('profile.show')">
                    Profile
                  </jet-dropdown-link>

                  <jet-dropdown-link
                    :href="route('api-tokens.index')"
                    v-if="$page.jetstream.hasApiFeatures"
                  >
                    API Tokens
                  </jet-dropdown-link>

                  <div class="border-t border-gray-100"></div>

                  <!-- Team Management -->

                  <!-- Authentication -->
                  <form @submit.prevent="logout">
                    <jet-dropdown-link as="button"> Logout </jet-dropdown-link>
                  </form>
                </template>
              </jet-dropdown>
            </div>
          </div>

          <!-- Hamburger -->
          <div class="-mr-2 flex justify-end sm:hidden">
            <button
              @click="showingNavigationDropdown = !showingNavigationDropdown"
              class="
                inline-flex
                items-center
                justify-center
                p-2
                rounded-md
                text-gray-400
                hover:text-gray-500 hover:bg-gray-100
                focus:outline-none focus:bg-gray-100 focus:text-gray-500
                transition
                duration-150
                ease-in-out
              "
            >
              <svg
                class="h-6 w-6"
                stroke="currentColor"
                fill="none"
                viewBox="0 0 24 24"
              >
                <path
                  :class="{
                    hidden: showingNavigationDropdown,
                    'inline-flex': !showingNavigationDropdown,
                  }"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M4 6h16M4 12h16M4 18h16"
                />
                <path
                  :class="{
                    hidden: !showingNavigationDropdown,
                    'inline-flex': showingNavigationDropdown,
                  }"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M6 18L18 6M6 6l12 12"
                />
              </svg>
            </button>
          </div>
        </div>
      </div>

      <!-- Responsive Navigation Menu -->
      <div
        :class="{
          block: showingNavigationDropdown,
          hidden: !showingNavigationDropdown,
        }"
        class="sm:hidden"
      >
        <div v-if="!$page.user" class="flex px-4 flex-col">
          <a
            :href="route('login')"
            class="
              inline-flex
              bg-indigo-500
              my-3
              px-3
              py-2
              items-center
              border-transparent
              text-sm
              font-medium
              text-white
              rounded-md
              transition
              duration-150
              ease-in-out
            "
          >
            Login
          </a>
          <a
            :href="route('register')"
            class="
              inline-flex
              items-center
              px-1
              pt-1
              text-sm
              mb-3
              font-medium
              leading-5
              text-gray-500
              hover:text-gray-700 hover:border-gray-300
              focus:outline-none focus:text-gray-700 focus:border-gray-300
              transition
              duration-150
              ease-in-out
            "
          >
            Register
          </a>
        </div>
        <div v-if="$page.user" class="flex flex-col px-4">
          <jet-nav-link
            class="hover:shadow-none border-none"
            :href="route('dashboard')"
            :active="route().current('dashboard')"
          >
            Dashboard
          </jet-nav-link>
          <jet-nav-link
            class="my-3 hover:shadow-none border-none"
            :href="route('album.index')"
            :active="route().current('album.index')"
          >
            My Album
          </jet-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div v-if="$page.user" class="pt-4 pb-1 border-t border-gray-200">
          <div class="flex items-center px-4">
            <div class="flex-shrink-0">
              <img
                class="h-10 w-10 rounded-full"
                :src="$page.user.profile_photo_url"
                :alt="$page.user.name"
              />
            </div>

            <div class="ml-3">
              <div class="font-medium text-base text-gray-800">
                {{ $page.user.name }}
              </div>
              <div class="font-medium text-sm text-gray-500">
                {{ $page.user.email }}
              </div>
            </div>
          </div>

          <div class="mt-3 space-y-1">
            <jet-responsive-nav-link
              :href="route('profile.show')"
              :active="route().current('profile.show')"
            >
              Profile
            </jet-responsive-nav-link>
            <!-- Authentication -->
            <form method="POST" @submit.prevent="logout">
              <jet-responsive-nav-link as="button">
                Logout
              </jet-responsive-nav-link>
            </form>
          </div>
        </div>
      </div>
    </nav>

    <!-- Page Heading -->
    <!-- <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-2 px-4 sm:px-6 lg:px-8">
                <slot name="header"></slot>
            </div>
        </header> -->

    <!-- Page Content -->
    <main class="bg-white">
      <slot></slot>
      <Footer />
    </main>

    <!-- Modal Portal -->
    <portal-target name="modal" multiple> </portal-target>
    <search-modal v-show="isModalVisible" @close="isModalVisible = false" />
  </div>
</template>

<script>
import JetApplicationMark from "@/Jetstream/ApplicationMark";
import JetDropdown from "@/Jetstream/Dropdown";
import JetDropdownLink from "@/Jetstream/DropdownLink";
import JetNavLink from "@/Jetstream/NavLink";
import JetResponsiveNavLink from "@/Jetstream/ResponsiveNavLink";
import Footer from "../Pages/Home/footer.vue";
import SearchModal from "../components/searchModal.vue";
export default {
  components: {
    JetApplicationMark,
    JetDropdown,
    JetDropdownLink,
    JetNavLink,
    JetResponsiveNavLink,
    Footer,
    SearchModal,
  },

  data() {
    return {
      showingNavigationDropdown: false,
      isModalVisible: false,
    };
  },

  methods: {
    switchToTeam(team) {
      this.$inertia.put(
        route("current-team.update"),
        {
          team_id: team.id,
        },
        {
          preserveState: false,
        }
      );
    },

    logout() {
      axios.post(route("logout").url()).then((response) => {
        window.location = "/";
      });
    },
    showModal() {
      this.isModalVisible = true;
    },
    closeModal() {
      this.isModalVisible = false;
    },
  },
};
</script>
