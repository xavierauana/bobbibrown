<template lang="html">
    <div>
        <component :is="current"
                   :_result="attempt"
                   :_score="score"
                   v-on:changeComponent="changeComponent"
        ></component>
    </div>
</template>

<script type="text/babel">
    import Test from "./attempt.vue"
    import Result from "./../../attempt_result/components/main.vue"

    export default{
      data(){
        return {
          current: 'test',
          attempt: null,
          score  : -1
        }
      },
      components: {
        Test,
        Result
      },
      methods   : {
        changeComponent(response){
          this.attempt = response.attempt
          this.score = response.score
          this.current = this.current === "test" ? 'result' : 'test';
        }
      }
    }
</script>
<style></style>
