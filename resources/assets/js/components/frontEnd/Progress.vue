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
    data() {
      return {
        collections  : [],
        lessonsStatus: []
      }
    },
    created() {
      axios.get(window.location.href + "?ajax=true")
           .then(({data}) => {
             this.collections = data.collections
             this.lessonsStatus = data.lessonsStatus
           })
    }
  }
</script>
<style>

</style>