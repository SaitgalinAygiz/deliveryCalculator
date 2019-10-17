let actions = {
    createResult({commit}, result) {
        axios.post('/api/calculate/', result)
            .then(res => {
                commit('CREATE_RESULT', res.data[0])
            }).catch(err => {
            console.log(err)
        })
    },
    fetchResult({commit}) {
        commit('FETCH_RESULT');

    }
};

export default actions
