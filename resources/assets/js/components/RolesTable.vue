<template lang="html">
    <table class="table">
       <thead>
            <th>Label</th>
            <th>Code</th>
            <th>Actions</th>
       </thead>
       <tbody>
               <tr v-for="(role, index) in roles">
                   <td v-text="role.label"></td>
                   <td v-text="role.code"></td>
                    <td>
                        <a :href="urls.permissions(role.id)" class="btn btn-sm btn-default">Permissions</a>
                        <a :href="urls.edit(role.id)" class="btn btn-sm btn-info">Edit</a>
                        <button class="btn btn-sm btn-danger" @click.prevent="deleteRole(index)">Delete</button>
                    </td>
               </tr>
       </tbody>
   </table>
</template>

<script type="text/babel">
    import {Roles as urls} from "../endpoints"
    export default{
      props  : {
        initialRoles: {
          type    : Array,
          required: true
        }
      },
      data() {
        return {
          urls : urls,
          roles: JSON.parse(JSON.stringify(this.initialRoles))
        }
      },
      methods: {
        deleteRole(index){
          let role = this.roles[index],
              url  = this.urls.delete(role.id)
          if (confirm('going to delete' + role.label)) {
            axios.delete(url)
                 .then(response => this.roles.splice(index, 1))
                 .catch(response => console.log(response))
          }

        }
      }
    }
</script>
<style></style>