@extends('admin.layout.master')
@section('content')

    <div class="card">
        <div class="card-header">
            <h5>برترین مشتری ها</h5>
        </div>
        <div class="card-block">
            <a href="{{ route('admin.bestCustomers.create') }}" class="btn btn-primary">افزودن به مشتریان برتر</a>
            <table class="table table table-striped table-bordered table-hover datatable" id="dataTables-example">
                <thead>
                <tr>
                    <th>#</th>
                    <th>تصویر</th>
                    <th>عملیات</th>
                </tr>
                </thead>
                <tbody>
                <?php $i = 1; ?>
                @foreach($bestCustomers as $bestCustomer)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td><img src="{{ asset($bestCustomer->image) }}"
                                 class="img-responsive img-thumbnail"
                                 style="width: 100px"/></td>
                        <td>
                            <form action="{{ route('admin.bestCustomers.destroy',[$bestCustomer]) }}" method="post">
                                @csrf
                                @method('delete')
                                <button class="btn btn-danger deleteLink">
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection