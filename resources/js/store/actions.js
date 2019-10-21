let actions = {
    createResult({commit}, result) {
        axios.post('/api/calculate/', result)
            .then(res => {
                commit('CREATE_RESULT', res);
            }).catch(err => {
            console.log(err)
        })
    },
    fetchResult({commit}) {
        commit('FETCH_RESULT');

    }
};

export default actions
