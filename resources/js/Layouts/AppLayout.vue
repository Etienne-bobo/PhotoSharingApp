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
  </div>
</template>

<script>
import JetApplicationMark from "@/Jetstream/ApplicationMark";
import JetDropdown from "@/Jetstream/Dropdown";
import JetDropdownLink from "@/Jetstream/DropdownLink";
import JetNavLink from "@/Jetstream/NavLink";
import JetResponsiveNavLink from "@/Jetstream/ResponsiveNavLink";
import Footer from "../Pages/Home/footer.vue";
export default {
  components: {
    JetApplicationMark,
    JetDropdown,
    JetDropdownLink,
    JetNavLink,
    JetResponsiveNavLink,
    Footer,
  },

  data() {
    return {
      showingNavigationDropdown: false,
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
  },
};
</script>
