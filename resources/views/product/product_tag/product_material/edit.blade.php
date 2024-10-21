@extends('layouts.app-theme')


@push('scripts')
@endpush

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Chỉnh sửa chất liệu</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('material.update', $material->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div>
                            <label for="basiInput" class="form-label">Tên chất liệu</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="basiInput"
                                value="{{ $material->name }}" name="name">

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
