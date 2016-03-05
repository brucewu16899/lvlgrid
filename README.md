# lvlGrid

<a href="https://github.com/marcosrjjunior/lvlgrid/"><img src="https://cloud.githubusercontent.com/assets/5287262/13515471/50e314fe-e190-11e5-85fb-3bf3cf9b6129.jpg" alt="lvlgrid"></a>

## Documentation
 * [Installation](#installation) 
 * [Getting started](#getting-started) 
 * [Get Data](#get-data) 
 * [Transformer](#transformer) 

___
#### Dependencies  

```js  
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.16/vue.js"></script>
```  
  
#### Installation

First, pull in the package through Composer.

```
composer require mrjj/lvlgrid
```

And then include the service provider within `app/config/app.php`.

```php
'providers' => [
    Mrjj\LvlGrid\LvlGridServiceProvider::class
];
```

#### Getting started

First, create add a route to grid method

```php
Route::get('countries/grid', '....Controller@grid');
```  

Use a trait and add a required informations in your controller

```php  
use Mrjj\LvlGrid\LvlGrid;

class ..Controller extends Controller
{
    use LvlGrid

    protected $gridModel = \App\Models\Country::class;

    protected $threshold = 30;  
    ...
}

```

Finally, add this @includes and set your options in your view.

```php  
@extend('default')

@section('scripts')
    ...
    <script>
        var columns = [
            {
                'key': 'name',
                'name': 'Name'
            },
            {
                'key': 'monetary',
                'name': 'Monetary unit'
            },  
        ],

        gridOptions = {
            columns: columns,
            routes: {
                function: '/countries/grid', // ..Controller@grid();
                edit: {
                    column: 'id',
                    name: '/countries/:column/edit' 
                },
                delete: {
                    column: 'id',
                    name: '/countries/:column/delete'
                },
            }
        };
    </script>

    @include('lvlgrid::scripts')
    ...
@stop

@section('content')
    <h3>lvlGrid</h3>

    @include('lvlgrid::grid')  
    ..
```  

#### Get Data
Add a gridData() method if you want to customize your query

```php
public function gridData()
{
    return DB::table('users')
            ->leftJoin('posts', 'users.id', '=', 'posts.user_id')
}
```
> @return \Illuminate\Database\Query\Builder

#### Transformer

To transform your data you need add a gridTransformer() method and modify what you want
```php  
public function gridTransformer($data)
{
    foreach($data['items'] as $_grid) {
        $_grid->status = trans('form.status.'.$_grid->status);
    }
 }
```
> In this example I'm changing the status for a friendly name like 'Active' and 'Inactive'  

If you need to modify the views, you can run:

```bash
php artisan vendor:publish --provider="Mrjj\LvlGrid\LvlGridServiceProvider"
```

The package views will now be located in the `app/resources/views/vendor/mrjj/lvlgrid`
