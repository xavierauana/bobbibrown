<template lang="html">
    <table class="table">
       <thead>
            <th>Title</th>
            <th>Actions</th>
       </thead>
       <tbody>
               <tr v-for="(test, index) in tests">
                   <td v-text="test.title"></td>
                    <td>
                        <a :href="question_urls.index(test.id)" class="btn btn-sm btn-default">Questions</a>
                        <a :href="urls.edit(test.id)" class="btn btn-sm btn-info">Edit</a>
                        <button class="btn btn-sm btn-danger" @click.prevent="deleteTest(index)">Delete</button>
                    </td>
               </tr>
       </tbody>
   </table>
</template>

<script type="text/babel">
    import {Tests as urls, Questions} from "../endpoints"
    export default{
      props  : {
        initialTests: {
          type    : Array,
          required: true
        }
      },
      data() {
        return {
          urls         : urls,
          question_urls: Questions,
          tests        : JSON.parse(JSON.stringify(this.initialTests))
        }
      },
      methods: {
        deleteTest(index){
          let test = this.tests[index],
              url  = this.urls.delete(test.id)
          if (confirm('going to delete' + test.title)) {
            axios.delete(url)
                 .then(response => this.tests.splice(index, 1))
                 .catch(response => console.log(response))
          }

        }
      }
    }
</script>
<style></style>