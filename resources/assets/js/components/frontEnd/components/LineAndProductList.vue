<template lang="html">

    <div class="panel-group" role="tablist">
        <div class="panel panel-default">
            <div class="panel-heading" role="tab"
                 :id="listGroupId + 'Heading1'">
                <h4 class="panel-title">
                    <a :href="'#'+listGroupId"
                       class="collapsed"
                       role="button" data-toggle="collapse"
                       aria-expanded="false"
                       aria-controls="collapseListGroup1"> {{line.name}} </a>
                </h4>
            </div>
            <div class="panel-collapse collapse" role="tabpanel"
                 :id="listGroupId"
                 aria-labelledby="collapseListGroupHeading1"
                 aria-expanded="false"
                 style="height: 0px;">
                <ul class="list-group">
                    <li class="list-group-item"
                        v-for="product in line.products"><a
                            :href="'/products/'+product.id">{{product.name}}</a></li>
                </ul>
            </div>
        </div>
    </div>

</template>

<script type="text/babel">
    export default {
      props   : {
        line : {
          type    : Object,
          required: true
        },
        shown: {
          type   : Boolean,
          default: true
        }
      },
      computed: {
        listGroupId() {
          return "list_group_" + this.line.id
        }
      }
    }
</script>
<style scoped>
    li a {
        color: gray
    }
</style>