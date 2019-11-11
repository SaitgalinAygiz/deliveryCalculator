let actions = {
    createResult({commit}, result) {


        axios.post('/api/calculate', result)
            .then(res => {
                    commit('CREATE_RESULT', res);
            }).catch(err => {
            console.log(err)
        });
        axios.post('/api/coordinates', result)
            .then(res => {
                    commit('CREATE_COORDS', res);
            }).catch(err => {
                console.log(err)
        })
    },

    createTrackingResult({commit}, tracking){

        axios.post('/api/tracking', tracking)
            .then(res => {
                commit('CREATE_TRACKING_RESULT', res);
            }).catch(err => {
                console.log(err)
        });
    },
    fetchResult({commit}) {
        commit('FETCH_RESULT');
    },
    fetchCoords({commit}) {
        commit('FETCH_COORDS');
    },
    fetchTrackingResult({commit}) {
        commit('FETCH_TRACKING_RESULT');
    }
};

export default actions
