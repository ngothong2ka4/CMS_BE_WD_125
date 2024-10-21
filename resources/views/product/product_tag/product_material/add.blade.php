@extends('layouts.app-theme')


@push('scripts')
@endpush

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Thêm mới chất liệu</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('material.store') }}" method="POST">
                        @csrf
                        <div>
                            <label for="basiInput" class="form-label">Tên chất liệu</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="basiInput"
                                name="name" value="{{ old('name') }}">
                        </div>
                        <div class="mt-3">
                            <button type="submit" class="btn btn-success">Thêm mới</button>
                        </div>
                    </form>
                </div>
            </div>
        </div><!--end col-->
    </div>
@endsection

@push('scripts')
@endpush
