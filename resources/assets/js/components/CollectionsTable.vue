<template lang="html">
    <table class="table">
       <thead>
            <th>Title</th>
            <th>Featured</th>
            <th>New</th>
            <th>Actions</th>
       </thead>
       <tbody>
               <tr v-for="(collection, index) in collections">
                   <td v-text="collection.title"></td>
                   <td>
                       <span class="label"
                             :class="{'label-success':collection.is_featured,'label-warning':!collection.is_featured}"
                       >{{collection.is_featured?'Featured':'Not Featured'}}</span>
                   </td>
                   <td>
                       <span class="label"
                             :class="{'label-success':collection.is_new,'label-warning':!collection.is_new}">{{collection.is_new?'New':'Not New'}}</span>
                   </td>
                    <td>
                       <button-group :labels="labels" :on-click-functions="onClickFunctions"
                                     :row-number="index" />
                    </td>
               </tr>
       </tbody>
   </table>
</template>

<script type="text/babel">
    import {Collections as urls} from "../endpoints"
    import ButtonGroup from "../elements/ButtonGroups.vue"

    export default {
      components: {
        ButtonGroup
      },
      props     : {
        initialCollections: {
          type    : Array,
          required: true
        }
      },
      data() {
        return {
          urls            : urls,
          collections     : JSON.parse(JSON.stringify(this.initialCollections)),
          onClickFunctions: [
            this.goToTestPage,
            this.goToLessonsPage,
            this.goToEditPage,
            this.deleteCollection
          ],
          labels          : [
            {label: "Test", "class": "btn-primary"},
            {label: "Lessons", "class": "btn-default"},
            {label: "Edit", "class": "btn-info"},
            {label: "Delete", "class": "btn-danger"},
          ],
        }
      },
      methods   : {
        goToTestPage(index){
          const collection = this.collections[index]
          window.location.href = this.urls.test(collection.id)
        },
        goToEditPage(index) {
          const collection = this.collections[index]
          window.location.href = this.urls.edit(collection.id)
        },
        goToLessonsPage(index) {
          const collection = this.collections[index]
          window.location.href = this.urls.lessons(collection.id)
        },
        deleteCollection(index) {
          let collection = this.collections[index],
              url        = this.urls.delete(collection.id)
          if (confirm('going to delete' + collection.title)) {
            axios.delete(url)
                 .then(response => this.collections.splice(index, 1))
                 .catch(response => console.log(response))
          }

        }
      }
    }
</script>
<style></style>`