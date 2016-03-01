# lvlGrid

## Documentation
 * [Installation](#installation) 
 * [Getting started](#getting-started) 
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

`composer require mrjj/lvlgrid`

And then include the service provider within `app/config/app.php`.

```php
'providers' => [
    Mrjj\LvlGrid\LvlGridServiceProvider::class
];
```

#### Getting started

First, create add a route to grid method

```php
Route::get('stages/grid', '....Controller@grid');
```  

Use a trait and add a required informations in your controller

```php  
use Mrjj\LvlGrid\LvlGrid;

class ..Controller extends Controller
{
    use LvlGrid

    protected $gridModel = \App\Models\Course::class;

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
                'key': 'title',
                'name': 'Title'
            },
            {
                'key': 'status',
                'name': 'Status'
            },
        ],

        gridOptions = {
            columns: columns,
            routes: {
                function: '/stages/grid', // ..Controller@grid();
                edit: {
                    column: 'id',
                    name: '/stages/:column/edit' 
                },
                delete: {
                    column: 'id',
                    name: '/stages/:column/delete'
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