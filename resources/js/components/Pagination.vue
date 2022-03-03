<template>
    <div>
        <ul v-if="pagination.last_page === 1" class="pagination">
            <li class="page-item disabled">
                <a class="page-link" href="javascript:void(0)" tabindex="-1" aria-disabled="true">Previous</a>
            </li>
            <li class="page-item active">
                <a class="page-link"
                   href="javascript:void(0)">1
                </a>
            </li>
            <li class="page-item disabled">
                <a class="page-link" href="javascript:void(0)" tabindex="-1" aria-disabled="true">Next</a>
            </li>
        </ul>
        <ul v-if="pagination.last_page === 2" class="pagination">
            <template v-if="parseInt(pagination.page) === 1">
                <li class="page-item disabled">
                    <a class="page-link" href="javascript:void(0)" tabindex="-1" aria-disabled="true">Previous</a>
                </li>
                <li class="page-item active">
                    <a @click="loadPaginated(1)" href="javascript:void(0)" class="page-link">1</a>
                </li>
                <li class="page-item">
                    <a @click="loadPaginated(2)" href="javascript:void(0)" class="page-link">2</a>
                </li>
                <li class="page-item">
                    <a @click="loadPaginated(pagination.next_page)" href="javascript:void(0)" class="page-link">Next</a>
                </li>
            </template>
            <template v-else>
                <li class="page-item">
                    <a @click="loadPaginated(pagination.previous_page)" href="javascript:void(0)" class="page-link">Previous</a>
                </li>
                <li class="page-item">
                    <a @click="loadPaginated(1)" href="javascript:void(0)" class="page-link">1</a>
                </li>
                <li class="page-item active">
                    <a @click="loadPaginated(2)" href="javascript:void(0)" class="page-link">2</a>
                </li>
                <li class="page-item disabled">
                    <a class="page-link" href="javascript:void(0)" tabindex="-1" aria-disabled="true">Next</a>
                </li>
            </template>
        </ul>
        <ul v-if="pagination.last_page >= 3" class="pagination">
            <li :class="(pagination.previous_page === null) ? 'page-item disabled' : 'page-item'">
                <a @click="loadPaginated(pagination.previous_page)" href="javascript:void(0)" class="page-link">Previous</a>
            </li>
            <li :class="(parseInt(pagination.page) === 1) ? 'page-item active' : 'page-item'">
                <a @click="loadPaginated(1)" href="javascript:void(0)" class="page-link">1</a>
            </li>
            <li :class="(parseInt(pagination.page) === 2) ? 'page-item active' : 'page-item'">
                <a @click="loadPaginated(2)" href="javascript:void(0)" class="page-link">2</a>
            </li>
            <template v-if="pagination.last_page === 3">
                <li :class="(parseInt(pagination.page) === 3) ? 'page-item active' : 'page-item'">
                    <a @click="loadPaginated(3)" href="javascript:void(0)" class="page-link">3</a>
                </li>
            </template>
            <template v-if="pagination.last_page > 3">
                <li v-if="parseInt(pagination.page) - 2 >= 2" class="page-item disabled">
                    <a class="page-link" href="javascript:void(0)" tabindex="-1" aria-disabled="true">...</a>
                </li>
                <li v-if="parseInt(pagination.page) > 2 && pagination.last_page !== parseInt(pagination.page)" class="page-item active">
                    <a @click="loadPaginated(parseInt(pagination.page))" href="javascript:void(0)" class="page-link">
                        {{ parseInt(pagination.page) }}
                    </a>
                </li>
                <li v-if="pagination.last_page - parseInt(pagination.page) >= 2" class="page-item disabled">
                    <a class="page-link" href="javascript:void(0)" tabindex="-1" aria-disabled="true">...</a>
                </li>
                <li :class="(pagination.last_page === parseInt(pagination.page)) ? 'page-item active' : 'page-item'">
                    <a @click="loadPaginated(pagination.last_page)" href="javascript:void(0)" class="page-link">
                        {{ pagination.last_page }}
                    </a>
                </li>
            </template>
            <li :class="(parseInt(pagination.page) === pagination.last_page) ? 'page-item disabled' : 'page-item'">
                <a @click="loadPaginated(pagination.next_page)" href="javascript:void(0)" class="page-link">Next</a>
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    name: "Pagination",
    props: ['pagination'],
    methods: {
        loadPaginated: function (page) {
            this.$emit('loadPaginatedData', page );
        }
    }
}
</script>

<style scoped>

</style>
