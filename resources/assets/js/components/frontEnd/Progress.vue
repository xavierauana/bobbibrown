<template lang="html">
  <div>
    <lesson-list v-for="collection in collections" :collection="collection"
                 :key="collection.id"
                 :lesson-status="lessonsStatus"></lesson-list>
  </div>
</template>

<script type="text/babel">
  import LessonList from "./LessonList.vue"

  export default {
    name      : 'progress',
    components: {
      LessonList
    },
    props     : {
      initialCollections: {
        type    : Array,
        required: true
      },
      lessonsStatus     : {
        type    : Object,
        required: true
      }
    },
    data() {
      return {
        collections: null
      }
    },
    mounted() {
      this.collections = JSON.parse(JSON.stringify(this.initialCollections))
    }
  }
</script>
<style>

</style>