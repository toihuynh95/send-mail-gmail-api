<?php

namespace Modules\Template\Http\Controllers;

use App\Http\Controllers\BaseController;
use Modules\Template\Entities\Template;
use Modules\Template\Http\Requests\StoreTemplateRequest;
use Modules\Template\Http\Requests\UpdateTemplateRequest;

class TemplateController extends BaseController
{
    public function store(StoreTemplateRequest $request){
        $template_data = $request->dataOnly();
        $template = Template::create($template_data);
        return $this->responseSuccess($template, "Thêm thông email mẫu thành công!");
    }

    public function update(UpdateTemplateRequest $request, $template_id){
        $template = Template::find($template_id);
        if(is_null($template)){
            return $this->responseBadRequest('Email mẫu không tồn tại.');
        }
        $template_data = $request->dataOnly();
        $template->update($template_data);
        return $this->responseSuccess($template, "Cập nhật thông tin email mẫu thành công!");
    }

    public function destroy($template_id){
        $template = Template::find($template_id);
        if(is_null($template)){
            return $this->responseBadRequest('Email mẫu không tồn tại.');
        }
        $template->delete();
        return $this->responseSuccess($template, "Cập nhật thông tin email mẫu thành công!");
    }

    public function show(){
        $template = Template::orderBy('template_id', 'desc')->get();
        return datatables()->of($template)->toJson();
    }

    public function showID($template_id){
        $template = Template::find($template_id);
        if(is_null($template)){
            return $this->responseBadRequest('Email mẫu không tồn tại.');
        }
        return $this->responseSuccess($template, "Thông tin chi tiết của email mẫu.");
    }

    public function showAll(){
        $template = Template::orderBy('template_id', 'desc')->get();
        return $this->responseSuccess($template, 'Danh sách các mẫu email.');
    }
}
