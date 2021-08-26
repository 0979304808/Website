<?php

namespace App\Repositories\Partners;

use App\Core\Repositories\BaseRepository;
use App\Models\Partners\Partner;
use App\Repositories\Partners\Contract\PartnerRepositoryInterface;
use File;

class PartnerRepository extends BaseRepository implements PartnerRepositoryInterface {

    protected $model;

    public function __construct(Partner $partner)
    {
        parent::__construct($partner);
        $this->model = $partner;
    }

    public function createPartner($params){
        $new_params = $params;
        if(isset($new_params['logo'])){
            unset($new_params['logo']);
        }
        $add = Partner::create($new_params);
        if($add){
            //save image
            $logo = $params['logo'];
            $filename = time().$logo->getClientOriginalName();
            $disk = public_path('/uploads/images/partners/');
            $save_path = $this->saveImage($logo, $filename, $disk);
            if($save_path){
                $path = strstr($save_path,'/uploads');
                $add->logo = $path;
                $add->save();
            }
            return true;
        }else return false;

    }

    public function deletePartner($id){
        $partner = $this->model->find($id);
        $old_logo = $partner->logo;
        $del = $partner->delete();
        if($del){
            File::delete(public_path($old_logo));
            return true;
        }else return false;
    }

    public function updatePartner($params,$id){
        $new_params = $params;
        if(isset($new_params['logo'])){
            unset($new_params['logo']);
        }
        $update = $this->model->where('id',$id)->update($new_params);
        if($update){
            if(isset($params['logo'])){
                $logo = $params['logo'];
                $partner = $this->model->where('id',$id)->first();
                //Xoá ảnh cũ
                $old_logo = $partner->logo;
                File::delete(public_path($old_logo));
                //Thêm ảnh mới
                $filename = time().$logo->getClientOriginalName();
                $disk = public_path('/uploads/images/partners/');
                $save_path = $this->saveImage($logo, $filename, $disk);
                if($save_path){
                    $path = strstr($save_path,'/uploads');
                    $partner->logo = $path;
                    $partner->save();
                }
            }
            return true;
        }else return false;
    }

}