<template lang="html">
    <div class="form-group">
        <label :for="textareaId" class="col-sm-2 control-label">Question Content: </label>
        <div class="col-sm-10">
            <textarea class="form-control editor" name="content" :id="textareaId"
                      placeholder="Question"></textarea>
        </div>
    </div>
</template>

<script type="text/babel">
    export default{
      props:{
        onChangeHandler:{
          type: Function
        },
        questionIdentifier:{
          default: null
        }
      },
      computed:{
        textareaId(){
          const number = this.questionIdentifier? this.questionIdentifier : _.random(1, 10000000);
          return "content_"+number
        }
      },
      mounted(){
        var editor = CKEDITOR.replace(this.textareaId)
        if(_.isFunction(this.onChangeHandler)){
          editor.on("change", this.onChangeHandler)
        }
      }
    }
</script>
<style></style>