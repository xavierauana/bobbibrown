<template lang="html">
    <table class="table">
		            <thead>
		                <th>Event</th>
		                <th>Vacancy</th>
		                <th>Register</th>
		            </thead>
		            <tbody>
			                <tr v-for="event in events">
			                    <td>
				                    <a :href="showEventDetail(event)" v-text="event.title"></a>
			                    </td>
			                    <td>
				                    <span class="label"
                                          :class="{'label-success':hasVacancy(event), 'label-danger':!hasVacancy(event)}"
                                          v-text="event.participants + ' / ' + event.vacancies">
				                    </span>
			                    </td>
				                <td>
					                <button @click="register(event.id)" class="btn btn-sm btn-success"
                                            :disabled="!event.can_register">Register</button>
				                </td>
		                    </tr>
		            </tbody>
	            </table>
</template>

<script type="text/babel">
    export default{
      props: {
        initialEvents: {
          type    : Array,
          required: true
        }
      },
      data(){
        return {
          events: JSON.parse(JSON.stringify(this.initialEvents))
        }
      },

      methods: {
        hasVacancy     (event) {
          return event.vacancies > event.participants
        }
        ,
        register       (eventId) {
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
        showEventDetail (event) {
          return window.location.href + "/" + event.id
        }
      }
    }
</script>
<style></style>