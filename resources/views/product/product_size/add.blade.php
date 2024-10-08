@extends('layouts.app-theme')


@push('scripts')
@endpush

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Thêm mới kích thước</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('product_size.store') }}" method="POST">
                        @csrf
                        @method('POST')
                        <div>
                            <label for="basiInput" class="form-label">Tên kích thước</label>
                            <input type="text" value="{{old('name')}}" class="form-control @error('name') is-invalid @enderror" id="basiInput"
                                name="name">
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
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
