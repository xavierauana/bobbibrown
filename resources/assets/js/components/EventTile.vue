<template lang="html">
    <div class="event-tile">
        <a :href="urls.detail(event.id)">
            <div class="img-container" v-if="event.photo">
                <img :src="event.photo" class="img-responsive">
            </div>
            <h4 class="title" v-text="event.title"></h4>
            <p>
                <span v-text="startDate"></span>
                <span v-text="vacancies"></span>
            </p>
        </a>
    </div>
</template>

<script type="text/babel">
    import {Events as urls} from "./../endpoints"
    import moment from "moment"

    export default {
      props   : {
        event: {
          type    : Object,
          required: true
        }
      },
      data() {
        return {
          urls: urls
        }
      },
      computed: {
        startDate() {
          return moment(this.event.startDate).format('lll')
        },
        vacancies() {
          return this.event.vacancies - this.event.participants + " seats remaining"
        }
      }
    }
</script>
<style>
    div.event-tile {
        margin-bottom: 10px;
        padding: 10px;
        background-color: rgba(242, 242, 242, 0.65);
        border-radius: 5px;
    }

    div.event-tile .title {
        color: black;
    }

    div.event-tile p {
        color: grey;
    }

</style>