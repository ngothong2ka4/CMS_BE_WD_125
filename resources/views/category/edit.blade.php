@extends('layouts.app-theme')


@push('scripts')
@endpush

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Chỉnh sửa danh mục</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('category.update', $category->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div>
                            <label for="basiInput" class="form-label">Tên danh mục</label>
                            <input type="text" class="form-control" id="basiInput" value="{{ $category->name }}"
                                name="name">
                        </div>
                        <div class="mt-3">
                            <button type="reset" class="btn btn-warning">Nhập lại</button>
                            <button type="submit" class="btn btn-success">Chỉnh sửa</button>
                        </div>
                    </form>
                </div>
            </div>
        </div><!--end col-->
    </div>
@endsection

@push('scripts')
@endpush
