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

<template id="grid-template">
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
                        <a href="@{{options.routes.edit.name.replace(':column', entry[options.routes.edit.column])}}"
                            v-if="$index == 0"
                        >@{{entry[column.key]}}</a>
                        <span v-else>@{{entry[column.key]}}</span>
                    </td>
                    <td class="actions">
                        <a class="btn btn-link" href="@{{options.routes.delete.name.replace(':column', entry[options.routes.delete.column])}}">
                            <span class="glyphicon glyphicon-remove"></span>
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="btn-group pull-right" role="group" aria-label="Large button group">
            <a type="button" class="btn btn-default change-page" data-offset="0"
                v-on:click="pagination.page--, grid()"
                :disabled="pagination.page == 0"
            >
                <span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span>
            </a>

            <a type="button" class="btn btn-default change-page" data-offset="1"
                v-on:click="pagination.page++, grid()"
                :disabled="pagination.pagesCount == pagination.page"
            >
                <span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span>
            </a>
        </div>
    </div>
</template>

<div id="grid">
    <grid-component
        :data="items"
        :columns="columns">
    </grid-component>
</div>

<style>
.actions {
    width: 55px;
}
.actions .btn {
    padding: 0 10px;
}
</style>