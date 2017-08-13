<template lang="html">
    <table class="table">
       <thead>
            <th>Title</th>
            <th>Start Date</th>
            <th>Vacancy</th>
            <th>Actions</th>
       </thead>
       <tbody>
               <tr v-for="(event, index) in events">
                   <td v-text="event.title"></td>
                   <td v-text="event.start_datetime"></td>
                   <td v-text="event.currentVacancies"></td>
                    <td>
                        <button class="btn btn-sm btn-default"
                                @click.prevent="publish(event)">Publish</button>
                        <button class="btn btn-sm btn-primary"
                                @click.prevent="getQrCode(event)">QR Code</button>
                        <a :href="urls.edit(event.id)" class="btn btn-sm btn-info">Edit</a>
                        <button class="btn btn-sm btn-danger" @click.prevent="deleteEvent(index)">Delete</button>
                    </td>
               </tr>
       </tbody>
   </table>
</template>

<script type="text/babel">
    import {Events as urls} from "../endpoints"

    export default {
      props  : {
        initialEvents: {
          type    : Array,
          required: true
        }
      },
      data() {
        return {
          urls  : urls,
          events: JSON.parse(JSON.stringify(this.initialEvents))
        }
      },
      methods: {
        deleteEvent(index) {
          let event = this.events[index],
              url   = this.urls.delete(event.id)
          if (confirm('going to delete' + event.title)) {
            axios.delete(url)
                 .then(response => this.events.splice(index, 1))
                 .catch(response => console.log(response))
          }
        },
        publish(event) {
          axios.post(this.urls.publish(event.id))
               .then(response => alert('Email will send to all active users.'))
               .catch(() => alert('something wrong! Pls try again later!'))
        },
        getQrCode(event) {
          let url = "/admin/events/" + event.id + "/qrcode"
          window.open(url)
        }
      }
    }
</script>
<style></style>