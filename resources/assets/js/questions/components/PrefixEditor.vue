<template lang="html">
    <div>
        <button class="btn btn-default" @click.prevent="toggleShow" v-text="buttonText">Edit Prefix</button>
        <div class="form-group"v-show="show">
            <label :for="textareaId" class="col-sm-2 control-label">Description Before Question: </label>
            <div class="col-sm-10">
                <textarea class="form-control editor" name="prefix" :id="textareaId"
                          placeholder="Question"></textarea>
            </div>
        </div>
    </div>

</template>

<script type="text/babel">
    export default{
      props   : {
        onChangeHandler   : {
          type: Function
        },
        questionIdentifier: {
          default: null
        }
      },
      data(){
        return {
          show: false
        }
      },
      computed: {
        buttonText(){
          return this.show ? "Hide Prefix Editor" : "Show Prefix Editor"
        },
        textareaId(){
          const number = this.questionIdentifier ? this.questionIdentifier : _.random(1, 10000000);
          return "prefix_" + number
        }
      },
      mounted(){
        var editor = CKEDITOR.replace(this.textareaId)
        if (_.isFunction(this.onChangeHandler)) {
          editor.on("change", this.onChangeHandler)
        }
      },
      methods : {
        toggleShow(){
          this.show = !this.show
        }
      }
    }
</script>
<style></style>