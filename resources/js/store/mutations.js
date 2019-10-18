const mutations = {
    CREATE_RESULT(state, result) {
        state.results.unshift(result)
    },
    FETCH_RESULT(state) {
        return state.results
    }
};
export default mutations
