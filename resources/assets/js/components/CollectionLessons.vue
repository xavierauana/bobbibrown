<template lang="html">
    <form class="form">
		<div class="form-group">
			<label>Lessons</label>
			<v-select :value.sync="selected"
                      :options="options"
                      label="title"
                      multiple
                      :placeholder="placeholder"
                      :on-change="updateSelection"></v-select>
		</div>
		<div class="form-group">
			<button class="btn btn-success btn-block" @click.prevent="updateLessons">Update Lessons</button>
		</div>
	</form>

</template>

<script type="text/babel">
import {Collections as urls} from "../endpoints"
import VSelect from "vue-select"
export default{
  components: {
    VSelect
  },
  props     : {
    collection     : {
      type    : Object,
      required: true
    },
    lessons        : {
      type    : Array,
      required: true
    },
    selectedLessons: {
      type    : Array,
      required: true
    },
  },
  data(){
    return {
      urls       : urls,
      selected   : JSON.parse(JSON.stringify(this.selectedLessons)),
      options    : JSON.parse(JSON.stringify(this.lessons)),
      placeholder: "No lesson in the collection!"
    }
  },
  methods   : {
    updateSelection(value){
      console.log('update value is, ', value);
    },
    updateLessons(){
      axios.post(this.urls.lessons(this.collection.id), this.selected)
           .then(() => window.location.href = '/admin/collections/' + this.collection.id + "/lessons")
           .catch(res => console.log(res))
    }
  }

}
</script>
<style></style>