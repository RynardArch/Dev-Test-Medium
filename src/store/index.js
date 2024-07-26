// src/store/index.js
import Vue from "vue";
import Vuex from "vuex";
import axios from "axios";

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        cars: [],
    },
    mutations: {
        setCars(state, cars) {
            state.cars = cars;
        },
        removeCar(state, id) {
            state.cars = state.cars.filter((car) => car.id !== id);
        },
    },
    actions: {
        async fetchCars({ commit }) {
            const response = await axios.get("/api/cars");
            commit("setCars", response.data);
        },
        async deleteCar({ commit }, id) {
            await axios.delete(`/api/cars/${id}`);
            commit("removeCar", id);
        },
    },
});
