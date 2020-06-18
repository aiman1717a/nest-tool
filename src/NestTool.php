<?php

namespace Aiman\NestTool;

use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\ResourceTool;
use Laravel\Nova\Tool;

class NestTool extends ResourceTool
{
    /**
     * Get the displayable name of the resource tool.
     *
     * @return string
     */
    public function name()
    {
        return 'Nest Tool';
    }

    /**
     * Get the component name for the resource tool.
     *
     * @return string
     */
    public function component()
    {
        return 'nest-tool';
    }
    public function disable($disable = false)
    {
        $this->withMeta(['disable' => $disable]);

        return $this;
    }
    public function slug($slug = 'slug')
    {
        $this->withMeta(['slug' => $slug]);
        return $this;
    }
    public function usingModel(string $model)
    {
        $this->withMeta(['model' => $model]);
        return $this;
    }

    public function orderColumn($column = 'order')
    {
        $this->withMeta(['order_column' => $column]);

        return $this;
    }
    public function parentColumn($column = 'parent_id')
    {
        $this->withMeta(['parent_column' => $column]);

        return $this;
    }

    public function displayName($field = 'topic')
    {
        $this->withMeta(['display_name' => $field]);

        return $this;
    }
}
