<template>
  <app-layout>
    <v-app>
      <v-main>
        <div class="mt-6 max-w-7xl mx-auto px-4">
          <div>
            <v-row no-gutters>
              <v-col cols="12" sm="4">
                <v-alert
                  border="left"
                  class="mx-2 py-6 text-center font-semibold"
                  colored-border
                  color="success"
                  elevation="2"
                >
                  <v-icon>mdi-face-man</v-icon> Followers <br />
                  <v-btn class="my-6 py-4" color="success">{{
                    followers.length
                  }}</v-btn>
                </v-alert>
              </v-col>
              <v-col cols="12" sm="4">
                <v-alert
                  border="left"
                  class="mx-2 py-6 text-center font-semibold"
                  colored-border
                  color="primary"
                  elevation="2"
                >
                  <v-icon>mdi-hand-heart</v-icon> Followings <br />
                  <v-btn class="my-6 py-4" color="primary">
                    {{ followings.length }}</v-btn
                  >
                </v-alert>
              </v-col>
              <v-col cols="12" sm="4">
                <v-alert
                  border="left"
                  class="mx-2 py-6 text-center font-semibold"
                  colored-border
                  color="orange"
                  elevation="2"
                >
                  <v-icon>mdi-folder-multiple</v-icon> My Albums <br />
                  <v-btn class="my-6 py-4" color="orange">
                    {{ userAlbums.length }}
                  </v-btn>
                </v-alert>
              </v-col>
              <v-col cols="12" sm="4">
                <v-alert
                  border="left"
                  class="mx-2 py-6 text-center font-semibold"
                  colored-border
                  color="orange"
                  elevation="2"
                >
                  <v-icon>mdi-camera-image</v-icon> My Photos <br />
                  <v-btn class="my-6 py-4" color="orange"> {{ photos }} </v-btn>
                </v-alert>
              </v-col>
            </v-row>
          </div>
          <v-tabs class="mt-6" v-model="tabs" fixed-tabs>
            <v-tabs-slider></v-tabs-slider>
            <v-tab href="#mobile-tabs-5-1" class="primary--text">
              <v-icon>mdi-face-man</v-icon>
              <span class="ml-2">Followers</span>
            </v-tab>

            <v-tab href="#mobile-tabs-5-2" class="primary--text">
              <v-icon>mdi-hand-heart</v-icon>
              <span class="ml-2">Followings</span>
            </v-tab>
          </v-tabs>
          <v-tabs-items v-model="tabs">
            <v-tab-item :value="'mobile-tabs-5-' + 1">
              <v-card flat>
                <v-card-text>
                  <v-list-item-group v-if="follower.length != 0" color="primary">
                    <v-list-item v-for="(follow, i) in follower" :key="i">
                      <v-list-item-icon>
                        <v-avatar><v-img :src="follow.profile_photo_url"></v-img></v-avatar>
                      </v-list-item-icon>
                      <v-list-item-content>
                        <v-list-item-title
                        > {{follow.name}}</v-list-item-title>
                      </v-list-item-content>
                    </v-list-item>
                  </v-list-item-group>
                  <v-list-item-group v-else color="primary">
                    <v-list-item>
                      <v-list-item-content>
                        <v-list-item-title class="text-gray-500"
                        > No followers</v-list-item-title>
                      </v-list-item-content>
                    </v-list-item>
                  </v-list-item-group>
                  
                </v-card-text>
              </v-card>
            </v-tab-item>
            <v-tab-item :value="'mobile-tabs-5-' + 2">
              <v-card flat>
                <v-card-text>
                  <v-list-item-group v-if="following.length != 0" color="primary">
                    <v-list-item v-for="(follow, i) in following" :key="i">
                      <v-list-item-icon>
                        <v-avatar><v-img :src="follow.profile_photo_url"></v-img></v-avatar>
                      </v-list-item-icon>
                      <v-list-item-content>
                        <v-list-item-title
                        > {{follow.name}}</v-list-item-title>
                      </v-list-item-content>
                    </v-list-item>
                  </v-list-item-group>
                  <v-list-item-group v-else color="primary">
                    <v-list-item>
                      <v-list-item-content>
                        <v-list-item-title class="text-gray-500"
                        > No followings</v-list-item-title>
                      </v-list-item-content>
                    </v-list-item>
                  </v-list-item-group>
                </v-card-text>
              </v-card>
            </v-tab-item>
          </v-tabs-items>
        </div>
      </v-main>
    </v-app>
  </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
export default {
  components: {
    AppLayout,
  },
  props: ["userAlbums", "followings", "followers", "liker"],
  data() {
    return {
      tabs: null,
    };
  },
  computed: {
    photos() {
      let total = 0;
      for (var album = 0; album < this.userAlbums.length; album++) {
        total = total + this.userAlbums[album].images.length;
      }
      return total;
    },
    following() {
      let follows = [];
      for (var f = 0; f < this.followings.length; f++) {
        follows.push(this.followings[f].userfollow);
      }
      return follows;
    },
    follower() {
      let followerList = [];
      for (var f = 0; f < this.followers.length; f++) {
        followerList.push(this.followers[f].whofollow_user);
      }
      return followerList;
    },
  },
};
</script>
