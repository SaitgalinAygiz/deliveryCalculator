const mutations = {
    CREATE_RESULT(state, result) {
        state.results.splice(0, state.results.length);
        state.results.unshift(result)
    },
    FETCH_RESULT(state) {
        return state.results
    }
};
export default mutations
