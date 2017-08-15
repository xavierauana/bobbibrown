<template lang="html">
    <table class="table" v-if="events">
        <thead>
            <th>Event Title</th>
            <th>Event Start Datetime</th>
            <th>Actions</th>
        </thead>
        <tbody>
            <tr v-for="event in events">
                <td v-text="event.title"></td>
                <td v-text="event.start_datetime"></td>
                <td>
                    <button class="btn btn-sm btn-danger" v-show="!isPastEvent(event)"
                            @click.prevent="cancelRegistration(event)">Cancel Registration</button>
                </td>
            </tr>
        </tbody>
    </table>
</template>

<script type="text/babel">
    import {Events as urls} from "./../../endpoints"
    import moment from "moment"

    export default {
      props  : {
        initialEvents: {
          type    : Array,
          required: true
        }
      },
      data() {
        return {
          events: null
        }
      },
      mounted() {
        this.events = JSON.parse(JSON.stringify(this.initialEvents))
      },
      methods: {
        isPastEvent(event) {
          const endDatetime = moment(event.end_datetime, 'll')
          const current = moment()

          return !current.isAfter(endDatetime)
        },
        cancelRegistration(event) {
          if (confirm('Are you sure to cancel the Event Registration: ' + event.title)) {
            axios.post(urls.cancel(event.id))
                 .then(() => {
                   let index = _.findIndex(this.events, {id: event.id})
                   this.events.splice(index, 1)
                   alert('Successfully cancel the event')
                 })
                 .catch(response => console.log('something wrong, ', response))
          }
        },
      }
    }
</script>
<style></style>