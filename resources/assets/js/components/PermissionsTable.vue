<template lang="html">
    <table class="table">
       <thead>
            <th>Label</th>
            <th>Code</th>
            <th>Actions</th>
       </thead>
       <tbody>
               <tr v-for="(permission, index) in permissions">
                   <td v-text="permission.label"></td>
                   <td v-text="permission.code"></td>
                    <td>
                        <a :href="urls.edit(permission.id)" class="btn btn-sm btn-info">Edit</a>
                        <button class="btn btn-sm btn-danger" @click.prevent="deletePermission(index)">Delete</button>
                    </td>
               </tr>
       </tbody>
   </table>
</template>

<script type="text/babel">
    import {Permissions as urls} from "../endpoints"
    export default{
      props  : {
        initialPermissions: {
          type    : Array,
          required: true
        }
      },
      data() {
        return {
          urls       : urls,
          permissions: JSON.parse(JSON.stringify(this.initialPermissions))
        }
      },
      methods: {
        deletePermission(index){
          let permission = this.permissions[index],
              url        = this.urls.delete(permission.id)
          if (confirm('going to delete' + permission.label)) {
            axios.delete(url)
                 .then(response => this.permissions.splice(index, 1))
                 .catch(response => console.log(response))
          }

        }
      }
    }
</script>
<style></style>