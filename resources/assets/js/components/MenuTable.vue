<template lang="html">
    <table class="table">
       <thead>
            <th>Title</th>
            <th>Actions</th>
       </thead>
       <tbody>
               <tr v-for="(menu, index) in menus">
                   <td v-text="menu.title"></td>
                    <td>
                        <a :href="urls.update(menu.id)" class="btn btn-sm btn-info">Edit</a>
                        <button class="btn btn-sm btn-danger" @click.prevent="deleteMenu(index)">Delete</button>
                    </td>
               </tr>
       </tbody>
   </table>
</template>

<script type="text/babel">
    import {Menus as urls} from "../endpoints"
    export default{
      props  : {
        initialMenus: {
          type    : Array,
          required: true
        }
      },
      data() {
        return {
          urls : urls,
          menus: JSON.parse(JSON.stringify(this.initialMenus))
        }
      },
      methods: {
        deleteMenu(index){
          let menu = this.menus[index],
              url  = this.urls.delete(menu.id)
          if (confirm('going to delete' + menu.title)) {
            axios.delete(url)
                 .then(response => this.menus.splice(index, 1))
                 .catch(response => console.log(response))
          }

        }
      }
    }
</script>
<style></style>