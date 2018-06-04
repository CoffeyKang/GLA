import Vue from 'vue';
import Vuex from 'vuex';
Vue.use(Vuex);

const searchModule = {
  state: {
    item: 'thisIsItem',
    desc: 'zheshidewc',
    make: 'make',
    year: 1970
  },
  mutations: {
    setItem(state, item) {
        state.item = item;
    },
    setDesc(state, desc) {
        state.desc = desc;
    },
    setMake(state, make) {
        state.make = make;
    },
    setYear(state, year) {
        state.year = year;
    }
  }
};

export const store = new Vuex.Store({
  modules: {
    search: searchModule
  }


});