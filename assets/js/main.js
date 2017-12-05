import '../css/style.scss';

import Vue from 'vue';
import store from './vuex/store';
import App from './vue/app.vue';

new Vue({
  store,
  el: '#main',
  components: { App }
});


//ES6 tests
/*

function countArguments(...args) {  
   return args.length;
}
// get the number of arguments
countArguments('welcome', 'to', 'Earth'); // => 3

// destructure an array
let otherSeasons, autumn;  
[autumn, ...otherSeasons] = ['autumn', 'winter', 'summer'];
console.log(otherSeasons);      // => ['winter']  


let cold = ['autumn', 'winter'];  
let warm = ['spring', 'summer'];  
// construct an array
console.log([...cold, ...warm]) // => ['autumn', 'winter', 'spring', 'summer']

// function arguments from an array
cold.push(...warm);  
console.log(cold);              // => ['autumn', 'winter', 'spring', 'summer']  

*/