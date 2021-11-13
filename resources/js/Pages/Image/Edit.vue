<template>
  <div>
    <AppLayout>
      <v-app>
        <v-main>
          <div class="max-w-7xl px-4 mx-auto">
            <!-- product - start -->
            <div>
              <div
                class="
                  group
                  Height
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

                <div
                  @click="downloadPhoto"
                  class="flex gap-2 absolute left-0 bottom-2 cursor-pointer"
                >
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
                      mb-4
                    "
                    >Download
                    <v-icon class="text-white">mdi-download</v-icon></span
                  >
                </div>
              </div>
            </div>
          </div>
          <v-row justify="center">
            <v-dialog v-model="confirmationDialog" persistent max-width="600px">
              <v-card>
                <v-card-title> Delete this image </v-card-title>
                <v-card-text>
                  <p>This action will remove definitively this image</p>
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
                    @click="destroy(image)"
                  >
                    Delete
                  </v-btn>
                </v-card-actions>
              </v-card>
            </v-dialog>
          </v-row>
          <div class="max-w-7xl mx-auto">
            <div class="flex justify-end mr-4">
              <v-tooltip top>
                <template v-slot:activator="{ on, attrs }">
                  <span v-if="user" class="mr-3">
                    <v-btn
                      fab
                      @click="likeImage"
                      v-bind="attrs"
                      v-on="on"
                      v-if="!isLiked"
                      class="ml-8 focus:outline-none focus:bg-white"
                      ><v-icon>mdi-thumb-up-outline</v-icon
                      ><span>{{ likeCount }}</span></v-btn
                    >
                    <v-btn
                      fab
                      @click="likeImage"
                      v-bind="attrs"
                      v-on="on"
                      color="primary"
                      v-else
                      class="ml-8 focus:outline-none focus:bg-white"
                      ><v-icon>mdi-thumb-up</v-icon
                      ><span>{{ likeCount }}</span></v-btn
                    >
                  </span>
                </template>
                <div class="flex flex-col">
                  <span v-for="(lik, index) in liker" :key="index" class="my-2">
                    <v-avatar class="mr-3" color="indigo">
                      <v-img :src="lik.profile_photo_url"></v-img>
                    </v-avatar>
                    <span>{{ lik.name }}</span>
                  </span>
                </div>
              </v-tooltip>

              <div
                v-for="(imageOwner, index) in imageAlbum"
                :key="index"
                class="max-w-7xl mr-3"
              >
                <span v-if="user">
                  <v-btn
                    v-if="imageOwner.user_id == user.id"
                    @click="confirmationDialog = true"
                    fab
                    color="red white--text"
                  >
                    <v-icon dark> mdi-delete </v-icon>
                  </v-btn>
                </span>
              </div>
            </div>

            <div
              v-for="(imageOwnerProfileInfo, ind) in imageOwnerProfile"
              :key="ind"
              class="mt-8 px-4 flex items-center text-indigo-500 font-semibold"
            >
              <inertia-link
                :href="route('user.albums', imageOwnerProfileInfo.id)"
              >
                <v-avatar class="mr-3" color="indigo">
                  <v-img :src="imageOwnerProfileInfo.profile_photo_url"></v-img>
                </v-avatar>
                <span>{{ imageOwnerProfileInfo.name }}</span>
              </inertia-link>
              <span v-if="user && user.id != userId">
                <v-btn
                  @click="followUser"
                  color="success"
                  v-if="!status"
                  class="ml-8"
                  >Follow</v-btn
                >
                <v-btn @click="followUser" color="orange" class="ml-8" v-else>
                  Unfollow</v-btn
                >
              </span>
            </div>
          </div>
          <div class="mx-auto max-w-7xl">
            <div class="max-w-2xl px-4 mt-12">
              <v-form v-if="user" class="flex">
                <!-- <v-avatar class="mr-3" color="indigo">
                  <v-icon dark>mdi-account-circle </v-icon>
                </v-avatar> -->

                <v-textarea
                  v-model="comment"
                  auto-grow
                  filled
                  outlined
                  color="deep-purple"
                  label="start a discussion"
                  rows="1"
                ></v-textarea>
                <v-btn fab class="ml-4">
                  <v-icon @click.prevent="store">
                    <!-- Post as {{ user.name }} -->
                    mdi-send
                  </v-icon>
                </v-btn>
              </v-form>
              <div class="text-green-500 mb-8" v-else>
                Please login to like the picture, follow, comment or to reply to
                a comment
              </div>
              <div class="text-green-800 font-semibold mb-8">Comments</div>

              <span v-if="comments.length != 0">
                <div
                  class="flex mb-3"
                  v-for="(comment, index) in comments"
                  :key="index"
                >
                  <v-avatar
                    v-if="comment.commenter"
                    class="mr-3"
                    color="indigo"
                  >
                    <v-img :src="comment.commenter.profile_photo_url"></v-img>
                  </v-avatar>
                  <v-avatar v-else class="mr-3" color="indigo">
                    <v-icon dark> mdi-account-circle </v-icon>
                  </v-avatar>
                  <div class="flex flex-col">
                    <div>
                      <span v-if="comment.commenter" class="text-indigo-500">{{
                        comment.commenter.name
                      }}</span>
                      <span
                        class="text-white bg-gray-500 text-xs px-1 rounded-sm"
                        >Mod</span
                      >
                      <time-ago
                        long
                        :refresh="60"
                        :datetime="comment.created_at"
                        tooltip
                      ></time-ago>
                    </div>

                    <div class="flex flex-col mb-4">
                      {{ comment.comment }}
                    </div>
                    <div v-if="user" class="mt-4">
                      <v-textarea
                        v-model="reply[comment.id]"
                        auto-grow
                        filled
                        outlined
                        color="deep-purple"
                        label="reply"
                        rows="1"
                      ></v-textarea>
                      <span
                        @click="replys(comment.id)"
                        class="
                          text-green-500
                          cursor-pointer
                          text-xs
                          flex
                          justify-end
                        "
                        >reply
                        <v-icon class="text-xs" color="success"
                          >mdi-subdirectory-arrow-left</v-icon
                        ></span
                      >
                    </div>
                    <div class="" v-if="Object.keys(tempReply).length != 0">
                      <span v-if="tempReply.child_id == comment.id">
                        <v-avatar
                          v-if="tempReply.commenter"
                          class="mr-3"
                          color="indigo"
                        >
                          <v-img
                            :src="tempReply.commenter.profile_photo_url"
                          ></v-img>
                        </v-avatar>
                        <v-avatar v-else class="mr-3" color="indigo">
                          <v-icon dark> mdi-account-circle </v-icon>
                        </v-avatar>

                        <span
                          v-if="tempReply.commenter"
                          class="text-indigo-500"
                          >{{ tempReply.commenter.name }}</span
                        >
                        <span
                          class="text-white bg-gray-500 text-xs px-1 rounded-sm"
                          >Mod</span
                        >
                        <time-ago
                          long
                          :refresh="60"
                          :datetime="tempReply.created_at"
                          tooltip
                        ></time-ago
                        ><br />
                        <span class="ml-16"> {{ tempReply.comment }} </span>
                      </span>
                    </div>
                    <div
                      class=""
                      v-for="(reply, id) in CommentsReplys"
                      :key="id"
                    >
                      <div v-if="reply.child_id == comment.id">
                        <v-avatar
                          v-if="reply.commenter"
                          class="mr-3"
                          color="indigo"
                        >
                          <v-img
                            :src="reply.commenter.profile_photo_url"
                          ></v-img>
                        </v-avatar>
                        <v-avatar v-else class="mr-3" color="indigo">
                          <v-icon dark> mdi-account-circle </v-icon>
                        </v-avatar>

                        <span v-if="reply.commenter" class="text-indigo-500">{{
                          reply.commenter.name
                        }}</span>
                        <span
                          class="text-white bg-gray-500 text-xs px-1 rounded-sm"
                          >Mod</span
                        >
                        <time-ago
                          long
                          :refresh="60"
                          :datetime="reply.created_at"
                          tooltip
                        ></time-ago
                        ><br />
                        <span class="ml-16"> {{ reply.comment }} </span>
                      </div>
                    </div>
                  </div>
                </div>
              </span>
              <span class="mx-auto text-indigo-500" v-else>
                Be the first to comment
              </span>
            </div>
          </div>
        </v-main>
      </v-app>
    </AppLayout>
  </div>
