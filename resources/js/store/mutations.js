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
    CREATE_COORDS(state, coord) {
        state.coord = [];
        state.coord.unshift(coord.data);
    },
    CREATE_TRACKING_RESULT(state, trackingResult){
        state.trackingResults = [];

        if (trackingResult.data === 'no results') {
            alert('Нет результатов! Обратите внимание на номер отслеживания');
        } else {
            console.log(trackingResult.data);
        }


    },
    FETCH_COORDS(state) {
        console.log(state.coord);
        return state.coord
    },
    FETCH_RESULT(state) {
        return state.results
    }
};
export default mutations
