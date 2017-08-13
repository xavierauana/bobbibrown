<template lang="html">
    <div>
        <div class="text-center" v-if="loading">
            <div class="block-center loader"></div>
            <h2>Loading...</h2>
        </div>
        <transition name="fade">
            <div class="text-center" v-if="completed && timestamp">
                <h2>Thank you!</h2>
                <h3>You sign in at <span v-text="timestamp"></span></h3>
            </div>
            <div class="text-center" v-if="completed && !timestamp">
                <h2>Sorry!</h2>
                <h3>You cannot sign in the event!</h3>
            </div>
        </transition>

    </div>
</template>

<script type="text/babel">
    export default {
      props  : {
        event: {
          type    : Object,
          required: true
        },
        token: {
          type    : String,
          required: true
        }
      },
      data() {
        return {
          loading       : true,
          completed     : false,
          timestamp     : null,
          transferObject: {
            token    : this.token,
            event_id : this.event.id,
            latitude : "",
            longitude: ""
          }
        }
      },
      created() {
        this.getLocation()
      },
      methods: {
        getLocation() {
          if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(this.showPosition, this.handleError);
          } else {
            console.log("Geolocation is not supported by this browser.");
          }
        },
        showPosition(position) {
          this.transferObject.latitude = position.coords.latitude
          this.transferObject.longitude = position.coords.longitude
          this.submit()
        },
        handleError(error) {
          switch (error.code) {
            case error.PERMISSION_DENIED:
              console.log("User denied the request for Geolocation.")
              break;
            case error.POSITION_UNAVAILABLE:
              console.log("Location information is unavailable.")
              break;
            case error.TIMEOUT:
              console.log("The request to get user location timed out.")
              break;
            case error.UNKNOWN_ERROR:
              console.log("An unknown error occurred.")
              break;
          }
          this.submit()
        },
        submit() {
          const url = "/events/" + this.event.id + "/signin"
          axios.post(url, this.transferObject)
               .then(({data}) => this.timestamp = data)
               .catch(response => console.log(response))
               .then(() => {
                 this.completed = true
                 this.loading = false
               })
        }
      }
    }
</script>
<style>


.fade-enter-active, .fade-leave-active {
    transition: opacity .5s
}

.fade-enter, .fade-leave-to {
    opacity: 0
}

.loader {
    border: 16px solid #f3f3f3; /* Light grey */
    border-top: 16px solid #3498db; /* Blue */
    border-radius: 50%;
    width: 120px;
    height: 120px;
    animation: spin 2s linear infinite;
    margin: 0 auto;
}

@keyframes spin {
    0% {
        transform: rotate(0deg);
    }
    100% {
        transform: rotate(360deg);
    }
}
</style>