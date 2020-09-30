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
                     :options="options" :server-items-length="total"
                >
                    <template v-slot:item.profile_photo_url="{ item }">
                        <v-avatar size="48">
                            <v-img :src="item.profile_photo_url"></v-img>
                        </v-avatar>
                    </template>
                </v-data-table>
                <v-pagination
                    v-model="page"
                    :length="last_page"
                    :total-visible="5"
                    circle
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
            page: 1,
            last_page: 0,
            total: 0,
            itemsPerPage: 5,
            pagination: {
                current: 1,
                total: 0
            },
            options: {
                page: 1,
                itemsPerPage: 5,
            },
            search: '',
            headers: [
                {text: 'Name', value: 'name', sortable: true},
                {text: 'Email', value: 'email', sortable: true},
                {text: 'Email Verified At', value: 'email_verified_at', sortable: true},
                {text: 'Current Team ID', value: 'current_team_id', sortable: true},
                {text: 'Profile Photo', value: 'profile_photo_url', sortable: true},
            ],
        }
    },
    mounted() {
        this.fetchUsers();
    },
    methods: {
        fetchUsers: function() {
            axios.get('/api/user/?rowsPerPage=' + this.itemsPerPage +'&page=' + this.page + '&search=' + this.search)
            .then((response) => {
                this.users = response.data.data;
                this.page = response.data.current_page;
                this.total = response.data.total;
                this.last_page = response.data.last_page;
                this.itemsPerPage = response.data.per_page;
            }).catch(error => {
                console.log(error);
            })
        },
        onPageChange() {
            this.fetchUsers();
        }
    }
}
</script>

<style scoped>

</style>