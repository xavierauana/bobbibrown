<template lang="html">
    <form class="form">
		<div class="form-group">
			<label>Lessons</label>
			<v-select v-if="selected && options"
                      :value.sync="selected"
                      :options="options"
                      label="title"
                      multiple
                      :placeholder="placeholder"
                      :on-change="updateSelection"></v-select>
		</div>
		<div class="form-group">
			<button class="btn btn-success btn-block"
                    @click.prevent="updateLessons">Update Lessons</button>
		</div>
	</form>

</template>

<script type="text/babel">
import {Collections as urls} from "../endpoints"
import VSelect from "vue-select"

export default {
  components: {
    VSelect
  },
  props     : ['collectionId'],
  data() {
    return {
      urls       : urls,
      selected   : null,
      options    : null,
      placeholder: "No lesson in the collection!"
    }
  },
  created() {
    axios.get(window.location.href + "?ajax=true")
         .then(({data}) => {
           this.options = data.lessons
           this.selected = data.collection.lessons
         })
  },
  methods   : {
    updateSelection(value) {
      console.log('update value is, ', value);
      console.log('this selected, ', this.selected);
    },
    updateLessons() {
      axios.post(this.urls.lessons(this.collectionId), this.selected)
           .then(() => window.location.href = '/admin/collections/' + this.collectionId + "/lessons")
           .catch(res => console.log(res))
    }
  }

}
</script>
<style></style>