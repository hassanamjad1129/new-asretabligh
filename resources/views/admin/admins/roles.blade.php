@extends('admin.layout.master')
@section('content')
    <div class="card">
        <div class="card-header">
            لیست گروه های مدیر : {{ $admin->name }}
        </div>
        <div class="card-block">
            <form action="" method="post">
                @csrf
                @foreach($roles as $role)
                    <div class="col-md-4">
                        <input type="checkbox" name="role[]"
                               {{ $admin->roles->contains($role->id)?"checked":"" }} value="{{ $role->id }}"
                               id="r-{{ $role->id }}"/>
                        <label for="r-{{ $role->id }}">{{ $role->label }}</label>
                    </div>
                @endforeach
                <div class="clearfix"></div>
                <div class="col-md-12">
                    <button class="btn btn-success">بروزرسانی گروه ها</button>
                </div>
            </form>
        </div>
    </div>
@endsection