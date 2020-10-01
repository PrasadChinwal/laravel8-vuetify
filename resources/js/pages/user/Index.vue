<template>
    <div class="max-w-7xl p-8 mx-auto">
        <v-card raised>
            <v-card-title>
                <div class="flex items-center justify-center">
                    <span class="text-4xl font-semibold">Users</span>
                    <v-spacer></v-spacer>
                    <v-text-field v-model="search" placeholder="Search" append-icon="mdi-search"></v-text-field>
                </div>
            </v-card-title>
            <v-card-text>
                <!-- :pagination.sync="pagination" -->
                <v-data-table :headers="headers" :items="users" :items-per-page="itemsPerPage"
                     :options.sync="options" :server-items-length="total" hide-default-footer
                >
                    <template v-slot:item.profile_photo_url="{ item }">
                        <v-avatar size="48">
                            <v-img :src="item.profile_photo_url"></v-img>
                        </v-avatar>
                    </template>
                </v-data-table>
                <v-pagination
                    color="success"
                    v-model="options.page"
                    :length="last_page"
                    :total-visible="5"
                    @input="onPageChange"
                ></v-pagination>
            </v-card-text>
        </v-card>
    </div>
</template>

<script>
import { mapGetters } from 'vuex';

export default {
    data() {
        return {
            isLoading: false,
            users:[],
            last_page: 0,
            total: 0,
            itemsPerPage: 5,
            options: {
                itemsPerPage: 5,
                multiSort: true,
            },
            search: '',
            headers: [
                {text: 'Name', value: 'name', sortable: true},
                {text: 'Email', value: 'email', sortable: true},
                {text: 'Email Verified At', value: 'email_verified_at', sortable: true},
                {text: 'Current Team ID', value: 'current_team_id', sortable: true},
            ],
        }
    },
    mounted() {
        this.fetchUsers();
    },
    watch: {
        search(search) {
            if(search.length === 0) {
                this.fetchUsers();
            }
            if(!this.isLoading && search.length > 3) {
                setTimeout(() => {
                    this.fetchUsers();
                    this.isLoading = false;
                }, 3000); // 1 sec delay
            }
        },
        options: {
            handler () {
                this.fetchUsers()
            },
            deep: true,
        },
    },
    methods: {
        fetchUsers: function() {
            this.isLoading = true;
            let apiEndpoint = '/api/user/?rowsPerPage=' + this.itemsPerPage + '&page=' + this.options.page;

            if(this.search.length > 3) {
                apiEndpoint = apiEndpoint + '&search=' + this.search;
            }

            if(this.options.sortBy.length >= 1 && this.options.sortDesc.length >= 1) {
                apiEndpoint = apiEndpoint + '&sortBy=' + this.options.sortBy + '&sortDesc=' + this.options.sortDesc;
            }

            axios.get(apiEndpoint)
            .then((response) => {
                this.users = response.data.data;
                this.options.page = response.data.current_page;
                this.total = response.data.total;
                this.last_page = response.data.last_page;
                this.itemsPerPage = response.data.per_page;
            }).catch(error => {
                console.log(error);
            }).finally(this.isLoading = false);
        },
        onPageChange() {
            this.fetchUsers();
        }
    }
}
</script>

<style scoped>

</style>