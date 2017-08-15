<template lang="html">
    <div>
		<div class="img-container" v-if="event.photo">
			<img class="img-responsive" :src="event.photo">
		</div>
        <h4>Event Start Date Time: {{event.start_datetime}}</h4>
		<h4>Event End Date Time: {{event.end_datetime}}</h4>
		<h4>Venue: {{event.venue}}</h4>
		<section>
			<h4>Description:</h4>
			<div v-html="event.body"></div>
		</section>
		<br>

		<div>
			<button class="btn btn-sm btn-primary" v-show="canRegister" :disabled="!canRegister" @click="register">Register</button>
			<button class="btn btn-sm btn-danger" v-show="!canRegister" :disabled="canRegister" @click="cancelRegistration">Cancel Registration</button>
			<a :href="urls.frontEnd" class="btn btn-sm btn-info pull-right">Back</a>
		</div>
    </div>

</template>

<script type="text/babel">
	import {Events as urls} from "./../../endpoints"
    import moment from "moment"

    export default {
      props   : {
        user        : {
          type    : Object,
          required: true
        },
        initialEvent: {
          type    : Object,
          required: true
        }
      },
      data() {
        return {
          urls : urls,
          event: {
            'id'            : this.initialEvent.id,
            'title'         : this.initialEvent.title,
            'venue'         : this.initialEvent.venue,
            'photo'         : this.initialEvent.photo,
            'body'          : this.initialEvent.body,
            'vacancies'     : this.initialEvent.vacancies,
            'users'         : this.initialEvent.users,
            'start_datetime': moment(this.initialEvent.start_datetime).format('YYYY-MM-D, h:mm a'),
            'end_datetime'  : moment(this.initialEvent.end_datetime).format('YYYY-MM-D, h:mm a'),
            'participants'  : this.initialEvent.users.length,
          }
        }
      },
      computed: {
        canRegister() {
          return !_.find(this.event.users, {'id': this.user.id}) && this.event.users.length < this.event.vacancies
        }
      },
      methods : {
        addToCalendar() {
          console.log('add calendar')
        },
        register() {
          if (confirm('Are you sure to register the Event: ' + this.event.title)) {
            axios.post(this.urls.registration(this.event.id))
                 .then(({data}) => {
                   this.event.users.push(data.user)
                   alert('Successfully register the event')
                 })
                 .catch(response => console.log('something wrong, ', response))
          }
        },
        cancelRegistration() {
          if (confirm('Are you sure to cancel the Event Registration: ' + this.event.title)) {
            axios.post(this.urls.cancel(this.event.id))
                 .then(({data}) => {
                   let index = _.findIndex(this.event.users, {id: data.user.id})
                   this.event.users.splice(index, 1)
                   alert('Successfully cancel the event')
                 })
                 .catch(response => console.log('something wrong, ', response))
          }
        }
      }
    }
</script>
<style></style>