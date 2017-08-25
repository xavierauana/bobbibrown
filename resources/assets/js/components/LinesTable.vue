<template lang="html">
    <table class="table">
       <thead>
            <th>Name</th>
            <th>Actions</th>
       </thead>
       <tbody>
               <tr v-for="(line, index) in lines">
                   <td v-text="line.name"></td>
                    <td>
                        <a :href="urls.edit(line.id)" class="btn btn-sm btn-info">Edit</a>
                        <button class="btn btn-sm btn-danger" @click.prevent="deleteLine(index)">Delete</button>
                    </td>
               </tr>
       </tbody>
   </table>
</template>

<script type="text/babel">
    import {Lines as urls} from "../endpoints"

    export default {
      props  : {
        initialLines: {
          type    : Array,
          required: true
        }
      },
      data() {
        return {
          urls      : urls,
          lines: JSON.parse(JSON.stringify(this.initialLines))
        }
      },
      methods: {
        deleteLine(index) {
          let line = this.lines[index],
              url      = this.urls.delete(line.id)
          if (confirm('going to delete' + line.name)) {
            axios.delete(url)
                 .then(response => this.lines.splice(index, 1))
                 .catch(response => console.log(response))
          }

        }
      }
    }
</script>
<style></style>