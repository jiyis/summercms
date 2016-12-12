<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\MenuItem;

class MenuController extends Controller
{
    public function builder($id)
    {
        $menu = Menu::find($id);

        return view('admin.menus.builder', compact('menu'));
    }

    public function delete_menu($id)
    {
        $item = MenuItem::find($id);
        $menuId = $item->menu_id;
        $item->destroy($id);

        return redirect()
            ->route('admin.menu.builder', [$menuId])
            ->with([
                'message'    => '删除菜单成功.',
                'alert-type' => 'success',
            ]);
    }

    public function add_item(Request $request)
    {
        $data = $request->all();
        $highestOrderMenuItem = MenuItem::where('parent_id', '=', null)
            ->orderBy('order', 'DESC')
            ->first();

        $data['order'] = isset($highestOrderMenuItem->id)
            ? intval($highestOrderMenuItem->order) + 1
            : 1;

        MenuItem::create($data);

        return redirect()
            ->route('admin.menu.builder', [$data['menu_id']])
            ->with([
                'message'    => '新建菜单成功.',
                'alert-type' => 'success',
            ]);
    }

    public function update_item(Request $request)
    {
        $id = $request->input('id');
        $data = $request->except(['id']);
        $menuItem = MenuItem::find($id);
        $menuItem->update($data);

        return redirect()
            ->route('admin.menu.builder', [$menuItem->menu_id])
            ->with([
                'message'    => '更新菜单成功.',
                'alert-type' => 'success',
            ]);
    }

    public function order_item(Request $request)
    {
        $menuItemOrder = json_decode($request->input('order'));

        $this->orderMenu($menuItemOrder, null);
    }

    private function orderMenu(array $menuItems, $parentId)
    {
        foreach ($menuItems as $index => $menuItem) {
            $item = MenuItem::find($menuItem->id);
            $item->order = $index + 1;
            $item->parent_id = $parentId;
            $item->save();

            if (isset($menuItem->children)) {
                $this->orderMenu($menuItem->children, $item->id);
            }
        }
    }
}
