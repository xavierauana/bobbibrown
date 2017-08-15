<template lang="html">
    <table class="table">
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
                    <button class="btn btn-sm btn-danger" v-show="!isPastEvent(event)">Cancel Registration</button>
                </td>
            </tr>
        </tbody>
    </table>
</template>

<script type="text/babel">
    import moment from "moment"

    export default {
      props  : {
        events: {
          type    : Array,
          required: true
        }
      },
      methods: {
        isPastEvent(event) {
          const endDatetime = moment(event.end_datetime, 'll')
          const current = moment()

          return !current.isAfter(endDatetime)
        }
      }
    }
</script>
<style></style>