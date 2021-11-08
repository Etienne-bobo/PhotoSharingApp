<template>
  <v-app>
    <v-main>
      <div class="max-w-2xl mx-auto mt-12">
        <v-form v-if="user" class="flex">
          <v-avatar class="mr-3" color="indigo">
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

          <v-btn color="primary" class="ml-4 px-4 py-7" @click.prevent="store">
            Post as {{user.name}}
          </v-btn>
        </v-form>
        <div v-else>
          Hello
        </div>
        <div class="flex" v-for="(comment, index) in comments" :key="index">
          <v-avatar class="mr-3" color="indigo">
            <v-icon dark> mdi-account-circle </v-icon>
          </v-avatar>
                      <span v-if="comment.commenter">{{comment.commenter.name}}</span>

        </div>
      </div>
    </v-main>

    <Disqus />
  </v-app>
</template>
<script>
export default {
  data() {
    return {
      comment: "",
    };
  },
  props: ["image", "comments", "user"],
  methods: {
    store() {
      axios.post(`http://localhost:8000/image/${this.image.id}/edit/comments`, {
        comment: this.comment,
      });
    },
  },
};
</script>