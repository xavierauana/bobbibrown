<template lang="html">
    <table class="table">
       <thead>
            <th>Name</th>
            <th>Actions</th>
       </thead>
       <tbody>
               <tr v-for="(product, index) in products">
                   <td v-text="product.name"></td>
                    <td>
                        <a :href="urls.edit(product.id)" class="btn btn-sm btn-info">Edit</a>
                        <button class="btn btn-sm btn-danger" @click.prevent="deleteLine(index)">Delete</button>
                    </td>
               </tr>
       </tbody>
   </table>
</template>

<script type="text/babel">
    import {Products as urls} from "../endpoints"

    export default {
      props  : {
        initialProducts: {
          type    : Array,
          required: true
        }
      },
      data() {
        return {
          urls    : urls,
          products: JSON.parse(JSON.stringify(this.initialProducts))
        }
      },
      methods: {
        deleteLine(index) {
          let product = this.products[index],
              url     = this.urls.delete(product.id)
          if (confirm('going to delete' + product.name)) {
            axios.delete(url)
                 .then(response => this.products.splice(index, 1))
                 .catch(response => console.log(response))
          }

        }
      }
    }
</script>
<style></style>