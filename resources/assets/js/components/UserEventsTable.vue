<template lang="html">
    <div>
        <detail v-for="event in events" :event="event" :key="event.id"></detail>
    </div>
</template>

<script type="text/babel">
	import Detail from "./EventTile.vue"

    export default {
      props     : {
        initialEvents: {
          type    : Array,
          required: true
        }
      },
      components: {
        Detail
      },
      data() {
        return {
          events: JSON.parse(JSON.stringify(this.initialEvents))
        }
      },

      methods: {
        hasVacancy(event) {
          return event.vacancies > event.participants
        }
        ,
        register(eventId) {
          let url = this._getUrl(eventId)
          axios.post(url)
               .then(response => {
                 if (response.data.register) {
                   let event = _.find(this.events, {'id': eventId})
                   event.participants += 1
                   event.can_register = false
                   alert('Event Register!')
                 } else {
                   alert(response.data.message)
                 }
               })
               .catch(response => {
                 console.log(response)
               })
        }
        ,
        _getUrl(eventId) {
          return window.location.href + "/" + eventId + '/register'
        }
        ,
        showEventDetail(event) {
          return window.location.href + "/" + event.id
        }
      }
    }
</script>
<style></style>