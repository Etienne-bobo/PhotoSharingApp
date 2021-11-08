<template>
  <v-app>
    <v-main>
      <div class="max-w-2xl px-4 mx-auto mt-12">
        <v-form v-if="user" class="flex">
          <v-avatar class="mr-3" color="primary">
            <v-icon dark> mdi-account-circle </v-icon>
          </v-avatar>

          <v-textarea
            v-model="comment"
            auto-grow
            filled
            outlined
            color="deep-purple"
            label="start a discussion"
            rows="1"
          ></v-textarea>

          <span
            class="
              ml-4
              text-white
              cursor-pointer
              mb-7
              pt-4
              bg-indigo-500
              rounded-md
              px-4
            "
            @click.prevent="store"
          >
            Post as {{ user.name }}
          </span>
        </v-form>
        <div class="text-green-500" v-else>Please login to comment</div>
        <span v-if="comments.length != 0">
          <div
            class="flex mb-3"
            v-for="(comment, index) in comments"
            :key="index"
          >
            <v-avatar v-if="comment.commenter" class="mr-3" color="indigo">
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
                <span class="text-white bg-gray-500 text-xs px-1 rounded-sm"
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
              <div class="mt-4">
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
                  class="text-green-500 cursor-pointer text-xs flex justify-end"
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
                    <v-img :src="tempReply.commenter.profile_photo_url"></v-img>
                  </v-avatar>
                  <v-avatar v-else class="mr-3" color="indigo">
                    <v-icon dark> mdi-account-circle </v-icon>
                  </v-avatar>

                  <span v-if="tempReply.commenter" class="text-indigo-500">{{
                    tempReply.commenter.name
                  }}</span>
                  <span class="text-white bg-gray-500 text-xs px-1 rounded-sm"
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
              <div class="" v-for="(reply, id) in CommentsReplys" :key="id">
                <div v-if="reply.child_id == comment.id">
                  <v-avatar v-if="reply.commenter" class="mr-3" color="indigo">
                    <v-img :src="reply.commenter.profile_photo_url"></v-img>
                  </v-avatar>
                  <v-avatar v-else class="mr-3" color="indigo">
                    <v-icon dark> mdi-account-circle </v-icon>
                  </v-avatar>

                  <span v-if="reply.commenter" class="text-indigo-500">{{
                    reply.commenter.name
                  }}</span>
                  <span class="text-white bg-gray-500 text-xs px-1 rounded-sm"
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
        <span class="mx-auto text-green-500" v-else>
          Be the first to comment
        </span>
      </div>
    </v-main>

    <Disqus />
  </v-app>
</template>
<script>
import { TimeAgo } from "vue2-timeago";
export default {
  data() {
    return {
      comment: "",
      reply: [],
      comments: [],
      tempReply: {},
    };
  },
  components: {
    TimeAgo,
  },

  props: ["image", "user", "commentsReply"],
  computed: {
    CommentsReplys() {
      if (this.comments.length != 0) {
        return this.commentsReply.reverse();
      }
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
        this.comment = "";
      } catch (e) {
        return e;
      }
    },
  },
  mounted() {
    axios
      .get(`http://localhost:8000/image/${this.image.id}/edit/comments`)
      .then((response) => (this.comments = response.data.reverse()));
  },
};
</script>
<style scoped>
.btn {
  text-transform: unset !important;
}
</style>
