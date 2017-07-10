<template lang="html">
    <div class="form-group">
        <label :for="choice.textareaId"
               class="col-sm-2 control-label" v-text="titleText"></label>
        <div class="col-sm-10">
            <div class="input-group">
               <span class="input-group-addon" v-if="showCorrectDropbox">
                  <select name="answer[is_corrected][]" @change="updateCorrect">
                      <option value="0" :selected="!isCorrected">False</option>
                      <option value="1" :selected="isCorrected">Correct</option>
                  </select>
              </span>
               <textarea class="form-control simpleEditor" aria-label="..." name="answer[content][]"
                         :id="choice.textareaId"></textarea>
               <span class="input-group-addon">
                          <button class="btn btn-danger btn-sm" @click.prevent="removeChoice"><i
                                  class="fa fa-times"></i></button>
               </span>
            </div><!-- /input-group -->
        </div>
    </div>
</template>

<script type="text/babel">
    export default{
      props   : {
        choice            : {
          type: Object,
          default(){ return {} }
        },
        index             : {
          type   : Number,
          default: 0
        },
        showIndex         : {
          type   : Boolean,
          default: false
        },
        showCorrectDropbox: {
          type   : Boolean,
          default: true
        }
      },
      computed: {
        isCorrected(){
          return this.choice.is_corrected ? true : false
        },
        titleText(){
          if (this.showIndex) {
            return "Choice " + this.index + " :"
          }
          return "Choice :"
        }
      },
      mounted(){
        console.log("in choice component, ", this.choice.id)
//        console.log("in choice component, ", this.choice)
        this.instantiateEditor()
      },
      methods : {
        instantiateEditor(){
          var instance = CKEDITOR.replace(this.choice.textareaId, {
            customConfig: '/js/test_ckeditor/simpleConfig.js',
          })
          instance.on('change', (e) => {
            this._updateChoice('content', e.editor.getData())
          })
          instance.setData(this.choice.content)
          instance.updateElement()
          return instance
        },
        removeChoice(){
          this.$emit('remove-choice', this.choice)
        },
        updateCorrect(e){
          this._updateChoice("is_corrected", !!parseInt(e.target.value))
        },
        _updateChoice(key, value){
          this.$emit('update-content', this.choice, key, value)
        }
      }
    }
</script>
