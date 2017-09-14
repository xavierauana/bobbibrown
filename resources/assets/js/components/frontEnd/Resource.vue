<template lang="html">
    <div class="resources">
        <input v-model="filterString" class="form-control"
               :placeholder="__('Filter By') + '...'">
        <br>
        <div v-for="category in filteredCategories" class="panel-group"
             id="accordion" role="tablist" aria-multiselectable="true">
          <div class="panel panel-default">
            <div class="panel-heading" role="tab" :id="'heading_'+category.id">
              <h4 class="category panel-title">
                <a role="button" data-toggle="collapse" data-parent="#accordion"
                   :href="'#collapse'+category.id" aria-expanded="false"
                   :aria-controls="'collapse'+category.id"
                   v-text="category.name">
                </a>
              </h4>
            </div>
            <div :id="'collapse'+category.id" class="panel-collapse collapse"
                 role="tabpanel" :saria-labelledby="'heading_'+category.id">
              <div class="panel-body">
                <list-group v-for="line in category.lines" :key="line.id"
                            :line="line"></list-group>
              </div>
            </div>
          </div>
        </div>
    </div>
</template>

<script type="text/babel">
    import ListGroup from "./components/LineAndProductList.vue"

    export default {
      name      : "resources",
      components: {
        ListGroup
      },
      props     : {
        initialCategories: {
          type    : Array,
          required: true
        }
      },
      data() {
        return {
          categories    : JSON.parse(JSON.stringify(this.initialCategories)).map(category => category.isHidden = false),
          filterString  : "",
          hideCategoryId: null,
          hideLineId    : null,
        }
      },
      computed  : {
        filteredCategories() {
          let copy = JSON.parse(JSON.stringify(this.initialCategories))
          if (this.filterString.length) {
            this.showAllProducts()
            return copy.map(category => {
              category.lines = category.lines.map(line => {
                line.products = line.products.filter(product => {
                  let newKeywords = product.name + " " + product.keywords
                  return newKeywords.toLowerCase().indexOf(this.filterString.toLowerCase()) > -1
                })
                return line
              })
              return category
            })
          } else {
            return copy
          }
        }
      },
      methods   : {
        showAllProducts() {
          let els = document.getElementsByClassName('collapse')
          for (let dom of els) {
            if (dom.getAttribute('id') != "app-navbar-collapse") {
              $(dom).collapse('show')
            }
          }
        },
        toggleCategory(category) {
          this.hideCategoryId = this.hideCategoryId != category.id ? category.id : null
        },
        toggleLine(line) {
          this.hideLineId = this.hideLineId != line.id ? line.id : null
        }
      }
    }
</script>
<style>
    .resources h4.panel-title.category {
        font-size: 1.5em;
        font-weight: bold;
    }

    .categories .lines {
        font-size: 1em;
        font-weight: normal;
        padding-left: 10px;
    }

    .categories .lines .products {
        font-size: 0.8em;
        font-weight: normal;
        padding-left: 10px;
    }

    .categories .lines .products a {
        display: block;
    }
</style>