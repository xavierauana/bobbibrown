<template lang="html">
    <form class="form">
		<div class="form-group">
			<label>Permissions</label>
			<v-select :value.sync="selected"
                      :options="options"
                      label="label"
                      multiple
                      :placeholder="placeholder"
                      :on-change="updateSelection"></v-select>
		</div>
		<div class="form-group">
			<button class="btn btn-success btn-block" @click.prevent="updatePermissions">Update Permissions</button>
		</div>
	</form>

</template>

<script type="text/babel">
import {Roles as urls} from "../endpoints"
import VSelect from "vue-select"
export default{
  components: {
    VSelect
  },
  props     : {
    role               : {
      type    : Object,
      required: true
    },
    permissions        : {
      type    : Array,
      required: true
    },
    selectedPermissions: {
      type    : Array,
      required: true
    },
  },
  data(){
    return {
      urls       : urls,
      selected   : JSON.parse(JSON.stringify(this.selectedPermissions)),
      options    : JSON.parse(JSON.stringify(this.permissions)),
      placeholder: "No permission in the role!"
    }
  },
  methods   : {
    updateSelection(value){
      console.log('update value is, ', value);
    },
    updatePermissions(){
      axios.post(this.urls.permissions(this.role.id), this.selected)
           .then(() => window.location.href = '/admin/roles/')
           .catch(res => console.log(res))
    }
  }

}
</script>
<style></style>