/**
 * Created by Xavier on 12/5/2017.
 */
import Vue from "vue"
import Question from './Question'
export default
Vue.extend({
             props: {
               result        : {
                 require: true
               },
               index         : {
                 type   : String,
                 default: 1
               },
               onAnswerChange: {
                 type    : Function,
                 required: true
               },
               question      : {
                 type    : Question,
                 required: true
               },
               disabled      : {
                 type    : Boolean,
                 required: false
               }
             },
             data () {
               return {
                 answer: ''
               }
             }
           })
