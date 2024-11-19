@extends('layouts.app-theme')


@push('scripts')
@endpush

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Thêm mới Combo</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('combo.store') }}" method="POST">
                        @csrf
                        <div>
                            <label class="form-label">Tên combo</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                name="name" value="{{ old('name') }}">
                        </div>
                        <div class="d-flex my-3">
                            <label for="basiInput" class="form-label">Chọn sản phẩm </label>
                            <div class="mx-3">
                                <select id="id_product" name="id_product[]"  class="form-control" multiple="multiple" style="width: 100%;">
                                    @foreach ($products as $product)
                                    <option value="{{ $product->id }}" 
                                        {{ in_array($product->id, old('id_product', [])) ? 'selected' : '' }}>
                                        {{ $product->name }}
                                    </option>
                                @endforeach
                                </select>
                            </div>
                        </div>
                        <div>
                            <label class="form-label">Giá</label>
                            <input type="number" class="form-control @error('price') is-invalid @enderror" 
                                name="price" value="{{ old('price') }}">
                        </div>
                        <div>
                            <label class="form-label">Mô tả</label>
                            <textarea name="description" id="" class="form-control" cols="30" rows="2">{{ old('description') }}</textarea>
                            {{-- <input type="text" class="form-control @error('description') is-invalid @enderror" 
                                name="" value=""> --}}
                        </div>
                        <div>
                            <label class="form-label">Số lượng</label>
                            <input type="number" class="form-control @error('quantity') is-invalid @enderror" 
                                name="quantity" value="{{ old('quantity') }}">
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
