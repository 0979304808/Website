<?php

namespace App\Repositories\Jlpt;

use App\Core\Repositories\BaseRepository;
use App\Models\Socials\JLPT;
use App\Repositories\Jlpt\Contract\JlptRepositoryInterface;
use File;
use App\Core\Traits\UploadTable;
class JlptRepository extends BaseRepository implements JlptRepositoryInterface {

    use UploadTable;
    protected $model;

    public function __construct(JLPT $jlpt)
    {
        parent::__construct($jlpt);
        $this->model = $jlpt;
    }

    public function deletePost($id){
        $jlpt = $this->model->find($id);
        $old_img = $jlpt->image;
        $del = $jlpt->delete();
        if($del){
            File::delete(public_path($old_img));
            return true;
        }else return false;
    }

    public function updatePost($params,$id){
        $new_params = $params;
        if(isset($new_params['image'])){
            unset($new_params['image']);
        }
        $update = $this->model->where('id',$id)->update($new_params);
        if($update){
            if(isset($params['image'])){
                $image = $params['image'];
                $jlpt = $this->model->where('id',$id)->first();
                //Xoá ảnh cũ
                $old_img = $jlpt->image;
                File::delete(public_path($old_img));
                //Thêm ảnh mới
                $filename = time().$image->getClientOriginalName();
                $disk = public_path('/uploads/images/jlpt/');
                $save_path = $this->saveImage($image, $filename, $disk);
                if($save_path){
                    $path = strstr($save_path,'/uploads');
                    $jlpt->image = $path;
                    $jlpt->save();
                }
            }
            return true;
        }else return false;
    }
}