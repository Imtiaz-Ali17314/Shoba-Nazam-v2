import { defineStore } from 'pinia';

export const useMadrasaStore = defineStore('madrasa', {
    state: () => ({
        currentMadrasa: null,
        madrasas: [],
    }),
    actions: {
        setCurrentMadrasa(madrasa) {
            this.currentMadrasa = madrasa;
        },
        setMadrasas(list) {
            this.madrasas = list;
        },
    },
});