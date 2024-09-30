@extends('layouts.app-theme')


@push('scripts')
     
@endpush

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Cập nhật màu sắc sản phẩm</h5>
                </div>
                
                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        @php
                            toastr()->error($error)
                        @endphp
                    @endforeach
                @endif

                <div class="card-body">
                    <form action="{{ route('product_color.update', $productColor->id) }}" method="POST">
                        @csrf
                        @method("PATCH")
                        <div>
                            <label for="basiInput" class="form-label">Màu sắc</label>
                            <input type="text" class="form-control" id="basiInput" name="name" value="{{ $productColor->name }}">
                        </div>

                        <div class="mt-3">
                            <button class="btn btn-success" type="submit">Cập nhật</button>
                        </div>
                    </form>
                </div>
            </div>
        </div><!--end col-->
    </div>
@endsection

@push('scripts')
    
@endpush
