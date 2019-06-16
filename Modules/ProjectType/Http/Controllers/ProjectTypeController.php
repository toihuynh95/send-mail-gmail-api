<?php

namespace Modules\ProjectType\Http\Controllers;

use App\Http\Controllers\BaseController;
use Modules\Project\Entities\Project;
use Modules\ProjectType\Entities\ProjectType;
use Modules\ProjectType\Http\Requests\StoreProjectTypeRequest;
use Modules\ProjectType\Http\Requests\UpdateProjectTypeRequest;

class ProjectTypeController extends BaseController
{
    public function store(StoreProjectTypeRequest $request){
        $project_type_data = $request->dataOnly();
        $project_type = ProjectType::create($project_type_data);
        return $this->responseSuccess($project_type, "Thêm loại dự án thành công!");
    }

    public function update(UpdateProjectTypeRequest $request, $project_type_id){
        $project_type = ProjectType::find($project_type_id);
        if(is_null($project_type)){
            return $this->responseBadRequest('Loại dự án không tồn tại.');
        }
        $project_type_data = $request->dataOnly();
        $project_type->update($project_type_data);
        return $this->responseSuccess($project_type, "Cập nhật thông tin loại dự án thành công!");
    }

    public function destroy($project_type_id){
        $project_type = ProjectType::find($project_type_id);
        if(is_null($project_type)){
            return $this->responseBadRequest('Loại dự án không tồn tại.');
        }
        $project_type_count = Project::where('project_type_id', $project_type_id)->count();
        if($project_type_count > 0){
            return $this->responseBadRequest('Không được xóa. Vẫn còn dự án trong loại này!');
        }
        $project_type->delete();
        return $this->responseSuccess($project_type, "Cập nhật thông tin loại dự án thành công!");
    }

    public function show(){
        $project_type = ProjectType::orderBy('project_type_id', 'desc')->get();
        return datatables()->of($project_type)->toJson();
    }

    public function showID($project_type_id){
        $project_type = ProjectType::find($project_type_id);
        if(is_null($project_type)){
            return $this->responseBadRequest('Loại dự án không tồn tại.');
        }
        return $this->responseSuccess($project_type, "Thông tin chi tiết của loại dự án.");
    }

    public function showAll(){
        $project_type = ProjectType::orderBy('project_type_id', 'desc')->get();
        return $this->responseSuccess($project_type, 'Danh sách các loại dự án.');
    }
}
