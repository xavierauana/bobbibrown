<template lang="html">
    <table class="table">
       <thead>
            <th>Name</th>
            <th>Actions</th>
       </thead>
       <tbody>
               <tr v-for="(category, index) in categories">
                   <td v-text="category.name"></td>
                    <td>
                        <a :href="urls.edit(category.id)" class="btn btn-sm btn-info">Edit</a>
                        <button class="btn btn-sm btn-danger" @click.prevent="deleteCategory(index)">Delete</button>
                    </td>
               </tr>
       </tbody>
   </table>
</template>

<script type="text/babel">
    import {Categories as urls} from "../endpoints"

    export default {
      props  : {
        initialCategories: {
          type    : Array,
          required: true
        }
      },
      data() {
        return {
          urls      : urls,
          categories: JSON.parse(JSON.stringify(this.initialCategories))
        }
      },
      methods: {
        deleteCategory(index) {
          let category = this.categories[index],
              url      = this.urls.delete(category.id)
          if (confirm('going to delete' + category.name)) {
            axios.delete(url)
                 .then(response => this.categories.splice(index, 1))
                 .catch(response => console.log(response))
          }

        }
      }
    }
</script>
<style></style>