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
            <v-avatar class="mr-3" color="indigo">
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
              <div>
                {{ comment.comment }}
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
      comments: [],
    };
  },
  components: {
    TimeAgo,
  },
  props: ["image", "user"],
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
          .then((response) => (this.comments = response.data));
      }
    },
  },
  mounted() {
    axios
      .get(`http://localhost:8000/image/${this.image.id}/edit/comments`)
      .then((response) => (this.comments = response.data));
  },
};
</script>
<style scoped>
.btn {
  text-transform: unset !important;
}
</style>