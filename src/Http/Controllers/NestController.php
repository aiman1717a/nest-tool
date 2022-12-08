<?php

namespace Aiman\NestTool\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Laravel\Nova\Http\Requests\NovaRequest;

class NestController extends Controller
{
    protected $model;
    protected $parent_column;
    protected $order_column;
    protected $display_name;

    public function items(NovaRequest $request)
    {
        $model = $request->input('model');
        $this->parent_column = $request->input('parent_column');
        $this->order_column = $request->input('order_column');
        $this->display_name = $request->input('display_name');
        $this->model = app($model);

        return $this->model->with(['children'])->whereNull('parent_id')
            ->orderby($this->order_column)
            ->get();
    }

    public function saveItems(Request $request)
    {
        $model = $request->input('model');
        $this->parent_column = $request->input('parent_column');
        $this->order_column = $request->input('order_column');
        $this->display_name = $request->input('display_name');
        $items = $request->get('menus');
        $this->model = app($model);
        $order = 1;
        foreach ($items as $item) {
            $this->saveNestItem($order, $item);
            $order++;
        }

        return response()->json([
            'success' => true,
        ]);
    }

    private function saveNestItem($order, $item, $parentId = null)
    {

        $this->model->where('id', $item['id'])->update([
            $this->order_column => $order,
            $this->parent_column => $parentId,
        ]);

        $this->checkChildren($item);
    }

    private function checkChildren($item)
    {
        if (count($item['children']) > 0) {
            $order = 1;
            foreach ($item['children'] as $child) {
                $this->saveNestItem($order, $child, $item['id']);
                $order++;
            }
        }
    }
}
