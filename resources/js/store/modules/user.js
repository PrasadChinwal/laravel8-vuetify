// initial state
const state = {
    users: [],
    pagination: {
        rowsPerPage: 5,
        page: 1,
    },
    totalItems: 0,
}

// getters
const getters = {

}

// actions
const actions = {
    getCustomers (context,page){
        let page_number = page.page || this.state.pagination.page;
        let rowsPerPage = page.rowsPerPage || this.state.pagination.rowsPerPage;
        axios.get('/api/user?page=' + page_number + '&rowsPerPage=' + rowsPerPage)
        .then((response) => {
            console.log(response);
            context.commit('updateUsers', response.data);
        });
       },
}

// mutations
const mutations = {
    updateUsers(state,payload) {
        state.users = payload.data;
        state.pagination.page = payload.current_page;
        state.pagination.rowsPerPage = payload.per_page;
        state.totalItems = payload.total;
      },
}

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}