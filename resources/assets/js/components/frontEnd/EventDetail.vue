<template lang="html">
    <div>
        <h5>Event Start Date and Time: {{event.start_datetime}}</h5>
		<h5>Event End Date and Time: {{event.end_datetime}}</h5>
		<section>
			<h4>Description</h4>
			<div v-html="event.body"></div>
		</section>

		<div class="panel-footer">
			<a :href="urls.frontEnd" class="btn btn-sm btn-info">Back</a>
			<button class="btn btn-sm btn-success" :disabled="!canRegister" @click="register">Register</button>
		</div>
    </div>

</template>

<script type="text/babel">
	import {Events as urls} from "./../../endpoints"
    import moment from "moment"

    export default{
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
      data(){
        return {
          urls : urls,
          event: {
            'id'            : this.initialEvent.id,
            'title'         : this.initialEvent.title,
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
        canRegister(){
          return !_.find(this.event.users, {'id': this.user.id})
        }
      },
      methods : {
        register(){
          axios.post(this.urls.registration(this.event.id))
               .then(({data}) => {
                 this.event.users.push(data.user)
                 alert('Successfully register the event')
               })
               .catch(response => console.log('something wrong, ', response))
        }
      }
    }
</script>
<style></style>