const mutations = {
    CREATE_RESULT(state, result) {
        state.results = [];
        let num = result.data.length;
        console.log(num);

        for (let i = 0; i < num; i++) {
            state.results.unshift(result.data[i]);
        }

    },
    FETCH_RESULT(state) {
        return state.results
    }
};
export default mutations
