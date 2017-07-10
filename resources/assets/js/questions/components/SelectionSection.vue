<template lang="html">
  <div class="panel panel-default">
    <div class="panel-heading" role="tab" :id="heading_id">
      <h4 class="panel-title">
        <p> {{title}} <button @click.prevent="addMoreChoice" class="btn btn-default pull-right">Add More Choice</button></p>
      </h4>
    </div>
    <div class="panel-collapse">
      <div class="panel-body">
        <multiple-choice
                v-for="choice in filteredChoices"
                v-show="choice.active"
                :choice="choice"
                :key="choice.id"
                @remove-choice="removeChoice"
                @update-content="updateChoiceContent">
            </multiple-choice>
      </div>
    </div>
  </div>
</template>

<script type="text/babel">
  import MultipleChoice from "./MultipleChoice.vue"

  export default{
    props     : {
      choices: {
        type: Array
      },
      title  : {
        type: String
      }
    },
    computed  : {
      filteredChoices(){

        return _.filter(this.choices, choice => choice.textareaId.indexOf(escape(this.title) + "answer") > -1)

      }
    },
    components: {
      MultipleChoice
    },
    methods   : {
      addMoreChoice(){
        this.$emit('add-choice', {title: this.title})
      },
      removeChoice(choice){
        this.$emit('remove-choice', choice)
      },
      updateChoiceContent(choice, key, value){
        this.$emit('update-content', choice, key, value)
      },
    }
  }
</script>
<style></style>