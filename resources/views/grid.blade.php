<template id="filter-template">
    <div class="row">
        <div class="col-md-3 form-group pull-right">
            <input type="text" class="form-control" id="search-field" placeholder="Search.."
                v-model="search"
                @keyUp="setFilter | debounce 400">
        </div>
        <div class="col-md-2 form-group pull-right">
            <select class="form-control" v-model="column">
                <option value="@{{column.key}}"
                    v-for="column in $parent.columns"
                >
                    @{{column.name}}
                </option>
            </select>
        </div>
    </div>
</template>

<template id="lvlgrid-template">
    <div>
        <filters></filters>
        <table class="data-grid table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th v-for="column in columns"
                        @click="sortBy(column.key)"
                        :class="{active: sortKey == column.key}">
                        @{{column.name | capitalize}}
                        <span class="glyphicon"
                            v-show="sortKey == column.key"
                            :class="sortOrders[column.key] > 0 ? 'glyphicon-chevron-up' : 'glyphicon-chevron-down'">
                        </span>
                    </th>
                    <th></th>
                </tr>
            </thead>

            <tbody>
                <tr v-for="
                    entry in data">
                    <td v-for="column in columns">
                        <a href="@{{routes.edit.name.replace(':column', entry[routes.edit.column])}}"
                            v-if="$index == 0"
                        >@{{entry[column.key]}}</a>
                        <span v-else>@{{entry[column.key]}}</span>
                    </td>
                    <td class="actions">
                        <a class="btn btn-link" href="@{{routes.delete.name.replace(':column', entry[routes.delete.column])}}">
                            <span class="glyphicon glyphicon-remove"></span>
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>

        <nav>
            <ul class="pagination pull-right">
                <li v-if="pagination.page != 0">
                    <a href="#" aria-label="Previous" @click="pagination.page--, grid()">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                <li v-else>
                    <a href="#" aria-label="Previous" disabled>
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                <li v-for="page in pagination.pagesCount+1" :class="{'active': pagination.page == $index}">
                    <a href="#" @click="pagination.page = $index, grid()">@{{ $index + 1 }}</a>
                </li>
                <li v-if="pagination.pagesCount != pagination.page">
                    <a href="#" aria-label="Next" @click="pagination.page++, grid()">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
                <li v-else>
                    <a href="#" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</template>

<style>
.actions {
    width: 55px;
}
.actions .btn {
    padding: 0 10px;
}
.pagination {
    margin: 10px 0;
}
</style>