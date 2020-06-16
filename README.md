# Nest Tool
This Nova Package allow you to nest items in hierarchy level.

![image](https://user-images.githubusercontent.com/36910126/84803777-4afa1200-afb7-11ea-9094-b1281a859cf1.png)

## Installation
```
composer require aiman/nest-tool
```

## Usage
In order to use the nest tool, it requires a model to use, order column, parent column, amd the display name to be shown in each item
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

### Order
This function requires the order column name in the model class above which is used for ordering
```
NestTool::make()->orderColumn('order')
```

### Parent Id
This function requires the parent column name in the model class above which is used for nesting items under a parent item
```
NestTool::make()->parentColumn('order')
```

### Topic
This function requires the display name's column name in the model class above which is used to display in each item
```
NestTool::make()->displayName('topic')
```

## Important
This package is tested for **nova 2.0+**
Latest tested on **nova v3.6.0**

## Credit
Huge Credit goes for [@Jawish Hameed](https://github.com/jawish) for his thaana translation plugin [Thaana Keyboard](https://github.com/jawish/jtk)
