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
                      <span class="label"
                            :class="{'label-success': user.is_verified,'label-danger': !user.is_verified}"
                            v-text="isVerified(user)"></span>

                   </td>
                   <td>
                       <span class="label"
                             :class="{'label-success': user.is_approved,'label-danger': !user.is_approved}"
                             v-text="isApproved(user)"></span>
                   </td>
                   <td>
                        <button class="btn btn-sm btn-success"
                                @click.prevent="restore(user)">Restore</button>
                    </td>
               </tr>
       </tbody>
   </table>
</template>

<script type="text/babel">
    import {Users as urls} from "../endpoints"

    export default {
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
        restore(user) {
          const form  = document.createElement('form'),
                input = document.createElement('input'),
                token = document.head.querySelector('meta[name="csrf-token"]').content;

          form.action = this.urls.restore(user.id)

          form.method = "POST"

          input.type = 'hidden'

          input.value = token

          input.name = "_token"

          form.appendChild(input)

          this.$el.append(form)

          form.submit()

          return
        },
        isVerified(user) {
          return user.is_verified ? 'Verified' : 'Not Verified';
        },
        isApproved(user) {
          return user.is_approved ? 'Approved' : 'Not Approved';
        },
      }
    }
</script>
<style></style>