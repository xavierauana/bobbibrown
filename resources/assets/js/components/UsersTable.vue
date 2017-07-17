<template lang="html">
    <table class="table">
       <thead>
            <th>Name</th>
            <th>Empolyee ID</th>
            <th>Verified Email</th>
            <th>Approved</th>
            <th>Actions</th>
       </thead>
       <tbody>
               <tr v-for="(user, index) in users">
                   <td v-text="user.name"></td>
                   <td v-text="user.employee_id"></td>
                   <td>
                      <span class="label" :class="{'label-success': user.is_verified,'label-danger': !user.is_verified}"
                            v-text="isVerified(user)"></span>

                   </td>
                   <td>
                       <span class="label"
                             :class="{'label-success': user.is_approved,'label-danger': !user.is_approved}"
                             v-text="isApproved(user)"></span>
                   </td>
                    <td>
                        <a :href="urls.show(user.id)" class="btn btn-sm btn-primary">show</a>
                        <a :href="urls.edit(user.id)" class="btn btn-sm btn-info">Edit</a>
                        <button class="btn btn-sm btn-success" @click.prevent="approveUser(user)">Approve</button>
                        <button class="btn btn-sm btn-danger" @click.prevent="deleteUser(index)">Delete</button>
                    </td>
               </tr>
       </tbody>
   </table>
</template>

<script type="text/babel">
    import {Users as urls} from "../endpoints"
    export default{
      props  : {
        initialUsers: {
          type    : Array,
          required: true
        }
      },
      data() {
        return {
          urls : urls,
          users: JSON.parse(JSON.stringify(this.initialUsers))
        }
      },
      methods: {
        deleteUser(index){
          let user = this.users[index],
              url  = this.urls.delete(user.id)
          if (confirm('going to delete' + user.label)) {
            axios.delete(url)
                 .then(response => this.users.splice(index, 1))
                 .catch(response => console.log(response))
          }
        },
        approveUser(user){
          axios.post(this.urls.approve(user.id))
               .then(() => user.is_approved = true)
               .catch(response => console.log(response))
        },
        isVerified(user){
          return user.is_verified ? 'Verified' : 'Not Verified';
        },
        isApproved(user){
          return user.is_approved ? 'Approved' : 'Not Approved';
        },
      }
    }
</script>
<style></style>