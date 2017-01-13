<?php

namespace App\Events;

use App\Models\Category;
use App\Models\DataType;
use App\Models\Seo;
use App\Models\Templete;
use App\Http\Controllers\Admin\Traits\ResourceManage;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class GenerateTpl
{
    use InteractsWithSockets, SerializesModels, ResourceManage;

    protected $templete;

    /**
     * GenerateTpl constructor.
     * @param Templete $templete
     */
    public function __construct(Templete $templete)
    {
        $this->templete = $templete;
    }

    /**
     * 获取当前改动模版的所有相关栏目
     * @return mixed
     */
    public function getAllCategory()
    {
        $categories =  Category::where(['template' => $this->templete->title, 'model' => $this->templete->model])->get();
        foreach ($categories as $category) {
            $seo = Seo::where(['seo_type' => 'category', 'associ_id' => $category->id])->first()->toArray();
            $this->generateCategory($this->templete, $category->toArray(), $category->id, $seo);
        }
    }

    public function getAllContent()
    {
        $dataType = DataType::where(['name' => $this->templete->model])->first(['model_name','slug']);
        //循环当前模型下的每一条数据
        $model = $dataType->model_name;
        foreach ($model::all() as $item) {
            $this->generateContent($dataType->slug.'/'.$item->id, $item->getCategory->getTemplete, $item->toArray());
        }
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
