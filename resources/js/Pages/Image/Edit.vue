<template>
  <Disqus :pageConfig="pageConfig" :ssoConfig="ssoConfig" shortname="share-karen" />
</template>
<script>
export default {
  data() {
    return {
      ssoConfig: {
        name: "Share karen",
        url: "http://localhost:8000/login/",
        width: "800",
        height: "400",
      },
      pageConfig: {
      url: 'http://localhost:8000/image/edit/5'
    }
    };
  },
};
</script>