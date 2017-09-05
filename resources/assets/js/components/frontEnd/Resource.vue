<template lang="html">
    <div class="resources">
        <input v-model="filterString" class="form-control" :placeholder="__('Filter By') + '...'">
        <ul class="list-unstyled categories">
            <li v-for="category in filteredCategories">
                <span @click.prevent="toggleCategory(category)">{{category.name}}</span>
                <ul class="list-unstyled lines" v-if=" category.lines && category.lines.length"
                    v-show="category.id != hideCategoryId">
                    <li v-for="line in category.lines">
                         <span @click.prevent="toggleLine(line)">{{line.name}}</span>
                        <ul class="list-unstyled products" v-if="line.products && line.products.length"
                            v-show="line.id != hideLineId">
                            <a v-for="product in line.products" :href="'/products/'+product.id">{{product.name}}</a>
                        </ul>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</template>

<script type="text/babel">
    export default {
      name    : "resources",
      props   : {
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
      computed: {
        filteredCategories() {
          let copy = JSON.parse(JSON.stringify(this.initialCategories))
          if (this.filterString.length) {
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
      methods : {
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
    .categories {
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