</template>
<script>
import { TimeAgo } from "vue2-timeago";
import AppLayout from "../../Layouts/AppLayout.vue";
export default {
  props: ["image", "user", "commentsReply", "imageAlbum", "userId"],

  data() {
    return {
      comment: "",
      reply: [],
      comments: [],
      tempReply: {},
      dialog: false,
      loading: false,
      zIndex: 0,
      confirmationDialog: false,
      imageOwnerProfile: [],
      isLiked: '',
      likeCount: "",
      userWhoLike: [],
      status: "",
    };
  },
  components: {
    TimeAgo,
    AppLayout,
  },

  computed: {
    CommentsReplys() {
      if (this.comments.length != 0) {
        return this.commentsReply.reverse();
      }
    },
    liker() {
      let whoLike = [];
      for (var f = 0; f < this.userWhoLike.length; f++) {
        whoLike.push(this.userWhoLike[f].userlike);
      }
      return whoLike;
    },
  },
  methods: {
    async store() {
      try {
        await axios.post(
          `http://localhost:8000/image/${this.image.id}/edit/comments`,
          {
            comment: this.comment,
          }
        );
        this.comment = "";
      } catch (e) {
        return e;
      } finally {
        axios
          .get(`http://localhost:8000/image/${this.image.id}/edit/comments`)
          .then((response) => (this.comments = response.data.reverse()));
      }
    },
    async replys(commentId) {
      try {
        await axios
          .post(
            `http://localhost:8000/image/${this.image.id}/edit/comment/${commentId}/reply`,
            {
              reply: this.reply[commentId],
            }
          )
          .then((response) => (this.tempReply = response.data));
        this.reply = [];
      } catch (e) {
        return e;
      }
    },
    forceFileDownload(response) {
      const url = window.URL.createObjectURL(new Blob([response.data]));
      const link = document.createElement("a");
      link.href = url;
      link.setAttribute("download", "file.png"); //or any other extension
      document.body.appendChild(link);
      link.click();
    },
    downloadPhoto() {
      axios({
        method: "get",
        url: this.image.image,
        responseType: "arraybuffer",
      })
        .then((response) => {
          this.forceFileDownload(response);
        })
        .catch(() => console.log("error occured"));
    },
    destroy(image) {
      image._method = "DELETE";
      this.$inertia.post("/image/delete/" + image.id, image);
      this.confirmationDialog = false;
    },
    async followUser() {
      try {
        await axios.post("/follow", { userId: this.userId });
        this.status = !this.status;
      } catch (e) {
        return e;
      }
    },
    async likeImage() {
      try {
        await axios.post("/like", { imageId: this.image.id });
        axios
          .get(`http://localhost:8000/likeCount/${this.image.id}`)
          .then((response) => (this.likeCount = response.data));
        axios
          .get(`http://localhost:8000/userWhoLike/${this.image.id}`)
          .then((response) => (this.userWhoLike = response.data));
        this.isLiked = !this.isLiked;
      } catch (e) {
        return e;
      }
    },
  },
  mounted() {
    axios
      .get(`http://localhost:8000/image/${this.image.id}/edit/comments`)
      .then((response) => (this.comments = response.data.reverse()));

    let imageOwnerId = Object.assign({}, this.imageAlbum);
    axios
      .get(
        `http://localhost:8000/imageOwnerProfile/${imageOwnerId["0"].user_id}`
      )
      .then((response) => (this.imageOwnerProfile = response.data));
    axios
      .get(`http://localhost:8000/likeCount/${this.image.id}`)
      .then((response) => (this.likeCount = response.data));

    axios
      .get(`http://localhost:8000/userWhoLike/${this.image.id}`)
      .then((response) => (this.userWhoLike = response.data));

    axios
      .get(`http://localhost:8000/followStatus/${this.image.id}`)
      .then((response) => (this.status = response.data));

    axios
      .get(`http://localhost:8000/likeStatus/${this.image.id}`)
      .then((response) => (this.isLiked = response.data));
  },
};
</script>
<style scoped>
.btn {
  text-transform: unset !important;
}

@media (min-width: 768px) {
  .Height {
    height: 600px /* 384px */;
  }
}
</style>
