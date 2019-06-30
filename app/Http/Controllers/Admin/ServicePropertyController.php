<?php

namespace App\Http\Controllers\Admin;

use App\Service;
use App\ServiceProperty;
use App\ServiceValue;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class ServicePropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Service $service
     * @return Response
     */
    public function index(Service $service)
    {
        $serviceProperties = $service->ServiceProperties;
        return view('admin.services.properties.index', ['serviceProperties' => $serviceProperties, 'service' => $service]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Service $service
     * @return Factory|View
     */
    public function create(Service $service)
    {
        $serviceProperties = $service->ServiceProperties()->get();
        return view('admin.services.properties.create', ['service' => $service, 'serviceProperties' => $serviceProperties]);
    }

    public function servicePropertiesPicturePath()
    {
        $now = Carbon::now();
        $year = $now->year;
        $month = $now->month;
        $day = $now->day;
        $user_id = auth()->guard('admin')->user()->id;
        return "/ServiceProperties/{$user_id}/{$year}/{$month}/{$day}";
    }

    public function validateStore(Request $request)
    {
        return Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'nullable',
        ], [
            'name.required' => 'عنوان مشخصه الزامی است',
            'description.required' => 'توضیحات مشخصه الزامی است',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param Service $service
     * @return RedirectResponse|Redirector
     */
    public function store(Request $request, Service $service)
    {
        $validator = $this->validateStore($request);
        if ($validator->fails()) {
            return redirect(route('admin.serviceProperties.create', [$service]))->withErrors($validator, 'failed')->withInput();
        }
        if ($request->type == 2) {
            $flagIsNull = false;
            if ($request->answer) {
                foreach ($request->answer as $key => $value) {
                    if ($value == null) {
                        $flagIsNull = true;
                        break;
                    }
                }
                if ($flagIsNull == true) {
                    return redirect(route('admin.serviceProperties.create', [$service]))->withErrors('پر کردن تمامی فیلد ها برای پاسخ های مشخصه الزامی است ', 'failed')->withInput();
                } else {
                    $serviceProperties = new ServiceProperty();
                    $serviceProperties->name = $request->name;
                    $serviceProperties->type = 'selectable';
                    $serviceProperties->description = $request->description;
                    $serviceProperties->service_id = $service->id;
                    if ($request->dependency != 0)
                        $serviceProperties->value_id = $request->dependency;
                    $serviceProperties->save();
                    foreach ($request->answer as $key => $value) {
                        $serviceValues = new ServiceValue();
                        $serviceValues->name = $value;
                        $serviceValues->property_id = $serviceProperties->id;
                        $serviceValues->save();
                    }
                    $serviceAnswers = $serviceProperties->ServiceValues()->get();
                    if ($request->picture)
                        foreach ($request->picture as $key => $picture) {
                            if ($picture) {
                                $serviceAnswers[$key]->picture = $this->uploadFile($picture, $this->servicePropertiesPicturePath());
                                $serviceAnswers[$key]->update();
                            }
                        }
                    return redirect(route('admin.serviceProperties.index', [$service]))->withErrors('عملیات با موفقیت انجام شد', 'success');
                }
            } else {
                return redirect(route('admin.serviceProperties.create', [$service]))->withErrors(['پاسخ های مشخصه الزامی است'], 'failed')->withInput();
            }
        }
        $serviceProperty = new ServiceProperty();
        $serviceProperty->name = $request->name;
        $serviceProperty->type = 'input';
        $serviceProperty->description = $request->description;
        $serviceProperty->product_id = $service->id;
        $serviceProperty->save();
        return redirect(route('admin.serviceProperties.index', [$service]))->withErrors(['عملیات با موفقیت انجام شد'], 'success');
    }

    /**
     * Display the specified resource.
     *
     * @param ServiceProperty $serviceProperty
     * @return void
     */
    public function show(ServiceProperty $serviceProperty)
    {
        //
    }

    public function ServiceAnswer(ServiceValue $serviceValue)
    {
        return Storage::download($serviceValue->picture);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Service $service
     * @param ServiceProperty $serviceProperty
     * @return Factory|View
     */


    public function edit(Service $service, ServiceProperty $serviceProperty)
    {

        $serviceProperties = $service->ServiceProperties()->where('id', '<>', $serviceProperty->id);
        $serviceProperties = $serviceProperties->get();
        return view('admin.services.properties.edit', ['service' => $service, 'serviceProperties' => $serviceProperties, 'serviceProperty' => $serviceProperty]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Service $service
     * @param ServiceProperty $serviceProperty
     * @return Response
     */
    public function update(Request $request, Service $service, ServiceProperty $serviceProperty)
    {
        $validator = $this->validateStore($request);
        if ($validator->fails()) {
            return redirect(route('admin.serviceProperties.edit', [$service, $serviceProperty]))->withErrors($validator, 'failed')->withInput();
        }
        if ($serviceProperty->type == 'selectable') {
            $flagIsNull = false;
            $serviceValues = $serviceProperty->ServiceValues()->get();
            foreach ($serviceValues as $serviceValue) {
                if ($request->input('answer_' . $serviceValue->id) == null) {
                    $flagIsNull = true;
                    break;
                }
            }
            if ($request->answer)
                foreach ($request->answer as $key => $value) {
                    if ($value == null) {
                        $flagIsNull = true;
                        break;
                    }
                }
            if ($flagIsNull == true) {
                return redirect(route('admin.serviceProperties.edit', [$service, $serviceProperty]))->withErrors(['پر کردن تمامی فیلد ها برای پاسخ های مشخصه الزامی است '], 'failed')->withInput();
            } else {
                $serviceProperty->name = $request->name;
                $serviceProperty->description = $request->description;
                if ($request->dependency != 0) {
                    if (ServiceValue::find($request->dependency)->property_id == $serviceProperty->id)
                        return redirect(route('admin.serviceProperties.edit', [$service, $serviceProperty]))->withErrors(['وابسته سازی به پاسخ های مشخصه این مشخصه امکان پذیر نیست'], 'failed')->withInput();
                    $serviceProperty->value_id = $request->dependency;
                }
                $serviceProperty->update();
                if ($request->answer)
                    foreach ($request->answer as $value) {
                        $serviceValue = new ServiceValue();
                        $serviceValue->name = $value;
                        $serviceValue->property_id = $serviceProperty->id;
                        $serviceValue->save();
                    }
                foreach ($serviceValues as $item) {
                    $item->name = $request->input('answer_' . $item->id);
                    $item->update();
                }
                $serviceAnswers = $serviceProperty->ServiceValues()->get();
                if ($request->picture)
                    foreach ($request->picture as $key => $picture) {
                        if ($picture) {
                            $serviceAnswers[$key]->picture = $this->uploadFile($picture, $this->servicePropertiesPicturePath());
                            $serviceAnswers[$key]->update();
                        }
                    }
                return redirect(route('admin.serviceProperties.index', [$service]))->withErrors(['عملیات با موفقیت انجام شد'], 'success');
            }
        }
        $serviceProperty->name = $request->name;
        $serviceProperty->description = $request->description;
        $serviceProperty->update();
        return redirect(route('admin.serviceProperties.index', [$service]))->withErrors(['عملیات با موفقیت انجام شد'], 'success');
    }


    /**
     * @param Service $service
     * @param ServiceProperty $serviceProperty
     * @param ServiceValue $serviceValue
     * @return RedirectResponse|Redirector
     * @throws Exception
     */
    public function destroyValue(Service $service, ServiceProperty $serviceProperty, serviceValue $serviceValue)
    {
        if ($serviceProperty->ServiceValues()->get()->count() == 1)
            return redirect(route('admin.serviceProperties.edit', [$service, $serviceProperty]))->withErrors(['وجود حداقل یک پاسخ مشخصه الزامی میباشد'], 'failed');
        $serviceValue->delete();
        return redirect(route('admin.serviceProperties.edit', [$service, $serviceProperty]))->withErrors(['عملیات با موفقیت انجام شد'], 'success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Service $service
     * @param ServiceProperty $serviceProperty
     * @return RedirectResponse|Redirector
     * @throws Exception
     */
    public function destroy(Service $service, ServiceProperty $serviceProperty)
    {
        $serviceValues = $serviceProperty->ServiceValues()->get();
        foreach ($serviceValues as $key => $item) {
            $item->delete();
        }
        $serviceProperty->delete();
        return redirect(route('admin.serviceProperties.index', [$service]))->withErrors(['عملیات با موفقیت انجام شد'], 'success');
    }
}
