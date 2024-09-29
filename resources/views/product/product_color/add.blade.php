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
                <div class="card-body">
                    <form action="">
                        <div>
                            <label for="basiInput" class="form-label">Basic Input</label>
                            <input type="password" class="form-control" id="basiInput">
                        </div>
                        <div>
                            <label for="basiInput" class="form-label">Basic Input</label>
                            <input type="password" class="form-control" id="basiInput">
                        </div>
                        <div>
                            <label for="basiInput" class="form-label">Basic Input</label>
                            <input type="password" class="form-control" id="basiInput">
                        </div>

                        <div class="mt-3">
                            <button class="btn btn-success">Thêm mới</button>
                        </div>
                    </form>
                </div>
            </div>
        </div><!--end col-->
    </div>
@endsection

@push('scripts')
    
@endpush
