<?php

namespace App\Http\Controllers\Admin;

use App\option;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OptionController extends Controller
{
    public function getOptions()
    {
        $options = option::all();
        return view('admin.options.edit', ['options' => $options]);
    }

    public function updateOptions(Request $request)
    {
        $options = option::all();
        foreach ($options as $option) {
            $option->option_value = $request->input($option->option_name);
            $option->save();
        }
        return redirect(route('admin.getOptions'))->withErrors(['عملیات با موفقیت انجام شد'], 'success');
    }
}
