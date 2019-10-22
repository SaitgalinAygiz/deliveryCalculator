const mutations = {
    CREATE_RESULT(state, result) {
        state.results = [];

        if(result.data === 'no results') {
            alert('Нет результатов! Обратите внимание на написание городов');
        } else {
            let num = result.data.length;
            for (let i = 0; i < num; i++) {
                state.results.unshift(result.data[i]);
            }
        }



    },
    FETCH_RESULT(state) {
        return state.results
    }
};
export default mutations
