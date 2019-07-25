@extends('admin.layout.master')
@section('content')
    <div class="card">
        <div class="card-header">
            لیست دسترسی های گروه {{ $role->name }}
        </div>
        <div class="card-block">
            <form action="" method="post">
                @csrf
                @foreach($permissions as $permission)
                    <div class="col-md-4">
                        <input type="checkbox" name="permission[]"
                               {{ $role->permissions->contains($permission->id)?"checked":"" }} value="{{ $permission->id }}"
                               id="p-{{ $permission->id }}"/>
                        <label for="p-{{ $permission->id }}">{{ $permission->label }}</label>
                    </div>
                @endforeach
                <div class="clearfix"></div>
                <div class="col-md-12">
                    <button class="btn btn-success">بروزرسانی دسترسی ها</button>
                </div>
            </form>
        </div>
    </div>
@endsection