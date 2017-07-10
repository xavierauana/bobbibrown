<template lang="html">
<div class="form-group">
    <label :for="answer.textareaId"
           class="col-sm-2 control-label" v-text="answerLabel">Correct Answer: </label>
    <div class="col-sm-10">
       <div class="input-group">
           <textarea class="form-control simpleEditor" aria-label="..." name="answer"
                     :id="answer.textareaId"></textarea>
           <span class="input-group-addon">
              <button v-if="showRemoveAnswer" class="btn btn-danger btn-sm" @click.prevent="removeAnswer"><i
                      class="fa fa-times"></i></button>
          </span>
        </div><!-- /input-group -->
    </div>
</div>
</template>

<script type="text/babel">
    export default{
      props   : {
        index              : {
          type   : Number,
          default: 0
        },
        showRemoveAnswer   : {
          type   : Boolean,
          default: true
        },
        answer             : {
          type    : Object,
          required: true
        },
        onChangeHandler    : {
          type: Function
        },
        removeAnswerHandler: {
          type: Function
        }
      },
      computed: {
        answerLabel(){
          return "Correct Answer{0}: ".format(this.index > 0 ? " " + this.index : "")
        }
      },
      mounted(){
        var instance = CKEDITOR.replace(this.answer.textareaId, {
          customConfig: '/js/test_ckeditor/simpleConfig.js',
        })
        if (_.isFunction(this.onChangeHandler)) {
          instance.on('change', this.updateAnswer)
        }
        instance.setData(this.answer.content)
      },
      beforeDestroy(){
        this._removeCKEditor(this.answer.textareaId)
      },
      methods : {
        updateAnswer(e){
          if (_.isFunction(this.onChangeHandler)) this.onChangeHandler(e, this.answer)
        },
        removeAnswer(){
          if (_.isFunction(this.removeAnswerHandler)) {
            this.removeAnswerHandler(this.answer)
          }
        }
      }
    }
</script>
<style></style>