<script type="text/javascript">
var Filter = Vue.component('filter-component', {
    template: '#filter-template',
    props: {
        data: Array
    },

    data: function () {
        return {
            search: '',
            column: '',
            filters: []
        }
    },

    watch: {
        search: function (val, oldVal) {
            this.$parent.search = this.search;
        },

        column: function (val, oldVal) {
            this.$parent.columnSearch = this.column;
        },
    },

    methods: {
        setFilter: function() {
            this.$parent.grid();
        }
    },
    created: function () {
        this.$parent.filterComponent = this;
    },
})

Vue.component('lvlgrid', {
    template: '#lvlgrid-template',
    props: {
        data: Array,
        columns: Array,
        routes: Object,
    },

    data: function () {
        var sortOrders = {};

        this.columns.forEach(function (column) {
            sortOrders[column.key] = 1
        });

        return {
            filterComponent: [],
            sortKey: '',
            sortOrders: sortOrders,
            sort: '',
            direction:  '',
            search: '',
            columnSearch: !this.columnSearch ? this.columns[0].key : '',
            pagination: {
                page: 0,
                pagesCount: 0,
            },
        }
    },

    components: {
        filters: Filter,
    },

    methods: {
        sortBy: function (key) {
            this.sortKey = key;
            this.sortOrders[key] = this.sortOrders[key] * -1;

            this.sort = key;
            this.direction = this.sortOrders[key] == -1 ? 'asc': 'desc';

            this.pagination.page = 0;
            this.grid();
        },

        grid: function() {
            $.ajax({
                type: "GET",
                url: this.routes.function,
                data: {
                    search: this.search,
                    columnSearch: this.columnSearch,
                    sort: this.sort,
                    direction: this.direction,
                    page: this.pagination.page
                },
            }).done(function(data) {
                this.$parent.items = data.items;
                this.pagination.pagesCount = data.pagesCount -1;
            }.bind(this));
        }
    },

    ready: function () {
        this.grid();
    }
})

var lvlgrid = new Vue({
    el: '#lvlgrid',
    data: {
        searchQuery: '',
        items: []
    }
})
</script>