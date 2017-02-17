<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Traits\RouteManage;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\MenuItem;

class MenuController extends BaseController
{
    use RouteManage;

    public function __construct()
    {
        parent::__construct();
    }

    public function index(Request $request)
    {
        $menus = Menu::all();
        return view('admin.menus.browse', compact('menus'));
    }

    public function show(Request $request, $id)
    {
        $menu = Menu::find($id);
        return view('admin.menus.browse', compact('menu'));
    }


    public function edit(Request $request, $id)
    {
        $menu = Menu::find($id);
        return view('admin.menus.browse', compact('menu'));
    }

    // POST BR(E)AD
    public function update(Request $request, $id)
    {
        if($request->get('default') == 1) Menu::where(['default' => 1])->update(['default' => 0]);
        $menu = Menu::find($id);
        $menu->name = $request->get('name');
        $menu->default = $request->get('default');
        $menu->save();

        return redirect(route('admin.menus.index'));

    }

    public function create(Request $request)
    {

    }

    // POST BRE(A)D
    public function store(Request $request)
    {
        if($request->get('default') == 1) Menu::where(['default' => 1])->update(['default' => 0]);
        $menu = new Menu($request->all());
        $menu->save();
        return redirect(route('admin.menus.index'));

    }


    public function destroy(Request $request, $id)
    {
        $menu = Menu::find($id)->delete();
        return redirect(route('admin.menus.index'))->with([
            'message'    => "删除菜单成功",
            'alert-type' => 'success',
        ]);

    }

    public function builder($id)
    {
        $menu = Menu::find($id);

        $routes = $this->getAllRoutes();

        return view('admin.menus.builder', compact('menu','routes'));
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
        $data['url'] = $data['urltype'] == 'diy' ? $data['diyurl'] : $data['localurl'];
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
        $data['url'] = $data['urltype'] == 'diy' ? $data['diyurl'] : $data['localurl'];
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


    public function generate_views(Request $request)
    {
        //$dataType = DataType::where('slug', '=', $slug)->first();
    }

    private function deleteFileIfExists($path)
    {
        if (Storage::exists($path)) {
            Storage::delete($path);
        }
    }
}
