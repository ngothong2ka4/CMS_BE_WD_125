@extends('layouts.app-theme')


@push('scripts')

@endpush

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Thêm mới màu sắc sản phẩm</h5>
            </div>

            @if ($errors->any())
            @foreach ($errors->all() as $error)
            @php
            toastr()->error($error)
            @endphp
            @endforeach
            @endif

            <div class="card-body">
                <form action="{{ route('product_color.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="basiInput" class="form-label">Màu sắc</label>
                        <input type="text" class="form-control" id="basiInput" name="name" value="{{old('name')}}">
                    </div>
                    <div class="mb-3">
                        <label for="basiInput" class="form-label">Chọn màu</label>
                        <input type="color" name="code" class="form-control form-control-color" title="Chọn màu của bạn" value="{{old('code')}}">

                    </div>
                    <div class="mt-3">
                        <button class="btn btn-success" type="submit">Thêm mới</button>
                    </div>
                </form>
            </div>
        </div>
    </div><!--end col-->
</div>
@endsection

@push('scripts')

@endpush