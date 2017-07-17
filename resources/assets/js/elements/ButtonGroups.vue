<template lang="html">
    <div>
         <div class="btn-group btn-group-sm hidden-xs hidden-sm" role="group" aria-label="...">
            <button class="btn btn-sm"
                    @click.prevent="clickButton(index)"
                    v-for="(label, index) in labels" v-text="label.label"
                    :class="label.class"></button>
        </div>

        <div class="btn-group-vertical btn-group-sm hidden-md hidden-lg" role="group" aria-label="...">
            <button class="btn btn-sm"
                    @click.prevent="clickButton(index)"
                    v-for="(label, index) in labels" v-text="label.label"
                    :class="label.class"></button>
        </div>
    </div>
</template>

<script type="text/babel">
    export default{
      props  : {
        rowNumber       : {
          type    : Number,
          required: true
        },
        labels          : {
          type    : Array,
          required: true
        },
        onClickFunctions: {
          type    : Array,
          required: true
        }
      },
      methods: {
        clickButton(index){
          if (this.onClickFunctions[index] && _.isFunction(this.onClickFunctions[index])) {
            this.onClickFunctions[index](this.rowNumber)
          }
        }
      }
    }
</script>
<style></style>