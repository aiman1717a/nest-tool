# Nest Tool
This Nova Package allow you to nest items in hierarchy level.

![image](https://user-images.githubusercontent.com/36910126/84803777-4afa1200-afb7-11ea-9094-b1281a859cf1.png)

## Installation
```
composer require aiman/nest-tool
```
## Example Migration Schema
```
class CreateTopicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('topics', function (Blueprint $table) {
            $table->id();
            $table->text('topic');
            $table->text('slug')->nullable();
            $table->integer('order')->default(1);
            $table->integer('parent_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('topics');
    }
}
```

## Usage
In order to use the nest tool, it requires a model to use which includes a order column, parent column, amd the display name to be shown in each item. Example is shown above
```
use Aiman\ThaanaTextField\ThaanaTextField;

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),
            
            //other fields
            
            NestTool::make()
             ->usingModel(\App\Models\Topic::class)
             ->slug('slug')
             ->orderColumn('order')
             ->parentColumn('parent_id')
             ->displayName('topic')
             ->disable(false)
        ];
    }
```
## Relationship
the model which is entered into `usingModel()` function should have this relationship
```
function parent(){
    return $this->belongsTo('App\Models\Topic', 'parent_id');
}

function children(){
    return $this->hasMany(self::class, 'parent_id')->orderBy('order')->with('children');
}
```

### Model
This function requires the model in which nest tool uses
```
NestTool::make()->usingModel(\App\Models\Topic::class)
```

### Slug
This function requires the slug field to be displayed. By default it is `slug`
```
NestTool::make()->slug('slug')
```

### Order
This function requires the order column name in the model class above which is used for ordering. By default it is `order`
```
NestTool::make()->orderColumn('order')
```

### Parent Id
This function requires the parent column name in the model class above which is used for nesting items under a parent item. By default it is `parent_id`
```
NestTool::make()->parentColumn('parent_id')
```

### Topic
This function requires the display name's column name in the model class above which is used to display in each item. By default it is `topic`
```
NestTool::make()->displayName('topic')
```

## Important
This package is tested for **nova 2.0+**
Latest tested on **nova v3.6.0**
